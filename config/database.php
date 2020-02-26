<?php
$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');

return [
    // $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
    'dsn' => "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8",
    // $user = $db['user'];
    'user' => $db['user'],
    // $password = $db['pass'];
    'password' => $db['pass'],
    // $options = array(
    //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //     PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
    // );
    'options' => array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
    )
];
?>