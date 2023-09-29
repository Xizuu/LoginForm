<?php

namespace RaihanNih\Utils;

class Mysql
{

    /** @var \PDO $conn */
    private \PDO $conn;

    public function __construct(protected $host, protected $username, protected $password, protected $database)
    {

        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=utf8mb4";

        try {
            $this->conn = new \PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Koneksi ke database gagal: " . $e->getMessage());
        }
    }

    public function executeQuery($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            die("Query error: " . $e->getMessage());
        }
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->executeQuery($sql, $params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->executeQuery($sql, $params);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
