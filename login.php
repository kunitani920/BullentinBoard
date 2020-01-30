<?php

session_start();
$email_errors = $_SESSION['email_error'];
$password_errors = $_SESSION['password_error'];
$error = $_SESSION['error'];
$test = $_SESSION['test'];

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

    <title>ログイン・新規登録</title>
</head>
<body>
<div class="container">
    <h2 class="mt-3">内定者懇親フォーム</h2>
    <p>メールアドレス、パスワードを入力してください。</p>
    <p>登録済みの方は、閲覧画面へ。<br/>初めての方は登録フォームへ進みます。</p>
    <div><br></div>
    <p style="color: red"><?php echo $error; ?></p>
    <p style="color: red"><?php var_dump($email_error); ?></p>
    <p style="color: red"><?php var_dump($password_error); ?></p>
    <p style="color: red"><?php var_dump($test); ?></p>
    <p style="color: red"><?php foreach($test as $tes){echo $tes . PHP_EOL;} ?></p>
    <form method="post" action="login_check.php">
        <div class="form-group row">
        <label for="inputEmail" class="col-sm-3 col-form-label">メールアドレス</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
            <p style="color: red">
            <?php
                foreach($email_errors as $email_error) {
                echo $email_error;
                }
            ?>
            </p>
        </div>
        </div>
        <!-- name,passwordをpasswordへ　要検討 -->
        <div class="form-group row">
        <label for="password" class="col-sm-3 col-form-label">パスワード</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <p style="color: red">
            <?php
                foreach($password_errors as $password_error) {
                echo $password_error;
                }
            ?>
            </p>
        </div>
        </div>
        <!-- chekcbox 未選択なのにvalueのonが送信されてしまうので、とりあえず封印
        <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck1" name="save" value="on">
            <label class="form-check-label" for="gridCheck1">パスワードを記録する</label>
            </div>
        </div>
        </div> -->
    <div class="form-group row">
      <button type="submit" class="btn btn-primary">ログイン・新規登録</button>
    </div>
  </form>
</div>



<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>

<?php
//sessionの初期化、破棄
// $_SESSION = array();
// session_destroy();
// unset($_SESSION['email_error']);
// unset($_SESSION['password_error']);
// unset($_SESSION['error']);
// unset($_SESSION['test']);
?>