<?php
session_start();
require_once '../Db.php';

$_SESSION['status'] = 'new';    //完了メッセージ用

$member = $_SESSION;

//不正ログイン
if(empty($member['email'])) {
    $_SESSION['status'] = 'not_logged_in';
    header('Location: ../login.php');
    exit();
}

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
//membersテーブル登録
$sql_members = 'INSERT INTO members SET email=?, password=?, created=NOW()';
$members = $pdo->prepare($sql_members);
$hash_password = password_hash($member['password'], PASSWORD_DEFAULT);  //hash化
$members->execute(array($member['email'], $hash_password));

//メンバーのID取得
$member_id = (int) $pdo->lastInsertId();

//ログイン情報として保持
$_SESSION['login_member_id'] = $member_id;

//members_infoテーブル登録
$sql_members_info = 'INSERT INTO members_info SET member_id=?, last_name=?, first_name=?, nick_name=?, school=?, prefectures_id=?, message=?, icon=?';
$members_info = $pdo->prepare($sql_members_info);
$members_info->execute(array($member_id, $member['last_name'], $member['first_name'], $member['nick_name'], $member['school'], $member['pre'], $member['message'], $member['icon']['name']));

//members_interestingテーブル登録
$sql_members_intere = 'INSERT INTO members_interesting SET member_id=?, interesting1_id=?, interesting2_id=?, interesting3_id=?';
$members_intere = $pdo->prepare($sql_members_intere);
$members_intere->execute(array($member_id, $member['intere_array'][0], $member['intere_array'][1],$member['intere_array'][2]));

$pdo = null;

unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['last_name']);
unset($_SESSION['first_name']);
unset($_SESSION['nick_name']);
unset($_SESSION['school']);
unset($_SESSION['pre']);
unset($_SESSION['intere_array']);
unset($_SESSION['message']);
unset($_SESSION['icon']);

header('Location: ../list.php');
exit();

?>