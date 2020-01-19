<?php

try {
    $db = new PDO('mysql:dbname=naiteisya;host=127.0.0.1;charset=utf8','root','root');
} catch(PDOException $e) {
    echo 'DB接続エラー：' . $e->getMessage();
}

?>