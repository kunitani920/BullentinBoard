<?php
require_once 'BaseValidation.php';

class passwordValidation extends BaseValidation {

    public function isPassword($input) {
        if($input === '') {
            $msg = 'パスワードが入力されていません。';
            $this->addErrorMessage($msg);
        }

        if($msg) {
            return false;
        }
        return true;
    }
}

?>