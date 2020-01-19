<?php

require_once 'common.php';
require_once 'dbconnect.php';
require_once 'validation/BaseValidation.php';

session_start();

// if($_COOKIE['email'] !== '') { //あとで、!==''削除テストする
//   $_POST['emial'] = $_COOKIE['email'];
//   $_POST['password'] = $_COOKIE['password'];
//   $_POST['save'] = ['on'];
// }



if(!empty($_POST)) {
  //ログイン処理
  if ($_POST['email']) {
    $login = $db->prepare('SELECT * FROM members WHERE email=?');
    $login->execute(array($_POST['email']));
    $member = $login->fetch();

    // アドレス、パス一致しか抽出出来ないので、却下
    // $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    // $login->execute(array(
    //   $_POST['email'],
    //   $_POST['text']
    //   //passwordのハッシュ化は、テストが終わってから実装する
    // ));
    // $member = $login->fetch();

    //ログイン成功
    if ($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      //ログイン情報記録
      if($_POST['save'] === 'on') {
        setcookie('email', $_POST['email'], time()+60*60*24*14);
        setcookie('password', $_POST['text'], time()+60*60*24*14);
      }
      header('Location: list.php');
      exit();

    //ログイン失敗
    } else {
      $_SESSION['error'] = 'メールアドレスとパスワードが一致しません' . PHP_EOL;
    }
  } else {
    $_SESSION['error'] = 'メールアドレスが入力されていません。' . PHP_EOL;
  }
}
$db = NULL;
header('Location: login.php');
exit();

?>