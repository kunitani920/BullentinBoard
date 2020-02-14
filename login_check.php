<?php
session_start();
require_once 'sanitize.php';
require_once 'Db.php';
require_once 'validation/emailValidation.php';
require_once 'validation/passwordValidation.php';

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
        $jinjies = $pdo->prepare('SELECT * FROM jinjies WHERE email=?');
        $jinjies->execute(array($this->clean['email']));
        $jinji = $jinjies->fetch();

        //新規登録（登録emailなし）
        if (!$member && !$jinji) {
            $_SESSION['email'] = $this->clean['email'];
            $_SESSION['password'] = $this->clean['password'];
            $_SESSION['first_visit'] = 'on';
            $pdo = null;
            header('Location: ./new/new_confirm_1.php');
            exit();
        } 
        
        //memberログイン成功（email,password一致）
        if ($member && password_verify($this->clean['password'], $member['password'])) {
            $_SESSION['status'] = 'login';
            $_SESSION['login_member_id'] = $member['id'];
            // $_SESSION['first_visit'] = 'on';
            
            $pdo = null;
            header('Location: list.php');
            exit();
        }
        
        //jinjiログイン成功（email,password一致）
        if ($jinji && password_verify($this->clean['password'], $jinji['password'])) {
            $_SESSION['status'] = 'login';
            $_SESSION['login_jinji_id'] = $jinji['id'];
            // $_SESSION['first_visit'] = 'on';

        $pdo = null;
        header('Location: ./jinji/jinji_list.php');
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
