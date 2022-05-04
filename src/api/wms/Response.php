<?php

namespace WmsApi;

require_once __DIR__."/Session.php";
require_once __DIR__."/Account.php";

class Response {
    /**
     * 汎用エラーレスポンスを作成します。
     * @param string $error_id エラーID
     * @param string|null $reason エラー理由
     * @return string 生成されたJSONレスポンス
     */
    public static function makeCommonErrorResponse(string $error_id, string $reason = null): string {
        $json_object["succeed"] = false;
        $json_object["error"]["error-id"] = $error_id;
        if (!empty($reason)) $json_object["error"]["reason"] = $reason;
        return json_encode($json_object);
    }

    /**
     * 汎用成功レスポンスを作成します。
     * @param string|null $additional_info 追加情報
     * @return string 生成されたJSONレスポンス
     */
    public static function makeCommonSuccessResponse(string $additional_info = null): string {
        $json_object["succeed"] = true;
        if (!empty($additional_info)) $json_object["additional-info"] = $additional_info;
        return json_encode($json_object);
    }

    /**
     *
     * @param string $id
     * @param string $username
     * @param string $permission
     * @return string
     */
    public static function makeLoginSuccessResponse(string $id, string $username, string $permission): string {
        $json_object["succeed"] = true;
        $json_object["userid"] = $id;
        $json_object["username"] = $username;
        $json_object["permission"] = $permission;
        return json_encode($json_object);
    }

    public static function makeLoggedinUserInfo(): string {
        $userinfo = Account::getUserInfo(Session::getLoginUserID());
        if (!$userinfo) {
            $json_object["loggedin"] = false;
            return json_encode($json_object);
        } else {
            $json_object["loggedin"] = true;
            $json_object["userid"] = $userinfo["userid"];
            $json_object["username"] = $userinfo["username"];
            $json_object["permission"] = $userinfo["permission"];
            return json_encode($json_object);
        }
    }

    public static function makeApiVersionResponse(): string {
        $json_object["succeed"] = true;
        $json_object["api-version"] = WMS_API_VERSION;
        return json_encode($json_object);
    }
}