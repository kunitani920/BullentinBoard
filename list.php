<?php
session_start();
require_once 'Db.php';
//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members_info = $pdo->query('SELECT * FROM members_info');
while($member_info[] = $members_info->fetch());

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
            <!-- カード -->
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
                                <img class="bd-placeholder-img" width="100%" height="100%" src="./img/<?php echo $member_info[$i]['icon']; ?>" alt="未登録" </img>
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
                                    <form method="post" action="detail.php">
                                        <input type="hidden" name="detail_id" value="<?php echo $member_info[$i]['member_id'] ?>">
                                        <input type="hidden" name="order" value="<?php echo $i; ?>">
                                        <input class="btn btn-outline-info" type="submit" value="詳細ページ">
                                    </form>
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

            <!-- <nav aria-label="...">
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="#">前</a></li>
                    <li class="page-item"><a class="page-link" href="#">一覧</a></li>
                    <li class="page-item"><a class="page-link" href="#">次</a></li>
                </ul>
            </nav> -->
            <!-- リンク先がない時、選択できないようにする。などを追加する時
            https://getbootstrap.jp/docs/4.2/components/pagination/ -->
        </div>
    </main>
    <footer></footer>

    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>