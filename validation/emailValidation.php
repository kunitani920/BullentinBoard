<?php
require_once 'BaseValidation.php';

class emailValidation extends BaseValidation {

    public function isEmail($email) {
        if($email === '') {
            $msg = 'メールアドレスが入力されていません。';
            $this->addErrorMessage($msg);
        }

        if($msg) {
            return false;
        }
        return true;
    }
}

?>