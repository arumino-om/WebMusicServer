<?php

namespace WmsApi;

class Session {
    /**
     * ログインユーザーを設定します。
     * @param string $userid セットするユーザーID
     * @return void
     */
    public static function setLoginUserID(string $userid): void {
        $_SESSION["userid"] = $userid;
    }

    /**
     * セッションを破棄します。
     * @return void
     */
    public static function removeSession(): void {
        $_SESSION = null;
        if (isset($_COOKIE["WMS_SESSION"])) {
            setcookie("WMS_SESSION", '', time() - 1800, '/');
        }
    }

    /**
     * ログイン中のユーザーIDを調べます。
     * @return bool|string ログインしている場合はユーザーID、ログインしていない場合は false が返ります。
     */
    public static function getLoginUserID(): bool|string {
        if (empty($_SESSION["userid"])) return false;
        else return $_SESSION["userid"];
    }
}