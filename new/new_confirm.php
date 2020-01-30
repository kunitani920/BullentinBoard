<?php
session_start();
require_once '../Db.php';
//DB接続
$db = new Db();
$pdo = $db->dbconnect();

$display = $_SESSION;
$icon = $_SESSION['icon'];

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

    <title>登録内容確認</title>
</head>
<body>
<main>
    <div class="container">
        <div class="row justify-content-center mt-5">         
            <div class="col-sm-12 col-lg-4">
                <div class="row justify-content-center">
                    <?php
                        move_uploaded_file($icon['tmp_name'],'../img/'.$icon['name']);
                    ?>
                    <img src="../img/<?php echo $icon['name']; ?>" class="img-fluid rounded-circle" width="50%" alt="未登録">
                </div>
                <div class="row justify-content-center">
                    <?php
                        for($i = 0; $i < 3; $i++) {
                            $interesting = $pdo->prepare('SELECT intere_name FROM interesting WHERE id=?');
                            $interesting->execute(array($display['intere'][$i]));
                            $intere = $interesting->fetch();
                            echo '<div><span class="badge badge-pill badge-primary mr-1">' . $intere[0] . '</span></div>';
                        }
                    ?>
                </div>
            </div> 

            <div class="col-sm-12 col-lg-6 border bg-info rounded m-2 p-3">
                <?php echo $display['message']; ?>
            </div>

        </div>

    <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-5 card border-info m-2">
            <div class="card-body text-info">
                <p class="card-text">ニックネーム：<?php echo $display['NickName']; ?></p>
            </div>
        </div>
        <div class="col-sm-12 col-lg-5 card border-info m-2">
            <div class="card-body text-info">
                <p class="card-text">所属：<?php echo $display['school']; ?></p>
            </div>
        </div>
        <div class="col-sm-12 col-lg-5 card border-info m-2">
            <div class="card-body text-info">
                <p class="card-text">氏名（任意）：<?php echo $display['LastName'] . ' ' . $display['FirstName']; ?></p>
            </div>
        </div>
        <div class="col-sm-12 col-lg-5 card border-info m-2">
            <div class="card-body text-info">
                <?php 
                    $prefectures = $pdo->prepare('SELECT pre_name FROM prefectures WHERE id=?');
                    $prefectures->execute(array($display['pre']));
                    $pre = $prefectures->fetch();
                    echo '<p class="card-text">出身：' . $pre[0] . '</p>';
                    $db = null;
                ?>
            </div>
        </div>
    </div>
    <form method="post" action="new_registration_db.php">
        <div class="row justify-content-center  mt-3">
            <a class="btn btn-secondary mr-3" href="new_registration_1.php" role="button">やり直す</a>
            <button class="btn btn-primary" type="submit" name="submit">登録する</button>
        </div>
    </form>
    </div>
</main>
 

    <!-- bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>