<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

class TwitterService{
    public static function send($msg){
        return TwitterPoster::tweet($msg);
    }
}