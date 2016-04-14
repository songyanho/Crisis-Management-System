<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

class SmsService{
    const USERNAME = 'TeamXtreme3';
    const PASSWORD = 'Xtreme3';
    public static function send($msg, $number){
        return file_get_contents("http://isms.com.my/isms_send.php?un=".self::USERNAME."&pwd=".self::PASSWORD."&dstno=0065".$number."&msg=".urlencode($msg)."&type=1&sendid=12345", "r"); 
    }
}