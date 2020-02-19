<?php
session_start();
require_once '../Db.php';
require_once '../hsc.php';

$login_jinji_id = $_SESSION['login_jinji_id'];
$delete_id = $_SESSION['delete_id'];

$clean = Hsc::clean($_POST);
$delete_flag = $clean['delete_flag'];

//削除する場合のみ、DB接続（削除しない時も、セッション破棄でこのページにくる為）
if($delete_flag) {

    $_SESSION['status'] = 'delete';   //完了メッセージ用
    
    //DB接続
    $db = new Db();
    $pdo = $db->dbconnect();
    
    //jinjiesテーブル削除
    $sql_jinjies = 'DELETE FROM jinjies WHERE id=?';
    $jinjies = $pdo->prepare($sql_jinjies);
    $jinjies->execute(array($delete_id));
    
    $pdo = null;

    //自身の削除
    if($delete_id === $login_jinji_id) {
        header('Location: ../login.php');
        exit();
    }

}

//他の管理者の削除 or 削除なし
unset($_SESSION['delete_id']);
header('Location: jinji_list.php');
exit();

?>