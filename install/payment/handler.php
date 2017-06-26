<?php

namespace Sale\Handlers\PaySystem;

use Bitrix\Main\Error;
use Bitrix\Main\Request;
use Bitrix\Sale\Payment;
use Bitrix\Sale\PaySystem;
use Bitrix\Sale\PriceMaths;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\PaySystem\ServiceResult;

Loc::loadMessages(__FILE__);

class AcquiropayHandler extends PaySystem\ServiceHandler
{
    /**
     * That`s fields says is it our request
     *
     * @return array
     */
    public static function getIndicativeFields()
    {
        return array("sign", "status", "datetime", "cf");
    }

    /**
     * @param Payment $payment
     * @param Request|null $request
     * @return ServiceResult
     */
    public function initiatePay(Payment $payment, Request $request = null)
    {
        $extraParams = array(
            "URL" => $this->getUrl($payment, "pay"),
            "TOKEN" => $this->generateToken($payment),
            "PAYMENT_SHOULD_PAY" => $this->convertToFixedString(
                $this->getBusinessValue($payment, "PAYMENT_SHOULD_PAY")
            ),
        );

        if ($this->shouldIncludeReceipt($payment)) {
            $extraParams["RECEIPT"] = $this->generateReceipt($payment);
        }

        $this->setExtraParams($extraParams);

        return $this->showTemplate($payment, "template");
    }

    /**
     * @return array
     */
    public function getCurrencyList()
    {
        return array("RUB");
    }

    /**
     * @param Payment $payment
     * @param Request $request
     * @return mixed
     */
    public function processRequest(Payment $payment, Request $request)
    {
        /** @var PaySystem\ServiceResult $serviceResult */
        $serviceResult = new PaySystem\ServiceResult();

        if (!$this->checkToken($payment, $request)) {
            $serviceResult->addError(new Error("Invalid token in request"));

            return $serviceResult;
        }

        if (!$this->checkSum($payment, $request)) {
            $serviceResult->addError(new Error("Invalid sum"));

            return $serviceResult;
        }

        if ($request->get("status") !== "OK") {
            $serviceResult->addError(new Error("Invalid status payment = " . $request->get("status")));

            return $serviceResult;
        }


        $psDescription = "Successful payment transaction";
        $psMessage = "Success";

        $psFields = array(
            "PS_STATUS" => "Y",
            "PS_STATUS_CODE" => "-",
            "PS_STATUS_DESCRIPTION" => $psDescription,
            "PS_STATUS_MESSAGE" => $psMessage,
            "PS_SUM" => $request->get("amount"),
            "PS_CURRENCY" => $payment->getField("CURRENCY"),
            "PS_RESPONSE_DATE" => new DateTime(),
        );

        if (!$payment->isPaid() && $this->getBusinessValue($payment, "PS_CHANGE_STATUS_PAY") == "Y") {
            $serviceResult->setOperationType(PaySystem\ServiceResult::MONEY_COMING);
            $serviceResult->setPsData($psFields);
        }

        return $serviceResult;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPaymentIdFromRequest(Request $request)
    {
        return $request->get("cf");
    }

    protected function getUrlList()
    {
        return array(
            "pay" => array(
                self::TEST_URL => "https://secure.acqp.co/",
                self::ACTIVE_URL => "https://secure.acquiropay.com/",
            ),
        );
    }

    protected function isTestMode(Payment $payment = null)
    {
        return $this->getBusinessValue($payment, "PS_IS_TEST") === "Y";
    }

    protected function generateToken(Payment $payment = null)
    {
        return md5(
            $this->getBusinessValue($payment, "ACQUIROPAY_MERCHANT_ID") .
            $this->getBusinessValue($payment, "ACQUIROPAY_PRODUCT_ID") .
            $this->convertToFixedString($this->getBusinessValue($payment, "PAYMENT_SHOULD_PAY")) .
            $this->getBusinessValue($payment, "PAYMENT_ID") .
            $this->getBusinessValue($payment, "ACQUIROPAY_SECRET_WORD")
        );
    }

    /**
     * @param Payment $payment
     * @param Request $request
     *
     * @return bool
     */
    protected function checkToken(Payment $payment, Request $request)
    {
        return $this->hash_equals(
            md5(
                $this->getBusinessValue($payment, "ACQUIROPAY_MERCHANT_ID") .
                $request->get('payment_id') .
                $request->get('status') .
                $request->get('cf') .
                $this->getBusinessValue($payment, "ACQUIROPAY_SECRET_WORD")
            ),
            $request->get("sign")
        );
    }

    protected function hash_equals($str1, $str2)
    {
        if (strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for ($i = strlen($res) - 1; $i >= 0; $i--) {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }

    protected function shouldIncludeReceipt(Payment $payment = null)
    {
        return $this->getBusinessValue($payment, "ACQUIROPAY_WITH_BILL") === "Y";
    }

    protected function generateReceipt(Payment $payment = null)
    {
        $receipt = array();

        /** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
        $paymentCollection = $payment->getCollection();

        /** @var \Bitrix\Sale\BasketItem $item */
        foreach ($paymentCollection->getOrder()->getBasket()->getBasketItems() as $item) {
            $receipt["items"][] = array(
                "sum" => $this->convertToFixedString($item->getFinalPrice()),
                "tax" => $this->resolveTax($item),
                "name" => $item->getField("NAME"),
                "price" => $this->convertToFixedString($item->getBasePrice()),
                "quantity" => $this->convertToFixedString($item->getQuantity()),
            );
        }

        return json_encode($receipt);
    }

    /**
     * @param \Bitrix\Sale\BasketItem $item
     * @return string
     */
    protected function resolveTax($item)
    {
        if (!$item->isVatInPrice() && ((float)$item->getVatRate() === 0)) {
            return "none";
        }

        switch ((float)$item->getVatRate()) {
            case 0:
                return "vat0";
            case 0.10:
                return "vat10";
            case 0.18:
                return "vat18";
            default:
                return "none";
        }
    }

    /**
     * @param Payment $payment
     * @param Request $request
     *
     * @return bool
     */
    protected function checkSum(Payment $payment, Request $request)
    {
        $paymentShouldPay = PriceMaths::roundByFormatCurrency($this->getBusinessValue($payment, "PAYMENT_SHOULD_PAY"), $payment->getField("CURRENCY"));
        $paymentAmount = PriceMaths::roundByFormatCurrency($request->get("amount"), $payment->getField("CURRENCY"));

        return $paymentShouldPay === $paymentAmount;
    }

    protected function convertToFixedString($value)
    {
        return number_format($value, 2, '.', '');
    }
}