<?php

function assets($path)
{
    return asset($path) . "?v=" . filemtime($_SERVER['DOCUMENT_ROOT'] . '/' . $path);
}

function format_num($number)
{
    return str_replace(',', '.', number_format($number));
}
