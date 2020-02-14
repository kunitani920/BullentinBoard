<?php
session_start();
require_once '../sanitize.php';
require_once '../validation/passwordValidation.php';

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$last_name = $_SESSION['last_name'];
$first_name = $_SESSION['first_name'];

$clean = sanitize::clean($_POST);

$error_msg = array();

$password_validation = new passwordValidation();
$reenter_password = $password_validation->reenterPassword($password, $clean['password']);

if (!$reenter_password) {
    $error_msg['password'] = $password_validation->getErrorMessage();
}

//error_msgなし かつ first_vistでなければ、入力値をSESSIONに保存・first_visitをセットし、登録
if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['first_visit'] = 'on';
    header('Location: jinji_new_db.php');
    exit();
}

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

    <title>新規登録（管理者）</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-dark bg-dark">
            <span class="navbar-text text-white">ログインしていません｜管理者を新規登録中</span>
        </nav>
    </header>

    <div class="container">
        <h5>管理者として、新規登録します。</h5>
        <div><br></div>

        <div class="row ml-1">
            <p class="text-success">メールアドレス：<?php echo $email; ?></p>
        </div>
        <div class="row ml-1">
            <p class="text-success">氏名：<?php echo $last_name . ' ' . $first_name; ?></p>
        </div>

        <div class="row ml-1">
            <p>こちらでよろしければ、再度パスワードを入力し、登録してください。</p>
        </div>
        <form method="post" action="jinji_new_confirm.php">
            <div class="form-group">
                <label for="password" class="col-form-label">パスワード</label>
                <input type="password" class="form-control col-lg-5" id="password" name="password" placeholder="Password:4〜12文字">
                <?php if(!$reenter_password && $_SESSION['first_visit'] === 'off'): ?>
                    <p class="text-danger"><?php echo $error_msg['password']; ?></p>
                <?php endif; ?>
            </div>
            <div class="row mt-3 ml-1">
                <a class="btn btn-secondary" href="jinji_new.php" role="button">戻る</a>
                <input class="btn btn-primary ml-2" type="submit" value="この内容で登録する">
            </div>
        </form>
        <?php $_SESSION['first_visit'] = 'off'; ?>
    </div>

    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>