<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/whatsapp', function(){
    $this->get('/request', 'WhatsappController:requestCode')->setName(CMS::ROLE_GUEST.'#public@whatsapp.request');
    $this->get('/register', 'WhatsappController:registerCode')->setName(CMS::ROLE_GUEST.'#public@whatsapp.register');
    $this->get('/send', 'WhatsappController:send')->setName(CMS::ROLE_GUEST.'#public@whatsapp.send');
});

class WhatsappController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function requestCode($request, $response, $args){
        $rs = WhatsappService::requestCode();
        Core::varDumpAndDie($rs);
    }
    
    public function registerCode($request, $response, $args){
        $rs = WhatsappService::registerCode();
        Core::varDumpAndDie($rs);
    }
    
    public function send($request, $response, $args){
        $rs = WhatsappService::send('Test '.time(), '6598164552');
        Core::varDumpAndDie($rs);
    }
}