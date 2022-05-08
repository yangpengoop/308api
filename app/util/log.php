<?php
namespace app\util;
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2019/11/28
 * Time: 16:37
 */

class WLog{
    public static function fileLog($str){
        $myfile = fopen("/root/log.txt", "w+") ;
        $txt= $str ." \n";

        fwrite($myfile, $txt);

        fclose($myfile);
    }
}


