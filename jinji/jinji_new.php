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

    <title>人事 新規登録</title>
</head>

<body>
<div class="container">
  <h3 class="mt-3">管理者として登録します。<br>情報を入力してください。</h3>
  <div><br><br></div>
  <form method="post" action="entry_check.php">
  <div class="form-group row">
      <label for="inputEmail3" class="col-sm-3 col-form-label">メールアドレス</label>
      <div class="col-sm-9">
        <input type="email" class="form-control" id="inputEmail3" name="emil" placeholder="Email">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword3" class="col-sm-3 col-form-label">パスワード</label>
      <div class="col-sm-9">
        <input type="password" class="form-control" id="inputPassword3" name='password' placeholder="Password">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-3"></div>
      <div class="col-sm-9">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck1">
          <label class="form-check-label" for="gridCheck1">パスワードを記録する</label>
        </div>
      </div>
    </div>
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

    <button class="btn btn-primary mt-3" type="submit" name="submit">確認画面へ</button>

  </form>
</div>
<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>