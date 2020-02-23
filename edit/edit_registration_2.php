<?php
session_start();
require_once '../hsc.php';
require_once '../Db.php';
require_once '../validation/prefecturesValidation.php';

//header表示用
$login_jinji_name = $_SESSION['login_jinji_name'];

$edit_id = $_SESSION['edit_id'];

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members_info = $pdo->prepare('SELECT * FROM members_info WHERE member_id=?');
$members_info->execute(array($edit_id));
$member_info = $members_info->fetch();

$clean = Hsc::clean($_POST);

$error_msg = array();

$prefectures_validation = new prefecturesValidation();
$is_pre = $prefectures_validation->isSelected($clean['pre']);
if(!$is_pre) {
    $error_msg['pre'] = $prefectures_validation->getErrorMessage();
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['school'] = $clean['school'];
    $_SESSION['pre'] = $clean['pre'];
    $_SESSION['first_visit'] = 'on';
    header('Location: edit_registration_3.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <title>編集</title>
</head>

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
        <h4 class="mt-3">プロフィール編集 ：２／４</h4>
        <form method="post" action="edit_registration_2.php">
            <fieldset class="form-group mt-3">
                <div class="row">
                    <div class="col-md-7">
                        <legend class="col-form-label">●学校</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="school" id="College" value="大学生" <?php if($member_info['school'] === '大学生') { echo 'checked';} ?>>
                            <label class="form-check-label" for="College">大学生</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="school" id="JuniorCollege" value="短大生" <?php if($member_info['school'] === '短大生') { echo 'checked';} ?>>
                            <label class="form-check-label" for="JuniorCollege">短大生</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="school" id="Vocational" value="専門学校生" <?php if($member_info['school'] === '専門学校生') { echo 'checked';} ?>>
                            <label class="form-check-label" for="Vocational">専門学校生</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="school" id="High" value="高校生" <?php if($member_info['school'] === '高校生') { echo 'checked';} ?>>
                            <label class="form-check-label" for="High">高校生</label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="form-inline mt-3 col-md-12">
                <div class="row">
                    <label for="inputPre">●出身</label>
                    <select id="inputPre" name="pre" class="form-control mt-1 col-sm-12">
                        <option value="">-都道府県を選択-</option>
                        <?php
                            $prefectures = $pdo->query('SELECT * FROM prefectures');
                            while($pre = $prefectures->fetch()) {
                                echo '<option value="' . $pre['id'] . '"';
                                if($pre['id'] === $member_info['prefectures_id']) {
                                    echo 'selected';
                                }
                            echo '>' . $pre['pre_name'] . '</option>"';
                            }
                            $pdo = null;
                        ?>
                    </select>
                </div>
            </div>
            <?php if(!$is_pre && $_SESSION["first_visit"] === "off"): ?>
                <p class="text-danger"><?php echo $error_msg['pre']; ?></p>
            <?php endif; ?>
            <?php $_SESSION['first_visit'] = 'off'; ?>

            <button class="btn btn-primary mt-3" type="submit">次へ</button>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>