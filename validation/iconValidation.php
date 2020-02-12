<?php
require_once 'BaseValidation.php';

class iconValidation extends BaseValidation {
    private $accept_ext = array('jpg', 'png');

    public function isIcon($icon, $icon_delete) {
        $file_name = $icon['name'];
        $ext = substr($file_name, -3);   //拡張子取得
        if(!in_array($ext, $this->accept_ext, true)) {
            $msg = '「jpg」か「png」のファイルをご指定ください';
            $this->addErrorMessage($msg);
        } elseif (1000000 <= $icon['size']) {
            $msg = '容量が大き過ぎます。1MB未満のファイルをご指定ください';
            $this->addErrorMessage($msg);
        }
        //icon['name']があるのに、削除チェックが入ってる
        if($icon_delete === 'on') {
            $msg = '画像変更の場合は、チェックを外してください';
            $this->addErrorMessage($msg);
        }

        if($msg) {
            return false;
        }
        return true;
    }
}

?>