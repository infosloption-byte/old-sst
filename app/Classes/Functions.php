<?php
namespace App\Classes;

use Image;
use File;
use DB;
use Excel;

class Functions
{

    //unixTimePhptoJava
    public static function unixTimePhpToJava($time)
    {
        $conTime = $time * 1000;
        return $conTime;
    }

    public static function unixTimeJavaToPhp($time)
    {
        $conTime = $time / 1000;
        return $conTime;
    }

    public static function formatDateToPhp($date)
    {
        $date_format = substr($date, 0, strlen($date) - 3);
        $time_format = substr($date, 13, strlen($date));
        return date("Y-m-d", strtotime(substr($date_format, 0, strlen($date_format) - 8))).' '.date("H:i:s", strtotime($time_format));
    }

    /**
     * Limit a string length if it is more thatn setted characters.
     *
     * @param string $text String that needs to shorten
     * @param int $maxchar Maximum characters allowed to show
     * @param string $end Which text should append at the end of the shortened string.
     *
     * @return string Shortened text
     *
     */
    public static function limit_string($text, $maxchar, $end='...'){
        if (strlen($text) > $maxchar || $text == '') {
            $words = preg_split('/\s/', $text);
            $output = '';
            $i = 0;
            while (1) {
                $length = strlen($output)+strlen($words[$i]);
                if ($length > $maxchar) {
                    break;
                }
                else {
                    $output .= " " . $words[$i];
                    ++$i;
                }
            }
            $output .= $end;
        }
        else {
            $output = $text;
        }
        return $output;
    }

    //message function
    public function redirectWithAlert($routeName, $alertType, $alertTitle, $alertMessage, $type = 'route'){
        try {
            if($alertType == "success")
            {
                $alertTitle = "Done!.";
            }
            else if($alertType == "error")
            {
                $alertTitle = "Notice!.";
            }
            else if($alertType == "warning")
            {
                $alertTitle = "Notice!.";
            }
            else
            {
                $alertTitle = $alertTitle;   
            }
            
            if($type == 'route'){
                return redirect()->route($routeName)->with([
                    $alertType.'.title'   => $alertTitle,
                    $alertType.'.message' => $alertMessage
                ]);
            }elseif($type == 'url'){
                return redirect($routeName)->with([
                    $alertType.'.title'   => $alertTitle,
                    $alertType.'.message' => $alertMessage
                ]);
            }else{
                throw new \Exception("Something went wrong in 'redirectWithAlert' function!.");
            }
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    //created a directory
    public function makeDirNotExist($path, $permission = 0777, $status = true){
        try {
            return File::exists(storage_path($path)) or File::makeDirectory(storage_path($path), $permission, $status); 
        } catch (\Exception $e) {
            throw new \Exception("message : ".$e->getMessage());
        }
    }

    //save image
    public function saveImage($image, $full_dir_path, $width = null, $expectWidth = null, $img_quality = 100){
        try {
            if($width !== null && $expectWidth !== null && $width > $expectWidth)
            {
                $extention = $image->getClientOriginalExtension();

                if($extention == 'gif' || $extention == 'GIF'){
                    $img_real_path = Image::make($image->getRealPath());
                    $img_real_name = $image->getClientOriginalName();
                    $gen_img_name  = date('Ymdhis')."-".$img_real_name;

                    $full_path     = $full_dir_path.'/'.$gen_img_name;
                    $db_path       = str_replace(UPLOADS_DIR, '', $full_dir_path).'/'.$gen_img_name;
                    $saved         = $image->move(storage_path().'/'.$full_dir_path, $gen_img_name);

                    if(count($saved)){
                        return ['path' => $db_path, 'count' => 1];
                    }else{
                        return ['path' => $db_path, 'count' => 0];
                    }
                    
                }else{
                    $img_real_path = Image::make($image->getRealPath());
                    $img_real_name = $image->getClientOriginalName();
                    $gen_img_name  = date('Ymdhis')."-".$img_real_name;
                    
                    $img_real_path->resize($expectWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $full_path     = $full_dir_path.'/'.$gen_img_name;
                    $db_path       = str_replace(UPLOADS_DIR, '', $full_dir_path).'/'.$gen_img_name;
                    $saved         = $img_real_path->save(storage_path($full_path), $img_quality);

                    if(count($saved)){
                        return ['path' => $db_path, 'count' => 1];
                    }else{
                        return ['path' => $db_path, 'count' => 0];
                    }
                }
            }
            else
            {
                $extention = $image->getClientOriginalExtension();

                if($extention == 'gif' || $extention == 'GIF'){
                    $img_real_path = Image::make($image->getRealPath());
                    $img_real_name = $image->getClientOriginalName();
                    $gen_img_name  = date('Ymdhis')."-".$img_real_name;
                    $full_path     = $full_dir_path.'/'.$gen_img_name;
                    $db_path       = str_replace(UPLOADS_DIR, '', $full_dir_path).'/'.$gen_img_name;
                    $saved         = $image->move(storage_path().'/'.$full_dir_path, $gen_img_name);

                    if(count($saved)){
                        return ['path' => $db_path, 'count' => 1];
                    }else{
                        return ['path' => $db_path, 'count' => 0];
                    }
                    
                }else{
                    $img_real_path = Image::make($image->getRealPath());
                    $img_real_name = $image->getClientOriginalName();
                    $gen_img_name  = date('Ymdhis')."-".$img_real_name;
                    $full_path     = $full_dir_path.'/'.$gen_img_name;
                    $db_path       = str_replace(UPLOADS_DIR, '', $full_dir_path).'/'.$gen_img_name;
                    $saved         = $img_real_path->save(storage_path($full_path), $img_quality);

                    if(count($saved)){
                        return ['path' => $db_path, 'count' => 1];
                    }else{
                        return ['path' => $db_path, 'count' => 0];
                    }
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("message : ".$e->getMessage());
        }
    }

    //get date & months & years
    public function readDate($date,$type){
        if($type == 'd'){
            $years = ($date / 365) ; // days / 365 days
            $years = floor($years); // Remove all decimals

            $month = ($date % 365) / 30.5; // I choose 30.5 for Month (30,31) ;)
            $month = floor($month); // Remove all decimals

            $days = ($date % 365); // the rest of days

            if($years > 1){
                $years = $years.' Years ';                
            }else if($years == 1){
                $years = $years.' Year ';
            }else{
                $years = '';
            }

            if($month > 1){
                $month = $month.' Months ';
            }else if($month == 1){
                $month = $month.' Month ';
            }else{
                $month = '';
            }

            if($days > 1){
                $days = $days.' Days ';
            }else{
                $days = $days.' Day ';
            }            

            return $years.$month.$days;  
        }else if($type == 'm'){
            if($date > 1){
                $date = $date.' Months';
            }else{
                $date = $date.' Month';
            }
            return $date; 
        }else{
            if($date > 1){
                $date = $date.' Years';
            }else{
                $date = $date.' Year';
            }
            return $date;
        }
    }

    public function exportExcel($filename,$dataArray)
    {
        Excel::create($filename, function($excel) use($dataArray) {

            $excel->sheet('Sheetname', function($sheet) use($dataArray){

                $sheet->fromArray($dataArray, null, 'A1', false, false);

            });

        })->download('xls');
    }
}