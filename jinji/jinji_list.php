<?php
session_start();
require_once '../Db.php';

//管理者
$login_jinji_id = $_SESSION['login_jinji_id'];

//不正ログイン
if(empty($login_jinji_id)) {
    $_SESSION['status'] = 'not_logged_in';
    header('Location: ../login.php');
    exit();
}

$status = $_SESSION['status'];  //アラート表示用

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$jinjies = $pdo->query('SELECT * FROM jinjies');
$jinji_count = 0;
while($jinji[$jinji_count] = $jinjies->fetch()) {
    if($jinji[$jinji_count]['id'] == $login_jinji_id) {
        $login_jinji_name = $jinji[$jinji_count]['last_name'];
        $_SESSION['login_jinji_name'] = $login_jinji_name;
    }
    $jinji_count++;
}
$_SESSION['jinji_count'] = $jinji_count;

//別ページに行く時必要。（編集破棄で戻った時など）
$_SESSION['first_visit'] = 'on';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>管理者一覧ページ</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-dark bg-dark">
            <span class="navbar-text text-white">
                <?php echo sprintf('%s｜管理者 %d人', $login_jinji_name, $jinji_count); ?>
            </span>
            <ul class="nav justify-content-end navbar-expand-lg">                
                <li class="nav-item">
                    <form method="post" action="../login.php">
                        <input class="btn btn-link" type="submit" name="logout" value="ログアウト">
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?php
            if(!empty($status)):
        ?>
        <div class="alert alert-success" role="alert">
            <?php
                switch ($status) {
                    case 'login':
                        echo 'ログイン成功しました。';
                    break;
                    case 'new':
                        echo '新規登録が完了しました。';
                    break;
                    case 'edit':
                        echo '編集が完了しました。';
                    break;
                    case 'delete':
                        echo '削除が完了しました。';
                    break;
                }
            ?>
        </div>
        <?php endif; ?>

        <div class="row mt-3 ml-1">
            <h4>管理者専用ページ</h4>
            <form method="post" action="../list.php">
                <input class="btn btn-link" type="submit" name="list" value="メンバーページ">
            </form>
        </div>
        <div class="row">
            <?php
                $i = 0;
                while($jinji[$i]):
            ?>
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header">
                        <?php echo sprintf('氏名：%s %s', $jinji[$i]['last_name'], $jinji[$i]['first_name']); ?>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?php echo sprintf('メールアドレス：%s', $jinji[$i]['email']); ?></p>
                        <div class="row ml-1">
                            <form method="post" action="jinji_edit.php">
                                <input type="hidden" name="edit_id" value="<?php echo $jinji[$i]['id']; ?>">
                                <input class="btn btn-outline-warning btn-sm" type="submit" value="編集">
                            </form>
                            <form method="post" action="jinji_delete_intention.php">
                                <input type="hidden" name="delete_id" value="<?php echo $jinji[$i]['id']; ?>">
                                <input class="btn btn-outline-danger btn-sm ml-3" type="submit" value="削除">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $i++;
                endwhile;
                $db = null;
            ?>
        </div>
        <a class="btn btn-success my-3" href="jinji_new.php" role="button">管理者 新規登録（ログアウトします）</a>

    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<?php
    unset($_SESSION['status']);
?>