<?php
session_start();
require_once 'Db.php';

$detail_id = $_POST['detail_id'];

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
<body>
<head>
    <!-- 常にバーを表示させておきたい -->
    <ul class="nav justify-content-end">
            <!-- <li class="nav-item">
                <a class="nav-link active" href="#">一覧</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="#">ログアウト</a>
            </li>
            </ul>
</head>
<main>
<div class="container">
    <p><?php var_dump($_POST); ?></p>
    <div class="row justify-content-center mt-5">         
        <div class="col-sm-12 col-lg-4">
            <div class="row justify-content-center">
            <img class="bd-placeholder-img" width="50%" height="100%" src="./img/<?php echo $member_info['icon']; ?>" alt="未登録" </img>
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

        <div class="col-sm-12 col-lg-6 border bg-info rounded m-2 p-3">
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
    <!-- <form method="post" action="new_registration_db.php">
        <div class="row justify-content-center  mt-3">
            <a class="btn btn-secondary mr-3" href="new_registration_1.php" role="button">やり直す</a>
            <button class="btn btn-primary" type="submit" name="submit">登録する</button>
        </div>
    </form> -->
</div>

<nav aria-label="...">
    <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" href="#">前</a></li>
        <li class="page-item"><a class="page-link" href="list.php">一覧</a></li>
        <li class="page-item"><a class="page-link" href="#">次</a></li>
    </ul>
</nav>
<!-- リンク先がない時、選択できないようにする。などを追加する時
https://getbootstrap.jp/docs/4.2/components/pagination/ -->

</main>
<footer></footer>

<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>
