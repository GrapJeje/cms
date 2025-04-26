<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            global $dbHost, $dbName, $dbUser, $dbPass;
            require 'config.php';

            try {
                self::$pdo = new PDO(
                    "mysql:host=".$dbHost.";dbname=".$dbName.";charset=utf8mb4",
                    $dbUser,
                    $dbPass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    public static function all($table): array {
        $pdo = self::getConnection();

        try {
            $stmt = $pdo->query("SELECT * FROM `$table`");
            return $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function allByUserId($table, $userId): array {
        $pdo = self::getConnection();

        if (empty($userId)) return [];

        try {
            // Voeg userId toe aan de conditions
            $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `userId` = :userId");
            $stmt->execute(['userId' => $userId]);

            $result = $stmt->fetchAll();
            return empty($result) ? [] : (count($result) === 1 ? $result[0] : $result);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function get($table, $conditions): array {
        $pdo = self::getConnection();
        if (empty($conditions)) return false;

        try {
            $where = implode(" AND ", array_map(fn($k) => "`$k` = :$k", array_keys($conditions)));
            $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE $where");
            $stmt->execute($conditions);

            $result = $stmt->fetchAll();
            return empty($result) ? [] : (count($result) === 1 ? $result[0] : $result);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function search($table, $conditions, $operators = []): array {
        $pdo = self::getConnection();
        if (empty($conditions)) return self::all($table);

        try {
            $where = implode(" AND ", array_map(
                fn($k) => "`$k` " . ($operators[$k] ?? '=') . " :$k",
                array_keys($conditions)
            ));

            $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE $where");
            $stmt->execute($conditions);

            return $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function delete($table, $conditions): bool {
        $pdo = self::getConnection();
        if (empty($conditions)) return false;

        try {
            $where = implode(" AND ", array_map(fn($k) => "`$k` = :$k", array_keys($conditions)));
            $stmt = $pdo->prepare("DELETE FROM `$table` WHERE $where");
            return $stmt->execute($conditions);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function update($table, $data, $conditions): bool {
        $pdo = self::getConnection();
        if (empty($data) || empty($conditions)) return false;

        try {
            $set = implode(", ", array_map(fn($k) => "`$k` = :set_$k", array_keys($data)));
            $where = implode(" AND ", array_map(fn($k) => "`$k` = :cond_$k", array_keys($conditions)));

            $stmt = $pdo->prepare("UPDATE `$table` SET $set WHERE $where");

            $params = [];
            foreach ($data as $k => $v) $params["set_$k"] = $v;
            foreach ($conditions as $k => $v) $params["cond_$k"] = $v;

            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function add($table, $data): bool {
        $pdo = self::getConnection();
        if (empty($data)) return false;

        try {
            $columns = implode("`, `", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = $pdo->prepare("INSERT INTO `$table` (`$columns`) VALUES ($values)");
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function addUser($table, $data): int {
        $pdo = self::getConnection();
        if (empty($data)) return false;
        self::add($table, $data);
        return $pdo->lastInsertId();
    }
}
