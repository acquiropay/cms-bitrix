<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$description = array(
//    "RETURN" => Loc::getMessage("SALE_HPS_YANDEX_RETURN"),
//    "RESTRICTION" => Loc::getMessage("SALE_HPS_YANDEX_RESTRICTION"),
//    "COMMISSION" => Loc::getMessage("SALE_HPS_YANDEX_COMMISSION"),
    "MAIN" => Loc::getMessage("SALE_HPS_ACQUIROPAY_DESCRIPTION"),
);

$data = array(
    "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_NAME"),
    "CODES" => array(
        "PS_IS_TEST" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_TEST"),
            "GROUP" => "GENERAL_SETTINGS",
            "INPUT" => array(
                "TYPE" => "Y/N",
            ),
        ),
        "PS_CHANGE_STATUS_PAY" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_CHANGE_STATUS_PAY"),
            "GROUP" => "GENERAL_SETTINGS",
            "INPUT" => array(
                "TYPE" => "Y/N",
            ),
        ),

        "ACQUIROPAY_MERCHANT_ID" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_MERCHANT_ID"),
            "GROUP" => Loc::getMessage("SALE_HPS_CONNECT_SETTINGS_ACQUIROPAY"),
        ),
        "ACQUIROPAY_PRODUCT_ID" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_PRODUCT_ID"),
            "GROUP" => Loc::getMessage("SALE_HPS_CONNECT_SETTINGS_ACQUIROPAY"),
        ),
        "ACQUIROPAY_PRODUCT_NAME" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_PRODUCT_NAME"),
            "GROUP" => Loc::getMessage("SALE_HPS_CONNECT_SETTINGS_ACQUIROPAY"),
        ),
        "ACQUIROPAY_SECRET_WORD" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_SECRET_WORD"),
            "GROUP" => Loc::getMessage("SALE_HPS_CONNECT_SETTINGS_ACQUIROPAY"),
        ),
        "ACQUIROPAY_RESULT_URL" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_URL"),
            "GROUP" => Loc::getMessage("SALE_HPS_CONNECT_SETTINGS_ACQUIROPAY"),
            "DEFAULT" => array(
                "PROVIDER_KEY" => "VALUE",
                "PROVIDER_VALUE" => "http://{$_SERVER['HTTP_HOST']}/bitrix/tools/sale_ps_result.php",
            ),
        ),
        "ACQUIROPAY_SUCCESS_URL" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_URL_OK"),
            "GROUP" => Loc::getMessage("SALE_HPS_CONNECT_SETTINGS_ACQUIROPAY"),
            "DEFAULT" => array(
                "PROVIDER_KEY" => "VALUE",
                "PROVIDER_VALUE" => "http://{$_SERVER['HTTP_HOST']}/personal/order/",
            ),
        ),
        "ACQUIROPAY_FAIL_URL" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_URL_ERROR"),
            "GROUP" => Loc::getMessage("SALE_HPS_CONNECT_SETTINGS_ACQUIROPAY"),
            "DEFAULT" => array(
                "PROVIDER_KEY" => "VALUE",
                "PROVIDER_VALUE" => "http://{$_SERVER['HTTP_HOST']}/personal/order/",
            ),
        ),
        "ACQUIROPAY_WITH_BILL" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_BILL"),
            "GROUP" => Loc::getMessage("SALE_HPS_CONNECT_SETTINGS_ACQUIROPAY"),
            "INPUT" => array(
                "TYPE" => "Y/N",
            ),
        ),

        "PAYMENT_ID" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_PAYMENT_ID"),
            "GROUP" => "PAYMENT",
            "DEFAULT" => array(
                "PROVIDER_KEY" => "PAYMENT",
                "PROVIDER_VALUE" => "ID",
            ),
        ),
        "PAYMENT_SHOULD_PAY" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_SHOULD_PAY"),
            "GROUP" => "PAYMENT",
            "DEFAULT" => array(
                "PROVIDER_KEY" => "PAYMENT",
                "PROVIDER_VALUE" => "SUM",
            ),
        ),

        "BUYER_PERSON_PHONE" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_PHONE"),
            "GROUP" => "BUYER_PERSON",
            "DEFAULT" => array(
                "PROVIDER_KEY" => "USER",
                "PROVIDER_VALUE" => "PERSONAL_MOBILE",
            ),
        ),
        "BUYER_PERSON_EMAIL" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_EMAIL"),
            "GROUP" => "BUYER_PERSON",
            "DEFAULT" => array(
                "PROVIDER_KEY" => "USER",
                "PROVIDER_VALUE" => "EMAIL",
            ),
        ),
        "BUYER_PERSON_FIRST_NAME" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_FIRST_NAME"),
            "GROUP" => "BUYER_PERSON",
            "DEFAULT" => array(
                "PROVIDER_KEY" => "USER",
                "PROVIDER_VALUE" => "NAME",
            ),
        ),
        "BUYER_PERSON_LAST_NAME" => array(
            "NAME" => Loc::getMessage("SALE_HPS_ACQUIROPAY_LAST_NAME"),
            "GROUP" => "BUYER_PERSON",
            "DEFAULT" => array(
                "PROVIDER_KEY" => "USER",
                "PROVIDER_VALUE" => "LAST_NAME",
            ),
        ),
    ),
);