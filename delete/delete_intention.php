<?php
session_start();
require_once '../Db.php';

$login_member_id = $_SESSION['login_member_id'];
$login_member_name = $_SESSION['login_member_name'];

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members = $pdo->prepare('SELECT email FROM members WHERE id=?');
$members->execute(array($login_member_id));
$member = $members->fetch();
$email = $member['email'];

$members_info = $pdo->prepare('SELECT last_name,first_name FROM members_info WHERE member_id=?');
$members_info->execute(array($login_member_id));
$member_info = $members_info->fetch();
$last_name = $member_info['last_name'];
$first_name = $member_info['first_name'];

$pdo = null;

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
    <title>削除ページ</title>
</head>

<body style="padding-top:4.5rem;">
<header>
    <nav class="navbar navbar-light fixed-top" style="background-color: #e3f2fd;">
            <span class="navbar-text text-primary">
                <?php 
                    echo sprintf('ようこそ %sさん！', $login_member_name);
                ?>
            </span>
        <ul class="nav justify-content-end">                
            <li class="nav-item">
                <form method="post" action="../login.php">
                    <input class="btn btn-link" type="submit" name="logout" value="ログアウト">
                </form>
            </li>
        </ul>
    </nav>
</header>
<div class="container">
    <h4 class="text-danger mt-3"><strong>本当に削除して、よろしいですか？</strong></h4>
    <h5 class="text-secondary mt-3"><u><?php echo sprintf('%s %s : %s', $last_name, $first_name, $email); ?></u></h5>
    <div><br></div>
    <a class="btn btn-secondary" href="../list.php" role="button">一覧に戻る</a>
    <a class="btn btn-danger" href="delete_db.php" role="button">削除する</a>
</div>

<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>
