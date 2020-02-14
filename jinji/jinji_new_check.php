<?php
session_start();
require_once '../sanitize.php';
require_once '../Db.php';
require_once '../validation/emailValidation.php';
require_once '../validation/passwordValidation.php';
require_once '../validation/nameValidation.php';

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

        $error_msg = array();

        $name_validation = new nameValidation();
        $is_last_name = $name_validation->isName($this->clean['last_name']);
        if (!$is_last_name) {
            $error_msg['last_name'] = $name_validation->getErrorMessage();
        }
        $is_first_name = $name_validation->isName($this->clean['first_name']);
        if (!$is_first_name) {
            $error_msg['first_name'] = $name_validation->getErrorMessage();
        }
        //入力情報保持（password以外）
        $_SESSION['email'] = $this->clean['email'];
        $_SESSION['last_name'] = $this->clean['last_name'];
        $_SESSION['first_name'] = $this->clean['first_name'];
        //first_visit設定
        $_SESSION['first_visit'] = 'off';
        //validationエラー
        if (!$is_email || !$is_password || !$is_last_name || !$is_first_name) {
            $_SESSION['email_error'] = $email_validation->getErrorMessage();
            $_SESSION['password_error'] = $password_validation->getErrorMessage();
            $_SESSION['last_name_error'] = $error_msg['last_name'];
            $_SESSION['first_name_error'] = $error_msg['first_name'];
            header('Location: jinji_new.php');
            exit();
        }
    }

    public function main()
    {
        //DB接続
        $db = new Db();
        $pdo = $db->dbconnect();
        //jinjiテーブル参照
        $jinjies = $pdo->prepare('SELECT * FROM jinjies WHERE email=?');
        $jinjies->execute(array($this->clean['email']));
        $jinji = $jinjies->fetch();
        //membersテーブル参照
        $members = $pdo->prepare('SELECT * FROM members WHERE email=?');
        $members->execute(array($this->clean['email']));
        $member = $members->fetch();

        //新規登録（登録emailなし）
        if (!$jinji && !$member) {
            $_SESSION['password'] = $this->clean['password'];
            $_SESSION['first_visit'] = 'on';
            $pdo = null;
            header('Location: jinji_new_confirm.php');
            exit();
        }
        
        //email重複（jinjiかmemberにemail有り）
        if ($jinji) {
            $_SESSION['status'] = 'jinji';
        } elseif ($member) {
            $_SESSION['status'] = 'member';
        }
        $pdo = null;
        header('Location: ../login.php');
        exit();
    }
}

$login = new Login();
$login->main();

?>
