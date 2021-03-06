<?php
session_start();
require_once '../Db.php';
require_once '../hsc.php';
require_once '../validation/nameValidation.php';

//header表示用
$login_jinji_name = $_SESSION['login_jinji_name'];

$clean = Hsc::clean($_POST);
$edit_id = $_SESSION['edit_id'];

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members_info = $pdo->prepare('SELECT * FROM members_info WHERE member_id=?');
$members_info->execute(array($edit_id));
$member_info = $members_info->fetch();

$pdo = null;

$error_msg = array();

$name_validation = new nameValidation();
$is_last_name = $name_validation->isName($clean['last_name']);
if(!$is_last_name) {
    $error_msg['last_name'] = $name_validation->getErrorMessage();
}

$is_first_name = $name_validation->isName($clean['first_name']);
if(!$is_first_name) {
    $error_msg['first_name'] = $name_validation->getErrorMessage();
}

$is_nick_name = $name_validation->isName($clean['nick_name']);
if(!$is_nick_name) {
    $error_msg['nick_name'] = $name_validation->getErrorMessage();
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['last_name'] = $clean['last_name'];
    $_SESSION['first_name'] = $clean['first_name'];
    $_SESSION['nick_name'] = $clean['nick_name'];
    $_SESSION['first_visit'] = 'on';
    header('Location: edit_registration_2.php');
    exit();
}

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
                    echo $login_jinji_name . '｜メンバープロフィール';
                } else {
                    echo 'light" style="background-color: #e3f2fd;">';
                    echo '<span class="navbar-text text-primary">';
                    echo 'プロフィール編集中';
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
        <h4 class="mt-3">プロフィール編集 ：１／４</h4>
        <form method="post" action="edit_registration_1.php">
            <div class="form-row mt-5">
                <div class="form-group col-md-4">
                    <label for="input_last_name">氏</label>
                    <input type="text" class="form-control" id="input_last_name" name="last_name" value="<?php echo $member_info['last_name']; ?>">
                </div>
                <?php if(!$is_last_name && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-md-none">
                        <p class="text-danger"><?php echo $error_msg['last_name']; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group col-md-4">
                    <label for="input_first_name">名</label>
                    <input type="text" class="form-control" id="input_first_name" name="first_name" value="<?php echo $member_info['first_name']; ?>">
                </div>
                <?php if(!$is_first_name && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-md-none">
                        <p class="text-danger"><?php echo $error_msg['first_name']; ?></p>
                    </div>
                <?php endif; ?>
                <div class="col-md-4"></div>
                <?php if((!$is_last_name || !$is_first_name) && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-none d-md-block">
                        <p class="text-danger"><?php echo $error_msg['last_name']; ?></p>
                    </div>
                    <div class="col-md-4 d-none d-md-block">
                        <p class="text-danger"><?php echo $error_msg['first_name']; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="input_nick_name">ニックネーム</label>
                    <input type="text" class="form-control" id="input_nick_name" name="nick_name" value="<?php echo $member_info['nick_name']; ?>">
                </div>
                <div class="col-md-8"></div>
                <?php if(!$is_nick_name && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4">
                        <p class="text-danger"><?php echo $error_msg['nick_name']; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <?php $_SESSION['first_visit'] = 'off'; ?>
                
            <button class="btn btn-primary mt-3" type="submit">次へ</button>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>