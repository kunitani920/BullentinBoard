<?php
session_start();
require_once '../Db.php';

//管理者
$login_jinji_id = $_SESSION['login_jinji_id'];
$login_jinji_name = $_SESSION['login_jinji_name'];
//不正ログイン
if(empty($login_jinji_id)) {
    $_SESSION['status'] = 'not_logged_in';
    header('Location: login.php');
    exit();
}

// $status = $_SESSION['status'];  //アラート表示用

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$jinjies = $pdo->query('SELECT * FROM jinji');
$jinji = $jinjies->fetch();

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

    <title>管理者一覧ページ</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-dark bg-dark">
            <span class="navbar-text text-white">
                <?php echo sprintf('%sさんログイン｜管理者一覧', $login_jinji_name); ?>
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
        <?php
            if(!empty($status)):
        ?>
        <div class="alert alert-success" role="alert">
            <?php
                switch ($status) {
                    case 'jinji':
                        echo '管理者でログインしました。';
                    break;
                    case 'login':
                        echo 'ログイン成功しました。';
                    break;
                    case 'new':
                        echo '新規登録が完了しました。';
                    break;
                    case 'edit':
                        echo '編集が完了しました。';
                    break;
                }
            ?>
        </div>
        <?php endif; ?>
    
        <h4 class="mt-3">管理者専用ページ</h4>

            <div class="row">
            <?php
                $i = 0;
                while($jinji[$i]):
                    // $all_id[] = $member_info[$i]['member_id'];
            ?>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <?php echo sprintf('氏名：%s %s', $jinji[$i]['last_name'], $jinji[$i]['first_name']); ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo sprintf('メールアドレス：%s', $jinji[$i]['email']); ?></p>
                            <a href="#" class="btn btn-primary">編集</a>
                            <a href="#" class="btn btn-primary">削除</a>
                        </div>
                    </div>
                </div>
            </div>

編集ボタン、削除ボタンの実装
                        <?php if($member_info[$i]['member_id'] == $login_member_id || isset($login_jinji_id)): ?>
                            <form method="post" action="./edit/edit_branch.php">
                                <input type="hidden" name="edit_id" value="<?php echo $member_info[$i]['member_id']; ?>">
                                <input class="btn btn-outline-warning btn-sm ml-1" type="submit" value="編集">
                            </form>
                            <form method="post" action="./delete/delete_intention.php">
                                <input class="btn btn-outline-danger btn-sm ml-1" type="submit" value="削除">
                            </form>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            <?php
                $i++;
                endwhile;
                $db = null;
                $_SESSION['all_id'] = $all_id;
            ?>
        </div>
    </div>
    
    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>

<?php
    unset($_SESSION['status']);
?>