<?php

class Db 
{
    protected $dsn = "mysql:host=localhost;dbname=test;charset=utf8";
    protected $username = "root";
    protected $password = "";

    protected function dataTable()
    {
        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db = "CREATE TABLE IF NOT EXISTS user_data(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    birth_day INT(2) NOT NULL,
                    birth_month VARCHAR(10) NOT NULL,
                    birth_year INT(4) NOT NULL,
                    email VARCHAR(50) NOT NULL
                    );";
            $conn->exec($db);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function schoolTable()
    {
        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
            $db = "CREATE TABLE IF NOT EXISTS school(
                    id INT NOT NULL,
                    school VARCHAR(100) NOT NULL,
                    year_from INT(4) NOT NULL,
                    year_to INT(4) NOT NULL,
                    profession VARCHAR(50) NOT NULL
                    );";
            $conn->exec($db);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function langTable()
    {
        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
            $db = "CREATE TABLE IF NOT EXISTS lang(
                    id INT NOT NULL,
                    language VARCHAR(50) NOT NULL,
                    speaking VARCHAR(50) NOT NULL,
                    reading VARCHAR(50) NOT NULL,
                    writing VARCHAR(50) NOT NULL
                    );";
            $conn->exec($db);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function imageTable()
    {
        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db = "CREATE TABLE IF NOT EXISTS images(
                    id INT NOT NULL,
                    img_name VARCHAR(100),
                    image VARCHAR(100)
                    );";
            $conn->exec($db);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function pdfTable()
    {
        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db = "CREATE TABLE IF NOT EXISTS pdf(
                    id INT NOT NULL,
                    mime VARCHAR (255) NOT NULL,
                    data BLOB NOT NULL
                    );";
            $conn->exec($db);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>
