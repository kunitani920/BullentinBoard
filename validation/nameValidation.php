<?php
require_once 'BaseValidation.php';

class nameValidation extends BaseValidation {
    private $max_strlen = 10;

    public function isName($name) {
        if(!isset($name) || $name === '') {
            $msg = '入力されていません。';
            $this->addErrorMessage($msg);
        }

        if($this->max_strlen < mb_strlen($name)) {
            $msg = '10文字以内でご入力ください。';
            $this->addErrorMessage($msg);
        }

        if($msg) {
            return false;
        }
        return true;
    }
}

?>