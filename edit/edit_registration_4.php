<?php
session_start();
require_once '../hsc.php';
require_once '../Db.php';
require_once '../validation/messageValidation.php';
require_once '../validation/iconValidation.php';

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
$icon = $_FILES['icon'];

$error_msg = array();

$msg_validation = new messageValidation();
$is_msg = $msg_validation->isMessage($clean['message']);
//iconは登録があった時だけ、バリデーション
if (!empty($icon['name'])) {
    $icon_validation = new iconValidation();
    $is_icon = $icon_validation->isIcon($icon, $clean['icon_delete']);
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
    $_SESSION['icon_delete'] = $clean['icon_delete'];
    $_SESSION['first_visit'] = 'on';
    header('Location: edit_confirm.php');
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
                    <form method="post" action="login.php">
                        <input class="btn btn-link" type="submit" name="../logout" value="ログアウト">
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h4 class="mt-3">プロフィール編集 ：４／４</h4>
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
                                //やり直し時、再度入力してもらう必要がある。
                                if(!empty($error_msg) && !empty($icon['name'])) { 
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
                <div class="form-check form-check-inline">
                    <input type="hidden" name="icon_delete" value="off">
                    <input class="form-check-input" type="checkbox" id="icon_delete" name="icon_delete" value="on">
                    <label class="form-check-label" for="icon_delete">アイコンを削除する</label>
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