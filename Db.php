<?php

class Db
{
    private $dsn = 'mysql:dbname=naiteisya;host=127.0.0.1;charset=utf8';
    private $dbuser = 'root';
    private $dbpassword = 'root';

    public function dbconnect() {
        try {
            $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
            $db['dbname'] = ltrim($db['path'], '/');
            $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
            $user = $db['user'];
            $password = $db['pass'];
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
            );
            $pdo = new PDO($dsn,$user,$password,$options);
        } catch(PDOException $e) {
            echo 'DB接続エラー：' . $e->getMessage();
        }
        return $pdo;
    }
}

?>