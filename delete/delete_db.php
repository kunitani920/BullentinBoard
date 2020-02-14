<?php
session_start();
require_once '../Db.php';
require_once '../sanitize.php';

$delete_id = $_SESSION['delete_id'];

$clean = sanitize::clean($_POST);
$delete_flag = $clean['delete_flag'];

//削除する場合のみ、DB接続（削除しない時も、セッション破棄でこのページにくる為）
if($delete_flag) {

    $_SESSION['status'] = 'delete';   //完了メッセージ用
    
    //DB接続
    $db = new Db();
    $pdo = $db->dbconnect();
    
    //membersテーブル削除
    $sql_members = 'DELETE FROM members WHERE id=?';
    $members = $pdo->prepare($sql_members);
    $members->execute(array($delete_id));
    
    //members_infoテーブル削除
    $sql_members_info = 'DELETE FROM members_info WHERE member_id=?';
    $members_info = $pdo->prepare($sql_members_info);
    $members_info->execute(array($delete_id));
    
    //members_interestingテーブル削除
    $sql_members_intere = 'DELETE FROM members_interesting WHERE member_id=?';
    $members_intere = $pdo->prepare($sql_members_intere);
    $members_intere->execute(array($delete_id));
    
    $pdo = null;
}

if($_SESSION['login_jinji_id']) {
    header('Location: ../list.php');
    exit();
} else {
    //member
    unset($_SESSION['delete_id']);
    header('Location: ../login.php');
    exit();
}

?>