<?php
session_start();
require_once 'Db.php';
require_once 'sanitize.php';

$login_member_id = $_SESSION['login_member_id'];
$login_member_name = $_SESSION['login_member_name'];
$member_count = $_SESSION['member_count'];

//管理者
$login_jinji_id = $_SESSION['login_jinji_id'];
$login_jinji_name = $_SESSION['login_jinji_name'];

//不正ログイン
if(empty($login_member_id) && empty($login_jinji_id)) {
    $_SESSION['status'] = 'not_logged_in';
    header('Location: login.php');
    exit();
}

$clean = array();
$clean = sanitize::clean($_POST);

//prev,nextボタン用
$all_id = $_SESSION['all_id'];
$order = $clean['order'];
$order_max = count($all_id) - 1;
if($clean['transition'] === 'prev') {
    $detail_id = $all_id[--$order];
} elseif($clean['transition'] === 'next') {
    $detail_id = $all_id[++$order];
} else {
    $detail_id = $all_id[$order];
}

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members_info = $pdo->prepare('SELECT * FROM members_info WHERE member_id=?');
$members_info->execute(array($detail_id));
$member_info = $members_info->fetch();

$members_interesting = $pdo->prepare('SELECT * FROM members_interesting WHERE member_id=?');
$members_interesting->execute(array($detail_id));
$member_interesting = $members_interesting->fetch();

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

    <title>詳細ページ</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-
            <?php
                if(isset($login_jinji_id)) {
                    echo 'dark bg-dark">';
                    echo '<span class="navbar-text text-white">';
                    echo sprintf('%s｜メンバー%d人', $login_jinji_name, $member_count);
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
        <h4 class="mt-3">詳細ページ</h4>
        <div class="row justify-content-center mt-5">    
            <div class="col-sm-12 col-lg-4">
                <div class="row justify-content-center">
                    <img class="img-fluid rounded-circle bd-placeholder-img" width="200px" height="200px" src="./img/<?php echo $member_info['icon']; ?>" alt="未登録" </img>
                </div>
                <div class="row justify-content-center">
                    <?php
                        for($i = 1; $i <= 3; $i++) {
                            $intere_db_name = 'interesting' . $i . '_id';
                            $intere_id = $member_interesting[$intere_db_name];
                            $interesting = $pdo->prepare('SELECT intere_name FROM interesting WHERE id=?');
                            $interesting->execute(array($intere_id));
                            $intere = $interesting->fetch();
                            echo '<div><span class="badge badge-pill badge-primary mr-1">' . $intere['intere_name'] . '</span></div>';
                        }
                    ?>
                </div>
            </div> 

            <div class="col-sm-12 col-lg-6 border bg-info text-white rounded m-2 p-3">
                <?php echo $member_info['message']; ?>
            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">ニックネーム：<?php echo $member_info['nick_name']; ?></p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">所属：<?php echo $member_info['school']; ?></p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">氏名（任意）：<?php echo $member_info['last_name'] . ' ' . $member_info['first_name']; ?></p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <?php 
                        $prefectures = $pdo->prepare('SELECT pre_name FROM prefectures WHERE id=?');
                        $prefectures->execute(array($member_info['prefectures_id']));
                        $pre = $prefectures->fetch();
                        echo '<p class="card-text">出身：' . $pre['pre_name'] . '</p>';
                        $db = null;
                    ?>
                </div>
            </div>
        </div>
        
        <div class="pagination justify-content-center">
            <form method="post" action="detail.php">
                <input type="hidden" name="order" value="<?php echo $order; ?>">
                <?php if($order != 0): ?>
                    <input class="btn btn-link" name="transition" type="submit" value="prev">
                <?php endif; ?>
                <?php if($order != $order_max): ?>
                    <input class="btn btn-link" name="transition" type="submit" value="next">
                <?php endif; ?>
            </form>
        </div>
        <?php if($member_info['member_id'] == $login_member_id || isset($login_jinji_id)): ?>
            <div class="row mt-2">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                    <form method="post" action="./edit/edit_branch.php">
                        <input type="hidden" name="edit_id" value="<?php echo $member_info['member_id']; ?>">
                        <input class="btn btn-warning btn-lg btn-block" type="submit" value="編集">
                    </form>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-3 mt-1">
                    <form method="post" action="./delete/delete_intention.php">
                        <input type="hidden" name="delete_id" value="<?php echo $member_info['member_id']; ?>">
                        <input class="btn btn-danger btn-lg btn-block" type="submit" value="削除">
                    </form>
                </div>
            </div>
        <?php endif; ?>


        <div class="row justify-content-center my-3">
            <a class="pagination justify-content-center page-link" href="list.php">一覧へ戻る</a>
        </div>
    </div>    

    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>