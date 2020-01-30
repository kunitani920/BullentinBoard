<?php
session_start();
require_once '../sanitize.php';
require_once '../Db.php';
require_once '../validation/interestingValidation.php';

if($_SESSION['first_visit'] === 'on' && !empty($_SESSION['pre'])) {
    $clean = $_SESSION;
} else {
    $clean = sanitize::clean($_POST);
}
$error_msg = array();

if($clean['pre'] === ''){
  $error_msg['pre'] = '選択されていません。';
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
  $_SESSION['school'] = $clean['school'];
  $_SESSION['pre'] = $clean['pre'];
  $_SESSION['first_visit'] = 'on';
  header('Location: new_registration_3.php');
  exit();
}

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

    <title>新規登録</title>
</head>

<body>
<div class="container">
    <h2 class="mt-3">内定者懇親フォーム</h2>
    <h4 class="mt-3">ご登録、ありとうございます。<br>あなたのプロフィールを入力してください。</h4>
    <form method="post" action="new_registration_2.php">
        <fieldset class="form-group mt-3">
            <div class="row">
                <div class="col-md-7">
                    <legend class="col-form-label">●学校</legend>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="school" id="College" value="大学生" <?php if($clean['school'] === '大学生' || empty($clean['school'])) { echo 'checked';} ?>>
                        <label class="form-check-label" for="College">大学生</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="school" id="JuniorCollege" value="短大生" <?php if($clean['school'] === '短大生') { echo 'checked';} ?>>
                        <label class="form-check-label" for="JuniorCollege">短大生</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="school" id="Vocational" value="専門学校生" <?php if($clean['school'] === '専門学校生') { echo 'checked';} ?>>
                        <label class="form-check-label" for="Vocational">専門学校生</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="school" id="High" value="高校生" <?php if($clean['school'] === '高校生') { echo 'checked';} ?>>
                        <label class="form-check-label" for="High">高校生</label>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="form-inline mt-3 col-md-12">
            <div class="row">
                <label for="inputPre">●出身</label>
                <select id="inputPre" name="pre" class="form-control mt-1 col-sm-12">
                    <option value="" <?php if(empty($clean['intere'])) { echo 'selected';} ?>>-都道府県を選択-</option>
                    <?php
                        //DB接続
                        $db = new Db();
                        $pdo = $db->dbconnect();
                        $prefectures = $pdo->query('SELECT * FROM prefectures');
                        while($pre = $prefectures->fetch()) {
                        echo '<option value="' . $pre['id'] . '"';
                            if($pre['id'] === $clean['pre']) {
                            echo 'selected';
                            }
                        echo '>' . $pre['pre_name'] . '</option>"';
                        }
                        $pdo = NULL;
                    ?>
                </select>
            </div>
        </div>
        <?php if(!empty($error_msg['pre'])): ?>
        <p class="text-danger"><?php echo $error_msg['pre']; ?></p>
        <?php endif; ?>
        <?php $_SESSION['first_visit'] = 'off'; ?>

        <button class="btn btn-primary mt-3" type="submit" name="submit">次へ</button>

    </form>
</div>
<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

</body>
</html>