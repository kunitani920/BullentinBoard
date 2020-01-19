<?php

require_once 'common.php';
require_once 'dbconnect.php';
require_once 'validation/BaseValidation.php';

session_start();

class Login
{
  const LOGIN_STATUS_NEW = 2;   //新規登録
  const LOGIN_STATUS_TRUE = 1;  //ログイン成功
  const LOGIN_STATUS_FALSE = 0; //ログイン失敗
  private $login_status = self::LOGIN_STATUS_FALSE;
  private $member;

  public function start()
  {
    $_POST = sanitize($_POST);
    $validation = new BaseValidation();
    $check_email = $validation->check($_POST['email']);
    $check_password = $validation->check($_POST['text']);
    if($check_email === false || $check_password = false) {
      $_SESSION['error'] = $validation->getErrorMessages();
      header('Location: login.php');
      exit();
    }
    $this->emailCheck();
    switch($this->login_status) {
      case(self::LOGIN_STATUS_NEW) :
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['text'] = $_POST['text'];
        header('Location: new.php');
      break;

      case(self::LOGIN_STATUS_TRUE) :
        $_SESSION['id'] = $this->member['id'];
        $_SESSION['time'] = time();
        
        //ログイン情報記録
        if($_POST['save'] === 'on') {
          setcookie('email', $_POST['email'], time()+60*60*24*14);
          setcookie('password', $_POST['text'], time()+60*60*24*14);
        }
        header('Location: list.php');
      break;
      
      case(self::LOGIN_STATUS_FALSE) :
        $_SESSION['error'] = 'メールアドレスとパスワードが一致しません' . PHP_EOL;
        header('Location: list.php');
      break;
    }
    exit();
  }

  public function emailCheck()
  {
    $collation = $db->prepare('SELECT * FROM members WHERE email=?'); //jinjiのテーブルも検索対象に入れる
    $collation->execute(array(
    $_POST['email']
    ));
    $this->member = $collation->fetch();

    if (!$this->member) {
        $this->login_status = self::LOGIN_STATUS_NEW;
    }
    if ($this->member['password'] === $_POST['text']) {
        $this->login_status = self::LOGIN_STATUS_TRUE;
    } else {
        $this->login_status = self::LOGIN_STATUS_FALSE;
    }
    $collation = NULL;
  }
}

if (empty($_POST)) {
    $_SESSION['error'] = '入力が確認出来ません。' . PHP_EOL;
    header('Location: login.php');
    exit();
}

$login = new Login();
$login->start();

  header('Location: login.php');
  exit();
  
  //ログイン処理
  // if ($_POST['email']) {
  //   $login = $db->prepare('SELECT * FROM members WHERE email=?');
  //   $login->execute(array($_POST['email']));
  //   $this->member = $login->fetch();
  
    // アドレス、パス一致しか抽出出来ないので、却下
    // $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    // $login->execute(array(
    //   $_POST['email'],
    //   $_POST['text']
    //   //passwordのハッシュ化は、テストが終わってから実装する
    // ));
    // $this->member = $login->fetch();
  ?>