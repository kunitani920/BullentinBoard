<?php

require_once 'sanitize.php';
require_once 'Db.php';
require_once 'validation/BaseValidation.php';
require_once 'validation/emailValidation.php';
require_once 'validation/passwordValidation.php';

session_start();

class Login
{
  private $clean = array(); //グローバル変数のサニタイズ受取

  public function __construct()
  {
    $this->clean = sanitize::clean($_POST);

    //validation
    $email_validation = new emailValidation();
    $is_email = $email_validation->isEmail($this->clean['email']);
    $password_validation = new passwordValidation();
    $is_password = $password_validation->isPassword($this->clean['text']);

    //validationエラー
    if ($is_email === false || $is_password === false) {
        $_SESSION['email_error'] = $email_validation->getErrorMessages();
        $_SESSION['password_error'] = $password_validation->getErrorMessages();
        header('Location: login.php');
        exit();
    }
  }

  public function main()
  {
    //DB接続
    $db = new Db();
    $pdo = $db->dbconnect();
    //membersテーブル参照
    $collation = $pdo->prepare('SELECT * FROM members WHERE email=?');
    $collation->execute(array($this->clean['email']));
    $member = $collation->fetch();
    //jinjiテーブル参照
    $collation = $pdo->prepare('SELECT * FROM jinji WHERE email=?');
    $collation->execute(array($this->clean['email']));
    $jinji = $collation->fetch();

    //新規登録（登録emailなし）
    if (!$member && !$jinji) {
        $_SESSION['email'] = $this->clean['email'];
        $_SESSION['text'] = $this->clean['text'];
        header('Location: new_intention.php');
    //ログイン成功（email,password一致）
    } elseif ($member['password'] === $this->clean['text']) {
        // $_SESSION['id'] = $member['id'];
        $_SESSION['time'] = time();
        
        //ログイン情報記録
        // if($this->clean['save'] === 'on') {
        //   setcookie('email', $this->clean['email'], time()+60*60*24*14);
        //   setcookie('password', $this->clean['text'], time()+60*60*24*14);
        // }
        header('Location: list.php');
    //ログイン失敗（email一致、password不一致）
    } elseif ($jinji['password'] === $this->clean['text']) {
      // $_SESSION['id'] = $jinji['id'];
      $_SESSION['time'] = time();
      //jinji用のフラグ
      
      //ログイン情報記録
      // if($this->clean['save'] === 'on') {
      //   setcookie('email', $this->clean['email'], time()+60*60*24*14);
      //   setcookie('password', $this->clean['text'], time()+60*60*24*14);
      // }
      header('Location: list.php');
      } else {
        $_SESSION['error'] = 'メールアドレスとパスワードが一致しません' . PHP_EOL;
        header('Location: login.php');
    }
    $collation = NULL;
    exit();
  }
}

$login = new Login();
$login->main();

?>