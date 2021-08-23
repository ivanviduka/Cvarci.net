<?php

class ProductsTable
{
    private $conn;
    private $tableName;

    public function __construct()
    {
        $this->tableName = "products";
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

    public function getProducts()
    {
        $sql = <<<EOSQL
            SELECT id, name, quantity, price, imgURL, imgMinURL FROM $this->tableName;
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

    public function getProduct($productID)
    {
        $todoTask = array(
            ':id' => $productID
        );

        $sql = <<<EOSQL
            SELECT name, quantity, price, imgURL, imgMinURL FROM $this->tableName WHERE id=:id;
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute($todoTask);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            return $query;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function insertProduct($product)
    {
        $todoTask = array(
            ':id' => $product->id,
            ':name' => $product->name,
            ':quantity' => $product->quantity,
            ':price' => $product->price,
            ':imgURL' => $product->imgURL,
            ':imgMinURL' => $product->imgMinURL,
        );

        $sql = <<<EOSQL
            INSERT INTO $this->tableName(id, name, quantity, price, imgURL, imgMinURL) VALUES(:id, :name, :quantity, :price, :imgURL, :imgMinURL);
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute($todoTask);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteProduct($productID)
    {
        $todoTask = array(
            ':id' => $productID
        );

        $sql = <<<EOSQL
            DELETE FROM $this->tableName WHERE id=:id;
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute($todoTask);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateProduct($updatedProduct)
    {
        $todoTask = array(
            ':id' => $updatedProduct["id"],
            ':name' => $updatedProduct["name"],
            ':quantity' => $updatedProduct["quantity"],
            ':price' => $updatedProduct["price"],
            ':imgURL' => $updatedProduct["imgURL"],
            ':imgMinURL' => $updatedProduct["imgMinURL"]
        );

        $sql = <<<EOSQL
            UPDATE $this->tableName SET name=:name, quantity=:quantity, price=:price, imgURL=:imgURL, imgMinURL=:imgMinURL WHERE id=:id;
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute($todoTask);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
