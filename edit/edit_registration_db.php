<?php
session_start();
require_once '../hsc.php';
require_once '../Db.php';

$edit_id = $_SESSION['edit_id'];
$edit_flag = $_SESSION['edit_flag'];

$clean = Hsc::clean($_POST);

//編集する場合のみ、DB接続（編集しない時も、セッション破棄でこのページにくる為）
//ID（メール、パスワード）編集
if ($edit_flag) {
    $_SESSION['status'] = 'edit';   //完了メッセージ用

    $member = $_SESSION;
    try {
        //DB接続
        $db = new Db();
        $dbh = $db->dbconnect();
    
        // トランザクション開始
        $dbh->beginTransaction();

        //membersテーブル登録、password変更あり
        if($member['edit_password'] === 'on') {
            $sql_members = 'UPDATE members SET email=?, password=? WHERE id=?';
            $members = $dbh->prepare($sql_members);
            $hash_password = password_hash($member['password'], PASSWORD_DEFAULT);  //hash化
            $members->execute(array($member['email'], $hash_password, $edit_id));
        }

        //membersテーブル登録、password変更なし
        if($member['edit_password'] === 'off') {
            $sql_members = 'UPDATE members SET email=? WHERE id=?';
            $members = $dbh->prepare($sql_members);
            $members->execute(array($member['email'], $edit_id));
        }

        // コミット
        $dbh->commit();

    } catch(PDOException $e) {
        // ロールバック
        $dbh->rollBack();

        // エラーメッセージ出力
        echo $e->getMessage();
        die();
    }
    $dbh = null;
}

//プロフィール編集
if ($clean['prof'] === 'on') {
    $_SESSION['status'] = 'edit';   //完了メッセージ用

    $member = $_SESSION;

    try {
        //DB接続
        $db = new Db();
        $dbh = $db->dbconnect();

        // トランザクション開始
        $dbh->beginTransaction();
    
        //members_infoテーブル登録
        $sql_members_info = 'UPDATE members_info SET last_name=?, first_name=?, nick_name=?, school=?, prefectures_id=?, message=? WHERE member_id=?';
        $members_info = $dbh->prepare($sql_members_info);
        $members_info->execute(array($member['last_name'], $member['first_name'], $member['nick_name'], $member['school'], $member['pre'], $member['message'], $edit_id));

        //members_infoテーブル登録、icon変更
        if (!empty($member['icon']['name'])) {
            $sql_members_info = 'UPDATE members_info SET icon=? WHERE member_id=?';
            $members_info = $dbh->prepare($sql_members_info);
            $members_info->execute(array($member['icon']['name'], $edit_id));
        }
        
        //members_infoテーブル登録、icon削除
        if ($member['icon_delete'] === 'on') {
            $sql_members_info = 'UPDATE members_info SET icon=? WHERE member_id=?';
            $members_info = $dbh->prepare($sql_members_info);
            $members_info->execute(array(null, $edit_id));
        }

        //members_interestingテーブル登録
        $sql_members_intere = 'UPDATE members_interesting SET interesting1_id=?, interesting2_id=?, interesting3_id=? WHERE member_id=?';
        $members_intere = $dbh->prepare($sql_members_intere);
        $members_intere->execute(array($member['intere_array'][0], $member['intere_array'][1],$member['intere_array'][2], $edit_id));

        // コミット
        $dbh->commit();

    } catch(PDOException $e) {
        // ロールバック
        $dbh->rollBack();

        // エラーメッセージ出力
        echo $e->getMessage();
        die();
    }
    $dbh = null;
}

unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['edit_email']);
unset($_SESSION['edit_password']);
unset($_SESSION['edit_flag']);
unset($_SESSION['edit_id']);
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