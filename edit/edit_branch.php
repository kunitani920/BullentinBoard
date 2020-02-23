<?php
session_start();
require_once '../hsc.php';

//header表示用
$login_jinji_name = $_SESSION['login_jinji_name'];

$clean = Hsc::clean($_POST);
$edit_id = $clean['edit_id'];
$_SESSION['edit_id'] = $edit_id;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>編集</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-
            <?php
                if(isset($login_jinji_name)) {
                    echo 'dark bg-dark">';
                    echo '<span class="navbar-text text-white">';
                    echo $login_jinji_name . '｜編集選択';
                } else {
                    echo 'light" style="background-color: #e3f2fd;">';
                    echo '<span class="navbar-text text-primary">';
                    echo '編集選択';
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
        <h4 class="my-3">編集する項目を選択してください。</h4>

        <div class="row">
            <a class="btn btn-success mx-3" href="edit_registration_id.php" role="button">メールアドレス、パスワード</a>
            <a class="btn btn-info" href="edit_registration_1.php" role="button">プロフィール</a>
        </div>
        <a class="btn btn-secondary mt-5" href="../list.php" role="button">戻る</a>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
