<?php
function convertImage($var1){
    $var2 = "data:image/png;base64," . base64_encode(file_get_contents($var1));
    return $var2;
}