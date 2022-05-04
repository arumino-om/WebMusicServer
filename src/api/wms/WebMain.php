<?php
namespace WmsApi;

require_once __DIR__."/InitWmsApi.php";
require_once __DIR__."/Response.php";
require_once __DIR__."/Account.php";
require_once __DIR__."/Session.php";
require_once __DIR__."/Config.php";
include_once __DIR__."/../CoreConfig.php";

class WebMain {
    public function __construct() {
        session_name("WMS_SESSION");
        session_start();
        InitWmsApi::init();
        header("Content-Type: application/json;charset=UTF-8");
    }

    public function account(): void {
        if ($_SERVER["REQUEST_METHOD"] == "GET") exit(Response::makeLoggedinUserInfo());
        if ($_SERVER["REQUEST_METHOD"] != "POST") $this->returnErrorAndExit(400, WMS_ERROR_BAD_REQUEST);
        if (empty($_POST["type"])) $this->returnErrorAndExit(400, WMS_ERROR_NOT_ENOUGH_PARAM);

        switch ($_POST["type"]) {
            // ログイン
            case "login":
                if (!$this->hasAuthInfo()) $this->returnErrorAndExit(400, WMS_ERROR_NOT_ENOUGH_PARAM);
                if (Account::isCorrectUserAuthInfo($_POST["userid"], $_POST["password"])) {
                    // ログイン成功
                    Session::setLoginUserID($_POST["userid"]);
                    echo Response::makeCommonSuccessResponse();
                } else {
                    // ログイン失敗
                    http_response_code(401);
                    echo Response::makeCommonErrorResponse(WMS_ERROR_INCORRECT_AUTH_INFO, "incorrect id or password or both.");
                }
                break;

            // アカウント作成
            case "create":
                // 設定で許可されている、またはadminユーザーでログインしている場合は作成できるようにする。
                if (Config::getBool("allow-create-user") || Account::isAdminAccount(Session::getLoginUserID())) {
                    if (!$this->hasUserCreateRequiredParams()) $this->returnErrorAndExit(400, WMS_ERROR_NOT_ENOUGH_PARAM);

                    if (Account::getUserInfo($_POST["userid"])) {
                        $this->returnErrorAndExit(400, WMS_ERROR_BAD_REQUEST, "already exists.");
                    }

                    $permission = "guest";
                    if (Account::isAdminAccount(Session::getLoginUserID()) && !empty($_POST["permission"])) $permission = $_POST["permission"];
                    Account::createUser($_POST["userid"], $_POST["username"], $_POST["password"], $permission);
                } else {
                    http_response_code(403);
                    echo Response::makeCommonErrorResponse(WMS_ERROR_NOT_PERMITTED);
                }
                break;

            // アカウント削除
            case "remove":
                //TODO: ユーザー削除を実装する
                break;

            // ログアウト
            case "logout":
                // ログインしていない場合はエラーを返す
                if (!Session::getLoginUserID()) $this->returnErrorAndExit(401, WMS_ERROR_NOT_LOGGED_IN);

                Session::removeSession();
                echo Response::makeCommonSuccessResponse();
                break;

            // 何にも該当しない場合は type が正しくない
            default:
                $this->returnErrorAndExit(400, WMS_ERROR_BAD_REQUEST);
                break;
        }
    }

    private function hasAuthInfo(): bool {
        if (!empty($_POST["userid"]) && !empty($_POST["password"])) return true;
        else return false;
    }

    private function hasUserCreateRequiredParams(): bool {
        if (!empty($_POST["userid"]) || !empty($_POST["username"]) || !empty($_POST["password"])) {
            return true;
        } else {
            return false;
        }
    }

    private function returnErrorAndExit(int $status_code, string $error_id, string $reason = null) {
        http_response_code($status_code);
        exit(Response::makeCommonErrorResponse($error_id, $reason));
    }
}