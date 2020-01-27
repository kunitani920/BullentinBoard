<?php

session_start();
$pre = $_POST['pre'];

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
        <p style="color: red"><?php echo $pre; ?></p>
            <div class="row justify-content-center">               
                <div class="col-sm-12 col-lg-4">
                    <div class="row justify-content-center">
                        <!-- Fアイコン -->
                        <img src="./img/azarashi.png" class="img-fluid rounded-circle" alt="アイコン">
                    </div>
                    <div class="row justify-content-center">
                        <!-- G趣味 -->
                        <div><span class="badge badge-pill badge-primary mr-1">アニメ</span></div>
                        <div><span class="badge badge-pill badge-primary mr-1">漫画</span></div>
                        <div><span class="badge badge-pill badge-primary">映画</span></div>
                    </div>
                </div> 

                <div class="col-sm-12 col-lg-7 border bg-info rounded m-2 p-3">
                    <!-- Eひと言 -->
                    どんな仲間がいるのか楽しみです！内定式で会えるのを楽しみにしています。
                </div>

            </div>

        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">ニックネーム：KOO</p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">所属：大学生</p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">氏名（任意）：谷川邦夫</p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-5 card border-info m-2">
                <div class="card-body text-info">
                    <p class="card-text">出身：千葉県</p>
                </div>
            </div>
                    
        </div>

            <nav aria-label="...">
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="#">前</a></li>
                    <li class="page-item"><a class="page-link" href="#">一覧</a></li>
                    <li class="page-item"><a class="page-link" href="#">次</a></li>
                </ul>
            </nav>
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
