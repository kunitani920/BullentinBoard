<?php

//サニタイズ
class sanitize
{
    public function clean($posts)
    {
        foreach ($posts as $key=>$value) {
            $clean[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $clean;
    }
}
?>