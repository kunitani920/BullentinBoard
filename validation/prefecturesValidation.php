
<?php
require_once 'BaseValidation.php';

class prefecturesValidation extends BaseValidation {

    public function isSelected($pre) {
        if(!isset($pre) || $pre === '') {
            $msg = '選択されていません。';
            $this->addErrorMessage($msg);
        }

        if($msg) {
            return false;
        }
        return true;
    }
}

?>