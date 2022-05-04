<?php

namespace WmsApi;

class InitWmsApi {
    public static function init() {
        self::initConstantValues();
    }

    private static function initConstantValues() {
        define("WMS_API_VERSION", "0.0.0-dev");

        // エラーコードを定義
        define("WMS_ERROR_SYSTEM_ERROR", "system-error");
        define("WMS_ERROR_NOT_LOGGED_IN", "not-loggedin");
        define("WMS_ERROR_NOT_PERMITTED", "not-permitted");
        define("WMS_ERROR_NOT_ENOUGH_PARAM", "not-enough-param");
        define("WMS_ERROR_INCORRECT_AUTH_INFO", "incorrect-auth-info");
        define("WMS_ERROR_BAD_REQUEST", "bad-request");
    }
}