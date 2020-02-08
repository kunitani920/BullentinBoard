<?php
session_start();
require_once '../sanitize.php';
require_once '../Db.php';
require_once '../validation/interestingValidation.php';

$edit_id = $_SESSION['edit_id'];
//first
// $login_member_id = $_SESSION['login_member_id'];

//DB接続
$db = new Db();
$pdo = $db->dbconnect();
$members_interesting = $pdo->prepare('SELECT * FROM members_interesting WHERE member_id=?');
$members_interesting->execute(array($edit_id));
$member_interesting = $members_interesting->fetch();
$selected_intere = array(
    $member_interesting['interesting1_id'],
    $member_interesting['interesting2_id'],
    $member_interesting['interesting3_id']
);

$clean = sanitize::clean($_POST);
$error_msg = array();

$intere_validation = new interestingValidation();
$selection_count = count($clean['intere_array']);
$is_intere = $intere_validation->isSelectionCountMatched($selection_count);
if(!$is_intere) {
    $error_msg['intere'] = $intere_validation->getErrorMessage();
}

if(empty($error_msg) && $_SESSION['first_visit'] === 'off') {
    $_SESSION['intere_array'] = $clean['intere_array'];
    $_SESSION['first_visit'] = 'on';
    header('Location: edit_registration_4.php');
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
<h4 class="mt-3">編集したい項目を、変更してください。</h4>

    <form method="post" action="edit_registration_3.php">
        <div class="form-group row">
            <div class="mt-3 col-sm-12">●興味があること（３つ選んでください）</div>
            <div class="mt-1 col-sm-12">
                <?php
                    $interesting = $pdo->query('SELECT * FROM interesting');
                    while($intere = $interesting->fetch()):
                ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="intere<?php echo $intere['id']; ?>" name="intere_array[]" value="<?php echo $intere['id']; ?>" 
                    <?php
                        if(in_array($intere['id'], $selected_intere, true)) {
                            echo 'checked';
                        }
                    ?>
                    >
                    <label class="form-check-label" for="intere<?php echo $intere['id'] . '">' . $intere["intere_name"]; ?></label>
                </div>
                <?php endwhile; ?>
                <?php if(!$is_intere && $_SESSION["first_visit"] === "off"): ?>
                    <p class="text-danger"><?php echo $error_msg["intere"]; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php $_SESSION["first_visit"] = 'off'; ?>

        <button class="btn btn-primary mt-3" type="submit">次へ</button>

    </form>
</div>
<!-- bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

</body>
</html>