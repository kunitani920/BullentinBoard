<?php

class BaseValidation {
    private $error_message;

    public function addErrorMessage($msg) {
        $this->error_message = $msg;
        return;
    }

    public function getErrorMessage() {
        return $this->error_message;
    }
}

?>