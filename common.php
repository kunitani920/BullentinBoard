<?php

//サニタイズ
function sanitize($posts) {
    foreach($posts as $key=>$value) {
        $clean[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $clean[$key] .= 'testOK';
    }
    return $clean;
}

?>