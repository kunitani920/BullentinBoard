<?php
session_start();
require_once '../Db.php';

$edit_id = $_SESSION['edit_id'];
$edit_flag = $_SESSION['edit_flag'];

//編集する場合のみ、DB接続（編集しない時も、セッション破棄でこのページにくる為）
if($edit_flag) {
    $_SESSION['status'] = 'edit';    //完了メッセージ用
    $jinji = $_SESSION;
    
    $db = new Db();
    $pdo = $db->dbconnect();

    //password変更あり
    if($jinji['edit_password'] === 'on') {
        $sql_jinjies = 'UPDATE jinji SET email=?, passsord=?, last_name=?, first_name=? WHERE id=?';
        $jinjies = $pdo->prepare($sql_jinjies);
        $hash_password = password_hash($jinji['password'], PASSWORD_DEFAULT);  //hash化
        $jinjies->execute(array($jinji['email'], $hash_password, $jinji['last_name'], $jinji['first_name'], $edit_id));
    }

    //password変更なし
    if($jinji['edit_password'] === 'off') {
        $sql_jinjies = 'UPDATE jinji SET email=?, last_name=?, first_name=? WHERE id=?';
        $jinjies = $pdo->prepare($sql_jinjies);
        $jinjies->execute(array($jinji['email'], $jinji['last_name'], $jinji['first_name'], $edit_id));
    }

    $pdo = null;
}

unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['last_name']);
unset($_SESSION['first_name']);
unset($_SESSION['edit_flag']);
unset($_SESSION['edit_email']);
unset($_SESSION['edit_password']);
unset($_SESSION['edit_last_name']);
unset($_SESSION['edit_first_name']);
unset($_SESSION['edit_id']);

header('Location: jinji_list.php');
exit();

?>