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
  <h3 class="mt-3">ご登録、ありとうございます。<br>あなたのプロフィールを入力してください。</h3>

  <form method="post" action="entry_check.php">
    <div class="form-row mt-5">
      <div class="form-group col-md-6">
        <label for="inputLastname">氏</label>
        <input type="text" class="form-control" id="inputLastname" placeholder="Last Name（山田）">
      </div>
      <div class="form-group col-md-6">
        <label for="inputFirstname">名</label>
        <input type="text" class="form-control" id="inputFirstname" placeholder="First Name（太郎）">
      </div>
    </div>
    <div class="form-group">
      <label for="inputNickname">ニックネーム</label>
      <input type="text" class="form-control" id="inputNickname" placeholder="ヤマちゃん">
    </div>

    <fieldset class="form-group mt-5">
      <div class="row">
        <legend class="col-form-label col-sm-2 pt-0">●学校</legend>
        <div class="col-sm-10">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="school" id="College" value="College" checked>
            <label class="form-check-label" for="College">大学生</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="scholl" id="JuniorCollege" value="JuniorCollege">
            <label class="form-check-label" for="JuniorCollege">短大生</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="scholl" id="Vocational" value="Vocational">
            <label class="form-check-label" for="Vocational">専門学校生</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="scholl" id="High" value="High">
            <label class="form-check-label" for="High">高校生</label>
          </div>
        </div>
      </div>
    </fieldset>

    <div class="form-inline col-md-6">
    <div class="row">
      <label class="my-1 mr-5" for="inputFrom">●出身</label>
      <select id="inputFrom" class="form-control">
        <option value="" selected>-都道府県を選択-</option>
        <option value="1">北海道</option>
        <option value="2">青森県</option>
        <option value="3">岩手県</option>
        <option value="4">宮城県</option>
        <option value="5">秋田県</option>
        <option value="6">山形県</option>
        <option value="7">福島県</option>
        <option value="8">茨城県</option>
        <option value="9">栃木県</option>
        <option value="10">群馬県</option>
        <option value="11">埼玉県</option>
        <option value="12">千葉県</option>
        <option value="13">東京都</option>
        <option value="14">神奈川県</option>
        <option value="15">新潟県</option>
        <option value="16">富山県</option>
        <option value="17">石川県</option>
        <option value="18">福井県</option>
        <option value="19">山梨県</option>
        <option value="20">長野県</option>
        <option value="21">岐阜県</option>
        <option value="22">静岡県</option>
        <option value="23">愛知県</option>
        <option value="24">三重県</option>
        <option value="25">滋賀県</option>
        <option value="26">京都府</option>
        <option value="27">大阪府</option>
        <option value="28">兵庫県</option>
        <option value="29">奈良県</option>
        <option value="30">和歌山県</option>
        <option value="31">鳥取県</option>
        <option value="32">島根県</option>
        <option value="33">岡山県</option>
        <option value="34">広島県</option>
        <option value="35">山口県</option>
        <option value="36">徳島県</option>
        <option value="37">香川県</option>
        <option value="38">愛媛県</option>
        <option value="39">高知県</option>
        <option value="40">福岡県</option>
        <option value="41">佐賀県</option>
        <option value="42">長崎県</option>
        <option value="43">熊本県</option>
        <option value="44">大分県</option>
        <option value="45">宮崎県</option>
        <option value="46">鹿児島県</option>
        <option value="47">沖縄県</option>
        <option value="48">その他</option>
      </select>
    </div>
    </div>
    
    <div class="form-group row">
      <div class="col-sm-12 my-1 mr-5">●興味があること（３つ選んでください）</div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere1" name="intere" value="1">
          <label class="form-check-label" for="intere1">スポーツ</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere2" name="intere" value="2">
          <label class="form-check-label" for="intere2">ゲーム</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere3" name="intere" value="3">
          <label class="form-check-label" for="intere3">音楽</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere4" name="intere" value="4">
          <label class="form-check-label" for="intere4">国内旅行</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere5" name="intere" value="5">
          <label class="form-check-label" for="intere5">海外旅行</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere6" name="intere" value="6">
          <label class="form-check-label" for="intere6">映画</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere7" name="intere" value="7">
          <label class="form-check-label" for="intere7">ショッピング</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere8" name="intere" value="8">
          <label class="form-check-label" for="intere8">漫画</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere9" name="intere" value="9">
          <label class="form-check-label" for="intere9">アニメ</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere10" name="intere" value="10">
          <label class="form-check-label" for="intere10">小説</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere11" name="intere" value="11">
          <label class="form-check-label" for="intere11">健康</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere12" name="intere" value="12">
          <label class="form-check-label" for="intere12">グルメ</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="intere13" name="intere" value="13">
          <label class="form-check-label" for="intere13">カフェ</label>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="message">●内定者へ一言（120文字以内ーやめようか・・）</label>
      <textarea class="form-control" id="message" rows="3"></textarea>
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