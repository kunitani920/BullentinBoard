<?php
session_start();
require_once '../sanitize.php';
require_once '../validation/nameValidation.php';

if($_SESSION['first_visit'] === 'on' && !empty($_SESSION['NickName'])) {
    $clean = $_SESSION;
} else {
    $clean = sanitize::clean($_POST);
}

$error_msg = array();

$name_validation = new nameValidation();
$is_last_name = $name_validation->isName($clean['LastName']);
if(!$is_last_name) {
    $error_msg['LastName'] = $name_validation->getErrorMessage();
}

$is_first_name = $name_validation->isName($clean['FirstName']);
if(!$is_first_name) {
    $error_msg['FirstName'] = $name_validation->getErrorMessage();
}

$is_nick_name = $name_validation->isName($clean['NickName']);
if(!$is_nick_name) {
    $error_msg['NickName'] = $name_validation->getErrorMessage();
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['LastName'] = $clean['LastName'];
    $_SESSION['FirstName'] = $clean['FirstName'];
    $_SESSION['NickName'] = $clean['NickName'];
    $_SESSION['first_visit'] = 'on';
    header('Location: new_registration_2.php');
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

<body>
<div class="container">
    <h2 class="mt-3">内定者懇親フォーム</h2>
    <h4 class="mt-3">ご登録、ありとうございます。<br>あなたのプロフィールを入力してください。</h4>
    <form method="post" action="new_registration_1.php">
        <div class="form-row mt-5">
        <div class="form-group col-md-4">
            <label for="inputLastname">氏</label>
            <input type="text" class="form-control" id="inputLastname" name="LastName" placeholder="Last Name（山田）" value="<?php if(isset($clean['LastName'])){echo $clean['LastName'];}?>">
        </div>
        <?php if(!$is_last_name && $_SESSION['first_visit'] === 'off'): ?>
            <div class="col-md-4 d-md-none">
            <p class="text-danger"><?php echo $error_msg['LastName']; ?></p>
            </div>
        <?php endif; ?>
        <div class="form-group col-md-4">
            <label for="inputFirstname">名</label>
            <input type="text" class="form-control" id="inputFirstname" name="FirstName" placeholder="First Name（太郎）" value="<?php if(isset($clean['FirstName'])){echo $clean['FirstName'];}?>">
        </div>
        <?php if(!$is_first_name && $_SESSION['first_visit'] === 'off'): ?>
            <div class="col-md-4 d-md-none">
            <p class="text-danger"><?php echo $error_msg['FirstName']; ?></p>
            </div>
        <?php endif; ?>
        <div class="col-md-4">
            <!-- 空白 -->
        </div>
        <?php if((!$is_last_name || !$is_first_name) && $_SESSION['first_visit'] === 'off'): ?>
            <div class="col-md-4 d-none d-md-block">
            <p class="text-danger"><?php echo $error_msg['LastName']; ?></p>
            </div>
            <div class="col-md-4 d-none d-md-block">
            <p class="text-danger"><?php echo $error_msg['FirstName']; ?></p>
            </div>
            <?php endif; ?>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputNickname">ニックネーム</label>
                <input type="text" class="form-control" id="inputNickname" name="NickName" placeholder="ヤマちゃん" value="<?php if(isset($clean['NickName'])){echo $clean['NickName'];}?>">
            </div>
            <div class="col-md-8">
                <!-- 空白 -->
            </div>
            <?php if(!$is_nick_name && $_SESSION['first_visit'] === 'off'): ?>
            <div class="col-md-4">
                <p class="text-danger"><?php echo $error_msg['NickName']; ?></p>
            </div>
            <?php endif; ?>
        </div>
        <?php $_SESSION['first_visit'] = 'off'; ?>

        <button class="btn btn-primary mt-3" type="submit" name="submit">次へ</button>

    </form>
</div>
<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

</body>
</html>