<?php
session_start();
require_once '../hsc.php';
require_once '../validation/messageValidation.php';
require_once '../validation/iconValidation.php';

if($_SESSION['first_visit'] === 'on') {
    $clean = $_SESSION;
    $icon = $_SESSION['icon'];
} else {
    $clean = Hsc::clean($_POST);
    $icon = $_FILES['icon'];
}
$error_msg = array();

$msg_validation = new messageValidation();
$is_msg = $msg_validation->isMessage($clean['message']);
//iconは登録があった時だけ、バリデーション
if(!empty($icon['name'])) {
    $icon_validation = new iconValidation();
    $is_icon = $icon_validation->isIcon($icon, ''); //第２引数。編集時のチェックボックス
}

if(!$is_msg) {
    $error_msg['msg'] = $msg_validation->getErrorMessage();
}
//icon登録があった時だけ、エラー有無確認
if(isset($is_icon) && !$is_icon) {
    $error_msg['icon'] = $icon_validation->getErrorMessage();
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['message'] = $clean['message'];
    $_SESSION['icon'] = $icon;
    $_SESSION['first_visit'] = 'on';
    header('Location: new_confirm_2.php');
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

    <title>新規登録</title>
</head>

<body style="padding-top:4.5rem;">
    <header>
        <nav class="fixed-top navbar navbar-light" style="background-color: #e3f2fd;">
            <span class="navbar-text text-primary">新規登録中</span>
        </nav>
    </header>
    <div class="container">
        <h4 class="mt-3">プロフィール登録 ：４／４</h4>
        <form method="post" action="new_registration_4.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="message">●内定者へ一言（120文字以内）</label>
                <textarea class="form-control" id="message" name="message" rows="3"><?php if(isset($clean['message'])) { echo $clean['message']; } ?></textarea>
                <?php if(!$is_msg && $_SESSION['first_visit'] === 'off'): ?>
                    <p class="text-danger"><?php echo $error_msg['msg']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <p>●アイコン登録（任意）</p>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="icon">
                        <label class="custom-file-label" for="customFile" data-browse="参照">
                            <?php
                                //やり直し時、再度入力してもらう必要がある。エラーメッセージがある かつ 前回画像選択している場合
                                if(!empty($icon['name'])) { 
                                    echo '再度選択してください（JPG,PNG）';
                                } else {
                                    echo '画像を選択（JPG,PNG）';
                                }
                            ?>
                        </label>
                    </div>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary reset">取消</button>
                    </div>
                </div>
                <?php if(!$is_icon && $_SESSION['first_visit'] === 'off'): ?>
                    <p class="text-danger"><?php echo $error_msg['icon']; ?></p>
                <?php endif; ?>
            </div>

            <?php $_SESSION['first_visit'] = 'off'; ?>
            <button class="btn btn-primary mt-3" type="submit">次へ</button>

        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- 画像登録スクリプト-->
<script>
$('.custom-file-input').on('change',function(){
    $(this).next('.custom-file-label').html($(this)[0].files[0].name);
})
//ファイルの取消
$('.reset').click(function(){
    $(this).parent().prev().children('.custom-file-label').html('ファイル選択...');
    $('.custom-file-input').val('');
})
</script>
</body>
</html>