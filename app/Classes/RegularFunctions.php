<?php

namespace App\Classes;

class RegularFunctions
{

    static function codeGenerator($prfx,$val){
        if($val <= 9){
            return $prfx."00000" . $val;
        }else if($val > 9 && $val <= 99){
            return $prfx."0000" . $val;
        }else if($val > 9 && $val > 99 && $val <= 999){
            return $prfx."000" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val <= 9999){
            return $prfx."00" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val <= 99999){
            return $prfx."0" . $val;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val > 99999 && $val <= 999999){
            return $prfx.$val;
        }
    }

    static function repeatCodeGenerator($prfx,$val,$rep){
        if($val <= 9){
            return $prfx."00000" . $val .'_'.$rep;
        }else if($val > 9 && $val <= 99){
            return $prfx."0000" . $val .'_'.$rep;
        }else if($val > 9 && $val > 99 && $val <= 999){
            return $prfx."000" . $val .'_'.$rep;
        }else if($val > 9 && $val > 99 && $val > 999 && $val <= 9999){
            return $prfx."00" . $val .'_'.$rep;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val <= 99999){
            return $prfx."0" . $val .'_'.$rep;
        }else if($val > 9 && $val > 99 && $val > 999 && $val > 9999 && $val > 99999 && $val <= 999999){
            return $prfx.$val .'_'.$rep;
        }
    }

    static function calculateTimes($end,$start)
    {
        return abs(strtotime($end)-strtotime($start));
    }

    static function formatTimes($diff)
    {
        $years = floor($diff / (365*60*60*24));

        $months = floor(($diff - $years * 365*60*60*24)
                                       / (30*60*60*24)); 
        
        $days = floor(($diff - $years * 365*60*60*24 - 
                     $months*30*60*60*24)/ (60*60*24));
        $hours = floor(($diff - $years * 365*60*60*24 
               - $months*30*60*60*24 - $days*60*60*24)
                                           / (60*60)); 
        $minutes = floor(($diff - $years * 365*60*60*24 
                 - $months*30*60*60*24 - $days*60*60*24 
                                  - $hours*60*60)/ 60); 
        $seconds = floor(($diff - $years * 365*60*60*24 
                 - $months*30*60*60*24 - $days*60*60*24
                        - $hours*60*60 - $minutes*60));

        $str_time = '';

        if($days!=0)
        {
            $str_time .=$days.'d ';
        }

        if($hours!=0)
        {
            $str_time .=$hours.'h ';
        }

        if($minutes!=0)
        {
            $str_time .=$minutes.'m ';
        }

        if($seconds!=0)
        {
            $str_time .=$seconds.'s';
        }

        return $str_time;

        return [$days,$hours,$minutes,$seconds];
    }

}
