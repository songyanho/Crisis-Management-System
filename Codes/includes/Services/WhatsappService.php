<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

class WhatsappService{
    public static function requestCode(){
        $username = "60187907186";
        $debug = true;
        $r = new Registration($username, $debug);
        return $r->codeRequest('call');
    }
    
    public static function send($message, $target){
        $username = "60187907187";
        $nickname = "CMS from Team Xtreme";
        $password = "Wm/KZrtnInQDdrKLpIUTSG29fH4="; // The one we got registering the number
        $debug = true;
        // Create a instance of WhastPort.
        $w = new WhatsProt($username, $nickname, $debug);
        $w->connect(); // Connect to WhatsApp network
        $w->loginWithPassword($password); 
        $w->sendGetPrivacyBlockedList(); // Get our privacy list [Done automatically by the API]

        $w->sendGetClientConfig(); // Get client config [Done automatically by the API]

        $w->sendGetServerProperties(); // Get server properties [Done automatically by the API]

        $w->sendGetGroups(); // Get groups (participating)

        $w->sendGetBroadcastLists();
        $myContacts = array($target);
        $w->sendSync($myContacts, null, 0);
        $w->sendMessage($target , $message);
        return $w;
    }
    
    public static function registerCode(){
        $username = "60187907186";
        $debug = true;
        $r = new Registration($username, $debug);
        $code = '826240';
        return $r->codeRegister($code);
    }
}