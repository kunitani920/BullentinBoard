<?php

class LoginValidation extends BaseValidation {
    private $error_messages = array();
    public function check($input) {
        if($input === '') {
            $msg = '何も入力されていません。';
            $this->setErrorMessage($msg);
        }
    }

    public function setErrorMessage($msg) {
        $this->error_messages[] = $msg;
        return;
    }

    public function getErrorMessages() {
        return $this->error_messages;
    }
}

?>