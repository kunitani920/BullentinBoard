<?php

class BaseValidation {
    private $error_messages = array();

    public function addErrorMessage($msg) {
        $this->error_messages[] = $msg;
        return;
    }

    public function getErrorMessages() {
        return $this->error_messages;
    }
}

?>