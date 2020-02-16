<?php
session_start();
require_once '../Db.php';
require_once '../sanitize.php';
require_once '../validation/emailValidation.php';
require_once '../validation/passwordValidation.php';

//header表示用
$login_jinji_name = $_SESSION['login_jinji_name'];

$clean = sanitize::clean($_POST);
$edit_id = $_SESSION['edit_id'];

// DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members = $pdo->prepare('SELECT * FROM members WHERE id=?');
$members->execute(array($edit_id));
$member = $members->fetch();

$pdo = null;

$error_msg = array();

//email変更あり
if($member['email'] !== $clean['email']) {
    $email_validation = new emailValidation();
    $is_email = $email_validation->isEmail($clean['email']);
    if(!$is_email) {
        $error_msg['email'] = $email_validation->getErrorMessage();
    }
    $_SESSION['edit_email'] = 'on';
} else {
    $_SESSION['edit_email'] = 'off';
}

//password変更あり
if($clean['edit_password'] === 'on') {
    $password_validation = new passwordValidation();
    $edit_password = $password_validation->editPassword($clean['password'], $clean['edit_password']);
    if(!$edit_password) {
        $error_msg['password'] = $password_validation->getErrorMessage();
    }
}

//どちらも変更なし
if($_SESSION['edit_email'] === 'off' && $clean['edit_password'] === 'off') {
    $error_msg['unedit'] = '変更がありません。「変更しない」ボタンで戻ることができます。';
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['email'] = $clean['email'];
    $_SESSION['password'] = $clean['password'];
    $_SESSION['edit_password'] = $clean['edit_password'];
    $_SESSION['first_visit'] = 'on';
    header('Location: edit_confirm_id.php');
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

    <title>編集</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-
            <?php
                if(isset($login_jinji_name)) {
                    echo 'dark bg-dark">';
                    echo '<span class="navbar-text text-white">';
                    echo $login_jinji_name . 'さんログイン｜メールアドレス、パスワード編集中';
                } else {
                    echo 'light" style="background-color: #e3f2fd;">';
                    echo '<span class="navbar-text text-primary">';
                    echo 'メールアドレス、パスワード編集中';
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
        <h4 class="mt-3">メールアドレス、パスワード編集</h4>
 
        <?php if(isset($error_msg['unedit']) && $_SESSION['first_visit'] === 'off'): ?>
            <p class="text-danger"><?php echo $error_msg['unedit']; ?></p>
        <?php endif; ?>

        <form method="post" action="edit_registration_id.php">
            <div class="form-group row">
                <label for="inputEmail" class="col-lg-10 col-form-label">メールアドレス</label>
                <div class="col-lg-5">
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="<?php echo $member['email']; ?>">
                </div>
                <?php if(!$is_email && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-lg-10">
                        <p class="text-danger"><?php echo $error_msg['email']; ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group row mt-4">
                <label for="password" class="col-lg-10 col-form-label">パスワード：変更しない場合は、何も入力せずチェックを入れてください。</label>
                <div class="col-lg-5">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password:4〜12文字">
                </div>
                <?php if(!$edit_password && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-lg-10">
                        <p class="text-danger"><?php echo $error_msg['password']; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-check form-check-inline col-lg-10">
                    <input type="hidden" name="edit_password" value="on">
                    <input class="form-check-input ml-3" type="checkbox" id="edit_password" name="edit_password" value="off">
                    <label class="form-check-label" for="edit_password">変更しない</label>
                </div>
            </div>
            <?php $_SESSION['first_visit'] = 'off'; ?>
            
            <a class="btn btn-secondary mt-4 mr-3" href="edit_registration_db.php" role="button">編集しないで戻る</a>
            <button type="submit" class="btn btn-primary mt-4">次へ</button>
        </form>
    </div>

    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>
