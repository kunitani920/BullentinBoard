<?php
session_start();
require_once '../Db.php';

//header表示用
$login_jinji_name = $_SESSION['login_jinji_name'];

//DB接続
$db = new Db();
$pdo = $db->dbconnect();

$display = $_SESSION;
$icon = $_SESSION['icon'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <title>編集確認</title>
</head>
<body>
<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-
            <?php
                if(isset($login_jinji_name)) {
                    echo 'dark bg-dark">';
                    echo '<span class="navbar-text text-white">';
                    echo $login_jinji_name . '｜メンバープロフィール';
                } else {
                    echo 'light" style="background-color: #e3f2fd;">';
                    echo '<span class="navbar-text text-primary">';
                    echo 'プロフィール編集中';
                }
            ?>
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
        <h4 class="mt-3">プロフィール内容確認</h4>
        <div class="row justify-content-center mt-5">         
            <div class="col-sm-12 col-lg-4">
                <div class="row justify-content-center">
                    <?php
                        move_uploaded_file($icon['tmp_name'],'../img/'.$icon['name']);
                    ?>
                    <img src="../img/<?php echo $icon['name']; ?>" class="img-fluid rounded-circle" width="40%" height="auto" alt="
                    <?php
                        if($display['icon_delete'] === 'on') {
                            echo 'アイコン削除';
                        } else {
                            echo '変更なし';
                        }
                    ?>
                    ">
                </div>
                <div class="row justify-content-center">
                    <?php
                        for($i = 0; $i < 3; $i++) {
                            $interesting = $pdo->prepare('SELECT intere_name FROM interesting WHERE id=?');
                            $interesting->execute(array($display['intere_array'][$i]));
                            $intere = $interesting->fetch();
                            echo '<div><span class="badge badge-pill badge-primary mr-1">' . $intere['intere_name'] . '</span></div>';
                        }
                    ?>
                </div>
            </div> 

            <div class="col-sm-12 col-lg-6 border bg-info rounded text-white m-2 p-3">
                <?php echo $display['message']; ?>
            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">ニックネーム：<?php echo $display['nick_name']; ?></p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">所属：<?php echo $display['school']; ?></p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">氏名：<?php echo $display['last_name'] . ' ' . $display['first_name']; ?></p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <?php 
                        $prefectures = $pdo->prepare('SELECT pre_name FROM prefectures WHERE id=?');
                        $prefectures->execute(array($display['pre']));
                        $pre = $prefectures->fetch();
                        echo '<p class="card-text">出身：' . $pre['pre_name'] . '</p>';
                        $db = null;
                    ?>
                </div>
            </div>
        </div>
        <form method="post" action="edit_registration_db.php">
            <div class="row justify-content-center">
                <button class="btn btn-secondary my-3 mr-3" type="submit">編集を破棄して一覧画面に戻る</button>
                <button class="btn btn-primary my-3" type="submit" name="prof" value="on">この内容で登録する</button>
            </div>
        </form>
    </div>
</main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>