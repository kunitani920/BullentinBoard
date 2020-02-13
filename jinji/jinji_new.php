<?php
session_start();
require_once '../sanitize.php';

//ログインエラー
$email = $_SESSION['email'];
$last_name = $_SESSION['last_name'];
$first_name = $_SESSION['first_name'];
$email_error = $_SESSION['email_error'];
$password_error = $_SESSION['password_error'];
$last_name_error = $_SESSION['last_name_error'];
$first_name_error = $_SESSION['first_name_error'];

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
        <h5>必要な情報を入力してください。</h5>
        <div><br></div>

        <form method="post" action="jinji_new_check.php">
            <div class="form-group row">
                <label for="inputEmail" class="col-lg-2 col-form-label">メールアドレス</label>
                <div class="col-lg-5">
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;} ?>">
                </div>
                <div class="col-lg-5"></div>
                <?php if(isset($email_error) && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-5">
                        <p class="text-danger"><?php echo $email_error; ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group row">
                <label for="password" class="col-lg-2 col-form-label">パスワード</label>
                <div class="col-lg-5">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password:4〜12文字">
                </div>
                <div class="col-lg-5"></div>
                <?php if(isset($password_error) && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-lg-2">
                        <!-- 空白 -->
                    </div>
                    <div class="col-lg-5">
                        <p class="text-danger"><?php echo $password_error; ?></p>
                    </div>
                    <?php endif; ?>
            </div>

            <div class="form-row mt-5">
                <div class="form-group col-md-4">
                    <label for="input_last_name">氏</label>
                    <input type="text" class="form-control" id="input_last_name" name="last_name" placeholder="Last Name（山田）" value="<?php if(isset($last_name)){echo $last_name;}?>">
                </div>
                <?php if(isset($last_name_error) && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-md-none"><!--md未満、表示-->
                        <p class="text-danger"><?php echo $last_name_error; ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group col-md-4">
                    <label for="input_first_name">名</label>
                    <input type="text" class="form-control" id="input_first_name" name="first_name" placeholder="First Name（太郎）" value="<?php if(isset($first_name)){echo $first_name;}?>">
                </div>
                <?php if(isset($first_name_error) && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-md-none"><!--md未満、表示-->
                        <p class="text-danger"><?php echo $first_name_error; ?></p>
                    </div>
                <?php endif; ?>
                <?php if(isset($last_name_error) || isset($first_name_error) && $_SESSION['first_visit'] === 'off'): ?>
                    <div class="col-md-4 d-none d-md-block"><!--md以上、表示-->
                        <p class="text-danger"><?php echo $last_name_error; ?></p>
                    </div>
                    <div class="col-md-4 d-none d-md-block">
                        <p class="text-danger"><?php echo $first_name_error; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">新規登録</button>
            </div>
        </form>
        <div class="row mt-5 ml-1">
            <h5>登録済みの方は、<a href="../login.php" class="alert-link">こちら</a>からログインしてください。</h5>
        </div>
    </div>

    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>