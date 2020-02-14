<?php
session_start();
require_once '../Db.php';

$_SESSION['status'] = 'new';    //完了メッセージ用

$jinji = $_SESSION;

//不正ログイン
if(empty($jinji['email'])) {
    $_SESSION['status'] = 'not_logged_in';
    header('Location: ../login.php');
    exit();
}

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
//jinjiテーブル登録
$sql_jinjies = 'INSERT INTO jinjies SET email=?, password=?, last_name=?, first_name=?, created=NOW()';
$jinjies = $pdo->prepare($sql_jinjies);
$hash_password = password_hash($jinji['password'], PASSWORD_DEFAULT);  //hash化
$jinjies->execute(array($jinji['email'], $hash_password, $jinji['last_name'], $jinji['first_name']));

//管理者のID取得
$jinji_id = (int) $pdo->lastInsertId();

//ログイン情報として保持
$_SESSION['login_jinji_id'] = $jinji_id;

$pdo = null;

unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['last_name']);
unset($_SESSION['first_name']);

header('Location: jinji_list.php');
exit();

?>