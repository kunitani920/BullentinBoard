<?php
require_once 'BaseValidation.php';

class passwordValidation extends BaseValidation {
    private $min_strlen = 4;
    private $max_strlen = 12;

    public function isPassword($password) {
        if($password === '') {
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
        if($password2 === '') {
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

    public function editPassword($password, $edit_password) {
        if($edit_password === 'on') {
            //通常バリデーションへ。変更前と同じかは考慮しない
            return $this->isPassword($password);
        }

        if ($password !== '' && $edit_password === 'off') {
            $msg = '変更する場合は、チェックを入れないでください。';
            $this->addErrorMessage($msg); 
        }
            
        if($msg) {
            return false;
        }
        return true;
    }
}

?>