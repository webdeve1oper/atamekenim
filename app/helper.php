<?php


if (! function_exists('getHelpId')) {
    function getHelpId($id)
    {
        return str_pad( $id, 8, "0", STR_PAD_LEFT);
    }
}

if (! function_exists('lang')) {
    function lang()
    {
        return app()->getLocale();
    }
}
