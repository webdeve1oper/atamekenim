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



if (! function_exists('gender')) {
    function gender($gender)
    {
        switch ($gender){
            case 'male':
                $gender =  'мужчина';
                break;
            case 'female':
                $gender =  'женщина';
                break;
            default:
                $gender = 'не указан';
        }

        return $gender;
    }
}

if (! function_exists('symbolGeneration')) {
    function symbolGeneration($length)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);
    }
}

if (! function_exists('getGenderByIin')) {
    function getGenderByIin(string $iin): ?string
    {
        $genderAndCentury = (int)substr($iin, 6, 1);

        if (in_array($genderAndCentury, [1, 3, 5])) {
            return 'male';
        } elseif (in_array($genderAndCentury, [2, 4, 6])) {
            return 'female';
        }

        return null;
    }
}
if (! function_exists('array_sort_by_column')) {
    function array_sort_by_column(&$arr, $col, $dir = SORT_DESC)
    {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);
    }
}

if(!function_exists('hideText')){
    function hideText($string){
        $search = "/(##)(.*?)(##)/";
        $replace = "***************";
        return preg_replace($search,$replace,$string);
    }
}

if(!function_exists('is_operator')){
    function is_operator(){
        if(\Illuminate\Support\Facades\Auth::user()->role_id == 2){
            return true;
        }
        return false;
    }
}

if(!function_exists('is_admin')){
    function is_admin(){
        if(\Illuminate\Support\Facades\Auth::user()->role_id == 1){
            return true;
        }
        return false;
    }
}
if(!function_exists('is_moderator')){
    function is_moderator(){
        if(\Illuminate\Support\Facades\Auth::user()->role_id == 3){
            return true;
        }
        return false;
    }
}
