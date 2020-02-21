<?php
session_start();
require_once '../hsc.php';
require_once '../Db.php';

$clean = Hsc::clean($_POST);
$delete_id = $clean['delete_id'];
$_SESSION['delete_id'] = $delete_id;

//管理者
$login_jinji_id = $_SESSION['login_jinji_id'];
$login_jinji_name = $_SESSION['login_jinji_name'];

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members = $pdo->prepare('SELECT email FROM members WHERE id=?');
$members->execute(array($delete_id));
$member = $members->fetch();
$email = $member['email'];

$members_info = $pdo->prepare('SELECT last_name,first_name FROM members_info WHERE member_id=?');
$members_info->execute(array($delete_id));
$member_info = $members_info->fetch();
$last_name = $member_info['last_name'];
$first_name = $member_info['first_name'];

$pdo = null;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>削除ページ</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-
            <?php
                if(isset($login_jinji_id)) {
                    echo 'dark bg-dark">';
                    echo '<span class="navbar-text text-white">';
                    echo $login_jinji_name . '｜削除確認';
                } else {
                    echo 'light" style="background-color: #e3f2fd;">';
                    echo '<span class="navbar-text text-primary">';
                    echo '削除確認';
                }
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
        <h5 class="text-secondary my-5"><u><?php echo sprintf('%s %s : %s', $last_name, $first_name, $email); ?></u></h5>

        <form action="delete_db.php" method="post">
            <a class="btn btn-secondary mr-3" href="delete_db.php" role="button">一覧に戻る</a>
            <button class="btn btn-danger" type="submit" name="delete_flag" value="on">削除する</button>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
