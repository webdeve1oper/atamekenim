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