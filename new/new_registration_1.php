<?php
session_start();
require_once '../hsc.php';
require_once '../validation/nameValidation.php';

if($_SESSION['first_visit'] === 'on') {
    $clean = $_SESSION; //confirmから戻ってきた時、入力値をセッティング
} else {
    $clean = Hsc::clean($_POST);
}

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

//error_msgなし かつ first_vistでなければ、入力値をSESSIONに保存・first_visitをセットし、次のページへ
if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['last_name'] = $clean['last_name'];
    $_SESSION['first_name'] = $clean['first_name'];
    $_SESSION['nick_name'] = $clean['nick_name'];
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

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-light" style="background-color: #e3f2fd;">
            <span class="navbar-text text-primary">新規登録中</span>
        </nav>
    </header>
    <div class="container">
        <h4 class="mt-3">プロフィール登録 ：１／４</h4>
        <form method="post" action="new_registration_1.php">
            <div class="form-row mt-5">
                <div class="form-group col-md-4">
                    <label for="input_last_name">氏</label>
                    <input type="text" class="form-control" id="input_last_name" name="last_name" placeholder="Last Name（山田）" value="<?php if(isset($clean['last_name'])){echo $clean['last_name'];}?>">
                </div>
                <?php if(!$is_last_name && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-md-none"><!--md未満、表示-->
                        <p class="text-danger"><?php echo $error_msg['last_name']; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group col-md-4">
                    <label for="input_first_name">名</label>
                    <input type="text" class="form-control" id="input_first_name" name="first_name" placeholder="First Name（太郎）" value="<?php if(isset($clean['first_name'])){echo $clean['first_name'];}?>">
                </div>
                <?php if(!$is_first_name && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-md-none"><!--md未満、表示-->
                        <p class="text-danger"><?php echo $error_msg['first_name']; ?></p>
                    </div>
                <?php endif; ?>
                <div class="col-md-4">
                    <!-- 空白 -->
                </div>
                <?php if((!$is_last_name || !$is_first_name) && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-none d-md-block"><!--md以上、表示-->
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
                    <input type="text" class="form-control" id="input_nick_name" name="nick_name" placeholder="ヤマちゃん" value="<?php if(isset($clean['nick_name'])){echo $clean['nick_name'];}?>">
                </div>
                <div class="col-md-8">
                    <!-- 空白 -->
                </div>
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
    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>