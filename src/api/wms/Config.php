<?php

namespace WmsApi;

include_once __DIR__."/Database.php";

class Config {
    private static function getConfigValueFromDatabase(string $name): mixed {
        $stmt = Database::prepareDatabaseConnection("SELECT config_value FROM config WHERE name = :name");
        $stmt->bindValue(":name", $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getString(string $name): string {
        return self::getConfigValueFromDatabase($name)["config_value"];
    }

    public static function getBool(string $name): bool {
        $value = self::getConfigValueFromDatabase($name)["config_value"] ?? false;
        if ($value === true || $value === "true" || $value === "1") return true;
        else return false;
    }
}