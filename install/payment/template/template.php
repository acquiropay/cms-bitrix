<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/** @var array $params */

?>
<form id="pay" name="pay" method="GET" action="<?= $params["URL"] ?>">
    <input type="hidden" name="product_id" value="<?= $params["ACQUIROPAY_PRODUCT_ID"] ?>">
    <input type="hidden" name="product_name" value="<?= $params["ACQUIROPAY_PRODUCT_NAME"] ?>">
    <input type="hidden" name="token" value="<?= $params["TOKEN"] ?>">
    <input type="hidden" name="amount" value="<?= $params["PAYMENT_SHOULD_PAY"] ?>">
    <input type="hidden" name="cf" value="<?= $params["PAYMENT_ID"] ?>">
    <input type="hidden" name="cb_url" value="<?= $params["ACQUIROPAY_RESULT_URL"] ?>">
    <input type="hidden" name="ok_url" value="<?= $params["ACQUIROPAY_SUCCESS_URL"] ?>">
    <input type="hidden" name="ko_url" value="<?= $params["ACQUIROPAY_FAIL_URL"] ?>">
    <input type="hidden" name="first_name" value="<?= $params["BUYER_PERSON_FIRST_NAME"] ?>">
    <input type="hidden" name="last_name" value="<?= $params["BUYER_PERSON_LAST_NAME"] ?>">
    <input type="hidden" name="email" value="<?= $params["BUYER_PERSON_EMAIL"] ?>">
    <input type="hidden" name="phone" value="<?= $params["BUYER_PERSON_PHONE"] ?>">
    <?php if (isset($params["RECEIPT"])): ?>
        <input type="hidden" name="receipt" value="<?= htmlspecialchars($params["RECEIPT"]) ?>">
    <?php endif; ?>

    <input type="submit" value="<?= Loc::getMessage("SALE_HPS_ACQUIROPAY_BUTTON") ?>">
</form>