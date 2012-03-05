<?php
/**
 * User: onwer
 * Date: 11-11-29
 * Time: 下午11:24
 */

class Fun{
    public  static function jump($url){
        header('location:'.$url);
    }
    public static  function curcul(){
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')?'https':'http'.'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    }
}

