<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/twitter', function(){
    $this->get('/tweet', function ($request, $response, $args){
        TwitterPoster::tweet("Test by Songyan1");
    })->setName(CMS::ROLE_GUEST.'#public@twitter');
});