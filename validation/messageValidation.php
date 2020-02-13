<?php
require_once 'BaseValidation.php';

class messageValidation extends BaseValidation {
    private $max_length = 120;

    public function isMessage($message) {
        if($message === '') {
            $msg = 'メッセージが入力されていません。';
            $this->addErrorMessage($msg);
        }
        
        if($this->max_length < mb_strlen($message)) {
            $msg = '最大文字数を超えています。';
            $this->addErrorMessage($msg);
        }

        if($msg) {
            return false;
        }
        return true;
    }
}

?>