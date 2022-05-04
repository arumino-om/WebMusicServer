<?php
namespace WmsApi;
require_once __DIR__."/Database.php";
require_once __DIR__."/Session.php";

class Account {
    /**
     * ユーザー認証情報が正しいか確認します。
     * @param string $userid ユーザーID
     * @param string $password_hash パスワード (ハッシュ済み)
     * @return bool ユーザー認証情報が正しいかどうか
     */
    public static function isCorrectUserAuthInfo(string $userid, string $password_hash): bool {
        $stmt = Database::prepareDatabaseConnection("SELECT * FROM users WHERE userid = :userid AND password_hash = :password_hash");
        if (!$stmt) return false;

        $stmt->bindValue(":userid", $userid);
        $stmt->bindValue(":password_hash", $password_hash);
        $stmt->execute();
        $user = $stmt->fetch();
        if (!$user || count($user) <= 0) return false;
        else return true;
    }

    /**
     * ユーザーを作成します。
     * @param string $userid ユーザーID
     * @param string $password_hash パスワード (ハッシュ済み)
     * @param string $permission パーミッション
     * @return bool ユーザーが作成できたかどうか
     */
    public static function createUser(string $userid, string $username, string $password_hash, string $permission): bool {
        $stmt = Database::prepareDatabaseConnection("INSERT INTO users VALUES (0, :userid, :username, :password_hash, :permission)");
        if (!$stmt) return false;

        $stmt->bindValue(":userid", $userid);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password_hash", $password_hash);
        $stmt->bindValue(":permission", $permission);
        $stmt->execute();
        return true;
    }

    public static function deleteAccount(string $userid, string $password_hash) {

    }

    /**
     * ユーザー情報を取得します。
     * @param string $userid 取得するユーザーID
     * @return bool|array 成功した場合は連想配列、失敗した場合は false が返ります。
     */
    public static function getUserInfo(string $userid): bool|array {
        $stmt = Database::prepareDatabaseConnection("SELECT * FROM users WHERE userid = :userid");
        if (!$stmt) return false;

        $stmt->bindValue(":userid", $userid);
        $stmt->execute();
        $user = $stmt->fetch();
        if (!$user || count($user) <= 0) return false;

        return $user;
    }

    /**
     * ユーザーが管理者ユーザーかどうか調べます。
     * @param string $userid 調べるユーザーID
     * @return bool 管理者アカウントかどうか
     */
    public static function isAdminAccount(string $userid): bool {
        $userinfo = self::getUserInfo($userid);
        if ($userinfo["permission"] == "admin") return true;
        else return false;
    }
}