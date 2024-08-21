<?php

if (!function_exists('mat')) {
    function mat($matches) {
        return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UTF-16');
    }
}

if (!function_exists('u_decode')) {
    function u_decode($input) {
        return preg_replace_callback('/\\\\u([0-9a-zA-Z]{4})/', 'mat', $input);
    }
}

if (!function_exists('raw_json_encode')) {
    function raw_json_encode($input) {
        return u_decode(json_encode($input));
    }
}
