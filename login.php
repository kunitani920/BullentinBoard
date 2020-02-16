<?php
session_start();
require_once 'sanitize.php';

//ログアウト、すぐに破棄すべきセッション
unset($_SESSION['login_member_id']);
unset($_SESSION['login_jinji_id']);
unset($_SESSION['all_id']);

$clean = sanitize::clean($_POST);

//アラート表示。ログアウトだけはPOST経由
$status = $_SESSION['status'];
if($clean['logout']) {
    $status = $clean['logout'];
}

//ログインエラー
$email = $_SESSION['email'];
$email_error = $_SESSION['email_error'];
$password_error = $_SESSION['password_error'];
$match_error = $_SESSION['match_error'];

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
<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-light" style="background-color: #e3f2fd;">
            <span class="navbar-text text-primary">ログインしていません</span>
        </nav>
    </header>

    <div class="container">
        <!-- ログアウト・削除表示 -->
        <?php
            if(!empty($status)):
        ?>
        <div class="alert alert-success mt-3" role="alert">
            <?php
                switch ($status) {
                    case 'ログアウト':
                        echo 'ログアウト完了。またのログインお待ちしています。';
                    break;

                    case 'delete':
                        echo '削除完了。またの登録お待ちしています。';
                    break;
                    
                    case 'not_logged_in':
                        echo 'メンバー確認出来ませんでした。こちらのページからログインしてください。';
                    break;
                    
                    case 'jinji':
                        echo 'メールアドレスが、管理者として登録済みです。こちらのページからログインしてください。';
                    break;
                    
                    case 'member':
                        echo 'メールアドレスが、メンバーとして登録済みです。こちらのページからログインしてください。';
                    break;
                }
            ?>
        </div>
        <?php endif; ?>

        <h3 class="mt-3">内定者懇親サイトへようこそ！</h3>
        <h4 class="mt-3">ログイン・新規登録ページ</h4>
        <p class="mt-4">メールアドレス・パスワードを入力し、ログインしてください。<br>未登録の方は登録フォームへ進みます。</p>
        <div><br></div>

        <?php if(isset($match_error) && $_SESSION['first_visit'] === 'off'): ?>
            <p class="text-danger"><?php echo $match_error; ?></p>
        <?php endif; ?>

        <form method="post" action="login_check.php">
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
                    <div class="col-lg-2"></div>
                    <div class="col-lg-9">
                        <p class="text-danger"><?php echo $password_error; ?></p>
                    </div>
                    <?php endif; ?>
            </div>

            <div class="row">
                <button type="submit" class="btn btn-primary mt-3">ログイン・新規登録</button>
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
$_SESSION = array();
session_destroy();
?>
