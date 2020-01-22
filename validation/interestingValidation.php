<?php
require_once 'BaseValidation.php';

class interestingValidation extends BaseValidation {
    private $valid_selection_number = 3;

    public function isSelectionCountMatched($selection_count) {

        if($selection_count === '') {
            $msg = sprintf('%d個選択してください。（1つも選択されていません）', $this->valid_selection_number);
            $this->addErrorMessage($msg);
        } elseif($selection_count < $this->valid_selection_number) {
            $msg = sprintf('%d個選択してください。（%d個しか選択されていません）', $this->valid_selection_number, $selection_count);
            $this->addErrorMessage($msg);
        }
        
        if($this->valid_selection_number < $selection_count) {
            $msg = sprintf('選択は%d個までです。（%d個選択されています）', $this->valid_selection_number, $selection_count);
            $this->addErrorMessage($msg);
        }

        if($msg) {
            return false;
        }
        return true;
    }
}

?>