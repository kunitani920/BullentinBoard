<?php
session_start();
require_once 'Db.php';

$login_member_id = $_SESSION['login_member_id'];

//管理者ログイン
$login_jinji_id = $_SESSION['login_jinji_id'];
$login_jinji_name = $_SESSION['login_jinji_name'];

//不正ログイン
if(empty($login_member_id) && empty($login_jinji_id)) {
    $_SESSION['status'] = 'not_logged_in';
    header('Location: login.php');
    exit();
}

$status = $_SESSION['status'];  //アラート表示用

//別ページに行く時必要。（編集破棄で戻った時など）
$_SESSION['first_visit'] = 'on';

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members_info = $pdo->query('SELECT * FROM members_info');
$member_count = 0;
while($member_info[$member_count] = $members_info->fetch()) {
    if($member_info[$member_count]['member_id'] == $login_member_id) {
        $login_member_name = $member_info[$member_count]['last_name'];
        $_SESSION['login_member_name'] = $login_member_name;
    }
    $member_count++;
};
$_SESSION['member_count'] = $member_count;

$members_interesting = $pdo->query('SELECT * FROM members_interesting');
while($member_interesting[] = $members_interesting->fetch());

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

    <title>一覧ページ</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-
            <?php
                if(isset($login_jinji_id)) {
                    echo 'dark bg-dark">';
                    echo '<span class="navbar-text text-white">';
                    echo sprintf('%s｜メンバー %d人', $login_jinji_name, $member_count);
                } else {
                    echo 'light" style="background-color: #e3f2fd;">';
                    echo '<span class="navbar-text text-primary">';
                    echo sprintf('%sさん含め、%d人登録中', $login_member_name, $member_count);
                }
            ?>
            </span>
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <form method="post" action="login.php">
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
            <h4>一覧ページ</h4>
            <?php if(isset($login_jinji_id)): ?>
                <form method="post" action="./jinji/jinji_list.php">
                    <input class="btn btn-link" type="submit" name="list" value="管理者専用ページ">
                </form>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php
                $i = 0;
                while($member_info[$i]):
                    $all_id[] = $member_info[$i]['member_id'];
            ?>
            <div class="col-12 col-lg-6">
                <div class="card mb-3" height="50rem">
                    <div class="row no-gutters">
                        <div class="col-4">
                            <img class="img-fluid rounded-circle bd-placeholder-img mx-auto my-3 d-block" width="80%" height="auto" src="./img/<?php echo $member_info[$i]['icon']; ?>" alt="未登録" </img>
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $member_info[$i]['nick_name']; ?></h5>
                                <p class="card-text"><?php echo $member_info[$i]['last_name']; ?> <?php echo $member_info[$i]['first_name']; ?></p>
                                <p class="card-text">
                                    <?php
                                        echo $member_info[$i]['school'] . "／";
                                        $pre_id = $member_info[$i]['prefectures_id'];
                                        $prefectures = $pdo->prepare('SELECT pre_name FROM prefectures WHERE id=?');
                                        $prefectures->execute(array($pre_id));
                                        $pre = $prefectures->fetch();
                                        echo $pre['pre_name'];
                                        ?>
                                </p>
                                <div class="row mb-3">
                                    <?php
                                        for($j = 1; $j <= 3; $j++) {
                                            $intere_db_name = 'interesting' . $j . '_id';
                                            $intere_id = $member_interesting[$i][$intere_db_name];
                                            $interesting = $pdo->prepare('SELECT intere_name FROM interesting WHERE id=?');
                                            $interesting->execute(array($intere_id));
                                            $intere = $interesting->fetch();
                                            echo '<div><span class="badge badge-pill badge-primary ml-3">' . $intere['intere_name'] . '</span></div>';
                                        }
                                    ?>
                                </div>
                                <div class="row ml-1">
                                    <form method="post" action="detail.php">
                                        <input type="hidden" name="detail_id" value="<?php echo $member_info[$i]['member_id'] ?>">
                                        <input type="hidden" name="order" value="<?php echo $i; ?>">
                                        <input class="btn btn-outline-info btn-sm" type="submit" value="詳細ページ">
                                    </form>
                                    <?php if($member_info[$i]['member_id'] == $login_member_id || isset($login_jinji_id)): ?>
                                        <form method="post" action="./edit/edit_branch.php">
                                            <input type="hidden" name="edit_id" value="<?php echo $member_info[$i]['member_id']; ?>">
                                            <input class="btn btn-outline-warning btn-sm ml-1" type="submit" value="編集">
                                        </form>
                                        <form method="post" action="./delete/delete_intention.php">
                                            <input type="hidden" name="delete_id" value="<?php echo $member_info[$i]['member_id']; ?>">
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