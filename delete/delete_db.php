<?php
session_start();
require_once '../Db.php';

$_SESSION['status'] = 'delete';   //完了メッセージ用

$login_member_id = $_SESSION['login_member_id'];

//DB接続
$db = new Db();
$pdo = $db->dbconnect();

//membersテーブル削除
$sql_members = 'DELETE FROM members WHERE id=?';
$members = $pdo->prepare($sql_members);
$members->execute(array($login_member_id));

//members_infoテーブル削除
$sql_members_info = 'DELETE FROM members_info WHERE member_id=?';
$members_info = $pdo->prepare($sql_members_info);
$members_info->execute(array($login_member_id));

//members_interestingテーブル削除
$sql_members_intere = 'DELETE FROM members_interesting WHERE member_id=?';
$members_intere = $pdo->prepare($sql_members_intere);
$members_intere->execute(array($login_member_id));

$pdo = null;

header('Location: ../login.php');
exit();

?>