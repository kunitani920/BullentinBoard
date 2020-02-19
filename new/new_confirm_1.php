<?php
session_start();
require_once '../hsc.php';
require_once '../validation/passwordValidation.php';
$email = $_SESSION['email'];
$password = $_SESSION['password'];

// if($_SESSION['first_visit'] === 'on') {
//     $clean = $_SESSION; //confirmから戻ってきた時、入力値をセッティング
// } else {

$clean = Hsc::clean($_POST);
// }

$error_msg = array();

$password_validation = new passwordValidation();
$reenter_password = $password_validation->reenterPassword($password, $clean['password']);

if (!$reenter_password) {
    $error_msg['password'] = $password_validation->getErrorMessage();
}

//error_msgなし かつ first_vistでなければ、入力値をSESSIONに保存・first_visitをセットし、次のページへ
if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['first_visit'] = 'on';
    header('Location: new_registration_1.php');
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
    <title>新規登録</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-light" style="background-color: #e3f2fd;">
            <span class="navbar-text text-primary">ログインしていません</span>
        </nav>
    </header>

    <div class="container">
        <h4>新規登録ページ</h4>
        <p><?php var_dump($clean['password']); ?></p>
        <p class="mt-4">こちらのメールアドレスは、登録がありません。<br>新規登録しますが、よろしいですか？</p>
        <p class="text-success"><u><?php echo $email; ?></u></p>
        <p class="mt-5">よろしければ、再度パスワードを入力してください。</p>
        <form method="post" action="new_confirm_1.php">
            <div class="form-group">
                <label for="password" class="col-form-label">パスワード</label>
                <input type="password" class="form-control col-lg-5" id="password" name="password" placeholder="Password:4〜12文字">
                <?php if(!$reenter_password && $_SESSION['first_visit'] === 'off'): ?>
                    <p class="text-danger"><?php echo $error_msg['password']; ?></p>
                <?php endif; ?>
            </div>
            <a class="btn btn-secondary" href="../login.php" role="button">戻る</a>
            <input class="btn btn-primary" type="submit" value="このアドレスで登録する">
        </form>
        <?php $_SESSION['first_visit'] = 'off'; ?>
    </div>

    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>
