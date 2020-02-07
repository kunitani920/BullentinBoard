<?php
require_once 'sanitize.php';
require_once 'Db.php';
require_once 'validation/emailValidation.php';
require_once 'validation/passwordValidation.php';

session_start();

class Login
    {
    private $clean = array();

    public function __construct()
    {
        $this->clean = sanitize::clean($_POST);

        //validation
        $email_validation = new emailValidation();
        $is_email = $email_validation->isEmail($this->clean['email']);
        $password_validation = new passwordValidation();
        $is_password = $password_validation->isPassword($this->clean['password']);

        //validationエラー
        if (!$is_email || !$is_password) {
            $_SESSION['email_error'] = $email_validation->getErrorMessage();
            $_SESSION['password_error'] = $password_validation->getErrorMessage();
            $_SESSION['email'] = $this->clean['email'];
            $_SESSION['first_visit'] = 'off';
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
        $members = $pdo->prepare('SELECT * FROM members WHERE email=?');
        $members->execute(array($this->clean['email']));
        $member = $members->fetch();
        //jinjiテーブル参照
        $admin = $pdo->prepare('SELECT * FROM jinji WHERE email=?');
        $admin->execute(array($this->clean['email']));
        $jinji = $admin->fetch();

        //新規登録（登録emailなし）
        if (!$member && !$jinji) {
            $_SESSION['email'] = $this->clean['email'];
            $_SESSION['password'] = $this->clean['password'];
            $_SESSION['first_visit'] = 'on';
            $pdo = null;
            header('Location: ./new/new_intention.php');
            exit();
        } 
        
        //memberログイン成功（email,password一致）
        if ($member && $member['password'] === $this->clean['password']) {
            $_SESSION['login_member_id'] = $member['id'];
            $_SESSION['first_visit'] = 'on';
            // $_SESSION['time'] = time();
            
            $pdo = null;
            header('Location: list.php');
            exit();
        }
        
        //jinjiログイン成功（email,password一致）
        if ($jinji && $jinji['password'] === $this->clean['password']) {
            // $_SESSION['id'] = $jinji['id'];
        //   $_SESSION['time'] = time();
        //jinji用のフラグ

        $pdo = null;
        header('Location: list.php');
        exit();
        }

        //ログイン失敗（email一致、password不一致）
        $_SESSION['match_error'] = 'メールアドレスとパスワードが一致しません' . PHP_EOL;
        $_SESSION['email'] = $this->clean['email'];
        $_SESSION['first_visit'] = 'off';
        $pdo = null;
        header('Location: login.php');
        exit();
    }
}

$login = new Login();
$login->main();

?>
