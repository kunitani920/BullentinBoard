<?php

//サニタイズ
class Hsc
{
    public static function clean($posts)
    {
        foreach ($posts as $post => $value) {
            if(is_array($value)) {
                foreach($value as $key => $val) {
                    $clean[$post][$key] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
                }
            } else {
                $clean[$post] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }
        return $clean;
    }
}
?>