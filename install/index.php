<?php

global $MESS;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class acquiropay_payment extends CModule
{
    var $MODULE_ID = "acquiropay.payment";
    var $MODULE_GROUP_RIGHTS = "Y";

    function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__ . "/version.php");

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->PARTNER_NAME = Loc::getMessage("ACQUIROPAY_PARTNER_NAME");
        $this->PARTNER_URI = "http://acquiropay.ru/";

        $this->MODULE_NAME = Loc::getMessage("ACQUIROPAY_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("ACQUIROPAY_MODULE_DESCRIPTION");
    }

    /**
     * Installing our module
     */
    function DoInstall()
    {
        $this->InstallFiles();

        RegisterModule($this->MODULE_ID);
    }

    /**
     * Removing our module
     */
    function DoUninstall()
    {
        UnRegisterModule($this->MODULE_ID);

        $this->UnInstallFiles();
    }

    function InstallFiles()
    {
        # /bitrix/php_interface/include/sale_payment

        CopyDirFiles(
            __DIR__ . "/payment/",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/sale_payment/acquiropay", true, true
        );

        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx("/bitrix/php_interface/include/sale_payment/acquiropay");

        return true;
    }
}
