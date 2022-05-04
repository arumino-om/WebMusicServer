<?php
namespace WmsApi;

use PDO, PDOStatement;

class Database {
    public static function prepareDatabaseConnection(string $sql): bool|PDOStatement {
        global $_wmsGlobal;
        if (!isset($_wmsGlobal["database"]["dsn"]) || !isset($_wmsGlobal["database"]["user"]) || !isset($_wmsGlobal["database"]["password"]) ) {
            return false;
        }
        $pdo = new PDO($_wmsGlobal["database"]["dsn"], $_wmsGlobal["database"]["user"], $_wmsGlobal["database"]["password"]);
        return $pdo->prepare($sql);
    }
}