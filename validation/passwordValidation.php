<?php
require_once 'BaseValidation.php';

class passwordValidation extends BaseValidation {
    private $min_strlen = 4;
    private $max_strlen = 12;

    public function isPassword($password) {
        if(!isset($password) || $password === '') {
            $msg = 'パスワードが入力されていません。';
            $this->addErrorMessage($msg);
        } elseif(mb_strlen($password) < $this->min_strlen) {
            $msg = $this->min_strlen . '文字以上必要です。';
            $this->addErrorMessage($msg);
        }
        if ($this->max_strlen < mb_strlen($password)) {
            $msg = $this->max_strlen . '文字以内でご入力ください。';
            $this->addErrorMessage($msg);
        }
        
        if($msg) {
            return false;
        }
        return true;
    }

    public function reenterPassword($password, $password2) {
        if(!isset($password2) || $password2 === '') {
            $msg = 'パスワードが入力されていません。';
            $this->addErrorMessage($msg);
        } elseif($password !== $password2) {
            $msg = 'パスワードが一致しません。';
            $this->addErrorMessage($msg);
        }
        
        if($msg) {
            return false;
        }
        return true;
    }
}

?>