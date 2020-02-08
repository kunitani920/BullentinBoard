<?php
session_start();
require_once '../sanitize.php';
require_once '../Db.php';
require_once '../validation/messageValidation.php';

$edit_id = $_SESSION['edit_id'];
//first
// $login_member_id = $_SESSION['login_member_id'];

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members_info = $pdo->prepare('SELECT * FROM members_info WHERE member_id=?');
$members_info->execute(array($edit_id));
$member_info = $members_info->fetch();


// if($_SESSION['first_visit'] === 'on') {
//     // $clean = $_SESSION;
//     // $icon = $_SESSION['icon'];
// } else {
    $clean = sanitize::clean($_POST);
    $icon = $_FILES['icon'];
// }
$error_msg = array();

$msg_validation = new messageValidation();
$is_msg = $msg_validation->isMessage($clean['message']);
if(!$is_msg) {
    $error_msg['msg'] = $msg_validation->getErrorMessage();
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['message'] = $clean['message'];
    $_SESSION['icon'] = $icon;
    $_SESSION['icon_delete'] = $clean['icon_delete'];
    $_SESSION['first_visit'] = 'on';
    header('Location: edit_confirm.php');
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

    <title>編集</title>
</head>

<body>
<div class="container">
<p><?php var_dump($clean);?></p>
<h4 class="mt-3">編集したい項目を、変更してください。</h4>
    <form method="post" action="edit_registration_4.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="message">●内定者へ一言（120文字以内）</label>
            <textarea class="form-control" id="message" name="message" rows="3"><?php echo $member_info['message']; ?></textarea>
            <?php if(!$is_msg && $_SESSION['first_visit'] === 'off'): ?>
                <p class="text-danger"><?php echo $error_msg['msg']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group mt-3">
            <h6>●アイコン登録（任意）</h6>
            <p class="text-warning">変更しない場合は、何も入力しないでください</p>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="icon">
                    <label class="custom-file-label" for="customFile" data-browse="参照">
                        <?php
                            //やり直し時、再度入力してもらう必要がある。エラーメッセージがある かつ 前回画像選択している場合
                            if(!empty($error_msg) && !empty($icon['name'])) { 
                                echo '再度画像を選択してください（JPG,PNG）...';
                            } else {
                                echo '画像を選択してください（JPG,PNG）...';
                            }
                        ?>
                    </label>
                </div>
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary reset">取消</button>
                </div>
            </div>
            <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="icon_delete" name="icon_delete" value="on">
                    <label class="form-check-label" for="icon_delete">アイコンを削除する</label>
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