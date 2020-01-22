<?php
session_start();
require_once 'sanitize.php';
require_once 'Db.php';
require_once 'validation/BaseValidation.php';
require_once 'validation/nameValidation.php';
require_once 'validation/interestingValidation.php';

$clean = sanitize::clean($_POST);

$name_validation = new nameValidation();
$is_last_name = $name_validation->isName($clean['LastName']);
if(!$is_last_name) {
  $error_messages_last_name = $name_validation->getErrorMessages();
}

// $is_first_name = $name_validation->isName($clean['FirstName']);
// $is_nick_name = $name_validation->isName($clean['NickName']);

// if($clean['pre'] === ''){};
//error

// $intere_validation = new interestingValidation();
// $selection_count = count($clean['intere_array']);
// $is_intere = $intere_validation->isSelectionCountMatched($selection_count);

//取り急ぎ、name,interestingのバリデーション作成。
//last_nameでエラー表示の実験をするところで終了

// 各項目ごとにバリデーションチェック
// falseなら、getErrorMessagesして、各項目の下にエラーメッセージ表示
// １つでもfalseがあれば、このページに留まる
// falseが１つもなければ、new_confirmへ

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
  <h3 class="mt-3">ご登録、ありとうございます。<br>あなたのプロフィールを入力してください。</h3>

  <form method="post" action="new.php">
  <!-- <form method="post" action="new_confirm.php"> 同じページアクセスの方が良さそう-->
    <div class="form-row mt-5">
      <div class="form-group col-md-4">
        <label for="inputLastname">氏</label>
        <input type="text" class="form-control" id="inputLastname" name="LastName" placeholder="Last Name（山田）">
      </div>
      <p class="text-danger"><?php foreach($error_messages_last_name as $msg){echo $msg;} var_dump($error_messages_last_name);?></p>
      <div class="form-group col-md-4">
        <label for="inputFirstname">名</label>
        <input type="text" class="form-control" id="inputFirstname" name="FirstName" placeholder="First Name（太郎）">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="inputNickname">ニックネーム</label>
        <input type="text" class="form-control" id="inputNickname" name="NickName" placeholder="ヤマちゃん">
      </div>
    </div>

    <fieldset class="form-group mt-3">
      <div class="row">
        <div class="col-md-7">
          <legend class="col-form-label">●学校</legend>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="school" id="College" value="College" checked>
              <label class="form-check-label" for="College">大学生</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="school" id="JuniorCollege" value="JuniorCollege">
              <label class="form-check-label" for="JuniorCollege">短大生</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="school" id="Vocational" value="Vocational">
              <label class="form-check-label" for="Vocational">専門学校生</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="school" id="High" value="High">
              <label class="form-check-label" for="High">高校生</label>
            </div>
        </div>
      </div>
    </fieldset>

    <div class="form-inline mt-3 col-md-12">
      <div class="row">
        <label for="inputPre">●出身</label>
        <select id="inputPre" name="pre" class="form-control mt-1 col-sm-12">
          <option value="" selected>-都道府県を選択-</option>
          <?php
            //DB接続
            $db = new Db();
            $pdo = $db->dbconnect();
            $prefectures = $pdo->query('SELECT * FROM prefectures');
            while($pre = $prefectures->fetch()) {
              echo '<option value="' . $pre['id'] . '">' . $pre['pre_name'] . '</option>"';
            };
          ?>
        </select>
      </div>
    </div>
    
    <div class="form-group row">
      <div class="mt-3 col-sm-12">●興味があること（３つ選んでください）</div>
      <div class="mt-1 col-sm-12">
        <?php
          $interesting = $pdo->query('SELECT * FROM interesting');
          while($intere = $interesting->fetch()):
        ?>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere<?php echo $intere['id']; ?>" name="intere_array[]" value="<?php echo $intere['id']; ?>">
          <label class="form-check-label" for="intere<?php echo $intere['id'] . '">' . $intere["intere_name"]; ?></label>
        </div>
        <?php endwhile; ?>
      </div>
    </div>

    <div class="form-group">
      <label for="message">●内定者へ一言（120文字以内ーやめようか・・）</label>
      <textarea class="form-control" id="message" name="message" rows="3"></textarea>
    </div>

    <div class="form-group">
      <p>●アイコン登録</p>
      <div class="custom-file">
      <input type="file" class="icon-input" id="iconFile">
      <label class="custom-file-label" for="iconFile">画像を選択してください（JPEG,PNG）</label>
    </div>

    <button class="btn btn-primary mt-3" type="submit" name="submit">確認画面へ</button>

  </form>
</div>
<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>