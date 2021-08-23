<?php

class UsersTable
{
    private $conn;
    private $tableName;

    public function __construct()
    {
        $this->tableName = "users";
        try {
            $this->conn = new PDO(
                "mysql:host=" . DBConfig::HOST . ";dbname=" . DBConfig::DB_NAME,
                DBConfig::USERNAME,
                DBConfig::PASS
            );
        } catch (PDOException $e) {
            die("ERROR: Could not connect. " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function getUser($email)
    {
        $sql = <<<EOSQL
            SELECT email, password, isAdmin FROM $this->tableName WHERE email="$email";
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute();
            $query->setFetchMode(PDO::FETCH_ASSOC);
            return $query;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
