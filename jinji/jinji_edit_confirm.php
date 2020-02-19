<?php
session_start();
require_once '../hsc.php';
require_once '../validation/passwordValidation.php';

//header表示用
$login_jinji_name = $_SESSION['login_jinji_name'];

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$last_name = $_SESSION['last_name'];
$first_name = $_SESSION['first_name'];
$edit_email = $_SESSION['edit_email'];
$edit_password = $_SESSION['edit_password'];
$edit_last_name = $_SESSION['edit_last_name'];
$edit_first_name = $_SESSION['edit_first_name'];

$clean = Hsc::clean($_POST);

$error_msg = array();

//password変更あり
if($edit_password === 'on') {
    $password_validation = new passwordValidation();
    $reenter_password = $password_validation->reenterPassword($password, $clean['password']);
    
    if (!$reenter_password) {
        $error_msg['password'] = $password_validation->getErrorMessage();
    }
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['edit_flag'] = $clean['edit_flag'];
    $_SESSION['first_visit'] = 'on';
    header('Location: jinji_edit_db.php');
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
        <nav class="fixed-top navbar navbar-dark bg-dark">
            <span class="navbar-text text-white">
                <?php echo sprintf('%s｜編集中', $login_jinji_name); ?>
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
        <h4 class="mt-3">編集内容確認</h4>

        <p class="mt-3 text-success">メールアドレス：<?php echo $email; ?></p>
        <p class="mt-3 text-success">氏名：<?php echo sprintf('%s %s', $last_name, $first_name); ?></p>

        <form method="post" action="jinji_edit_confirm.php">
            <?php if($edit_password === 'off'): ?>
                <p class="mt-2">こちらでよろしければ、登録してください。</p>
            <?php endif; ?>
            <?php if($edit_password === 'on'): ?>
                <p class="mt-2">こちらでよろしければ、再度パスワードを入力し、登録してください。</p>
                <div class="form-group row">
                    <label for="password" class="col-lg-10 col-form-label">パスワード</label>
                    <div class="col-lg-5">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password:4〜12文字">
                    </div>
                    <?php if(!$reenter_password && $_SESSION['first_visit'] === 'off'): ?>
                        <div class="col-lg-10">
                            <p class="text-danger"><?php echo $error_msg['password']; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="mt-5 ">
                <a class="btn btn-secondary mr-2" href="jinji_edit_db.php" role="button">編集を破棄して一覧画面に戻る</a>
                <button class="btn btn-primary" type="submit" name="edit_flag" value="on">この内容で登録する</button>
            </div>
        </form>
        <?php $_SESSION['first_visit'] = 'off'; ?>
    </div>

    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>