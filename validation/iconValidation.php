<?php
require_once 'BaseValidation.php';

class iconValidation extends BaseValidation {
    private $accept_ext = array('jpg', 'png');

    public function isIcon($icon) {
        $file_name = $icon['name'];
        $ext = substr($file_name, -3);   //拡張子取得
        if(!in_array($ext, $this->accept_ext, true)) {
            $msg = '「jpg」か「png」のファイルをご指定ください';
            $this->addErrorMessage($msg);
        }
        画像サイズ
        if($this->max_length < mb_strlen($message)) {
            $msg = '最大文字数を超えています。';
            $this->addErrorMessage($msg);
        }

        if($msg) {
            return false;
        }
        return true;
    }
}

?>