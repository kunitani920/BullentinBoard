<?php
session_start();
require_once '../Db.php';

$member = $_SESSION;
//DB接続
$db = new Db();
$pdo = $db->dbconnect();
//membersテーブル登録
$sql_members = 'INSERT INTO members SET email=?, password=?, created=NOW()';
$members = $pdo->prepare($sql_members);
$members->execute(array($member['email'], $member['password']));
//メンバーのID取得
$member_id = (int) $pdo->lastInsertId();

//members_infoテーブル登録
$sql_members_info = 'INSERT INTO members_info SET member_id=?, last_name=?, first_name=?, nick_name=?, school=?, prefectures_id=?, message=?, icon=?';
$members_info = $pdo->prepare($sql_members_info);
$members_info->execute(array($member_id, $member['LastName'], $member['FirstName'], $member['NickName'], $member['school'], $member['pre'], $member['message'], $member['icon']['name']));

//members_interestingテーブル登録
$sql_members_intere = 'INSERT INTO members_interesting SET member_id=?, interesting1_id=?, interesting2_id=?, interesting3_id=?';
$members_intere = $pdo->prepare($sql_members_intere);
$members_intere->execute(array($member_id, $member['intere'][0], $member['intere'][1],$member['intere'][2]));

$pdo = null;

header('Location: ../list.php');
exit();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./style.css">

    <!-- bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <title>新規登録</title>
</head>

<body>
<div class="container">
  <h2 class="mt-3">内定者懇親フォーム</h2>
  <h4 class="mt-3"><?php var_dump($member); ?></h4>



</div>
<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

</body>
</html>