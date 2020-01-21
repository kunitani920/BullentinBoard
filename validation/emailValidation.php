<?php
require_once 'BaseValidation.php';

class emailValidation extends BaseValidation {

    public function isEmail($input) {
        if($input === '') {
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