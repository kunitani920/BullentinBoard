<?php
session_start();
require_once '../sanitize.php';
require_once '../validation/messageValidation.php';
require_once '../validation/iconValidation.php';

//2周目で画像の名前は入っているが、内容が拾えていない。しょうがない
// 画像のバリデーション

if($_SESSION['first_visit'] === 'on') {
    $clean = $_SESSION;
    $icon = $_SESSION['icon'];
} else {
    $clean = sanitize::clean($_POST);
    $icon = $_FILES['icon'];
}
$error_msg = array();

$msg_validation = new messageValidation();
$is_msg = $msg_validation->isMessage($clean['message']);
// $icon_validation = new iconValidation();
// $is_icon = $icon_validation->isIcon($icon);

if(!$is_msg) {
    $error_msg['msg'] = $msg_validation->getErrorMessage();
}
// if(!$is_icon) {
//     $error_msg['icon'] = $icon_validation->getErrorMessage();
// }

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['message'] = $clean['message'];
    $_SESSION['icon'] = $icon;
    $_SESSION['first_visit'] = 'on';
    header('Location: new_confirm.php');
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
    <p><?php var_dump($icon); ?></p>
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
                            if(isset($icon['name'])) {  //やり直し時、再度入力してもらう必要がある
                                echo '恐れ入りますが、再度画像を選択してください（JPG,PNG）...';
                            } else {
                                echo '画像を選択してください（JPG,PNG）...';
                            }
                        ?>
                    </label>
                </div>
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary reset">取消</button>
                </div>
                <?php if(!$is_icon && $_SESSION['first_visit'] === 'off'): ?>
                    <p class="text-danger"><?php echo $error_msg['icon']; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <?php $_SESSION['first_visit'] = 'off'; ?>
        <button class="btn btn-primary mt-3" type="submit">次へ</button>

     </form>
</div>
<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

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