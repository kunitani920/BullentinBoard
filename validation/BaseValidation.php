<?php

class BaseValidation {
    protected $error_messages = array();
    
    public function check($input) {
        if($input === '') {
            $msg = '何も入力されていません。' . PHP_EOL;
            $this->setErrorMessage($msg);
            return false;
        }
        return true;
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