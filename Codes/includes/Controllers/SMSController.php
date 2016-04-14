<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/sms', function(){
    $this->get('/sms', function ($request, $response, $args){
       fopen("http://isms.com.my/isms_send.php?un=TeamXtreme2016&pwd=XtremeXtreme&dstno=6598164552&msg=Hi%20John.&type=1&sendid=12345", "r"); 
    })->setName(CMS::ROLE_GUEST.'#public@sms');
});