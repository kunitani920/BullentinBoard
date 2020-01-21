<?php

class Db
{
    private $dsn = 'mysql:dbname=naiteisya;host=127.0.0.1;charset=utf8';
    private $dbuser = 'root';
    private $dbpassword = 'root';

    public function dbconnect() {
        try {
            $pdo = new PDO($this->dsn, $this->dbuser, $this->dbpassword);
        } catch(PDOException $e) {
            echo 'DB接続エラー：' . $e->getMessage();
        }
        return $pdo;
    }
}

?>