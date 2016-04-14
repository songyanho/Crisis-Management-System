<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/category', function(){
    $this->get('/list/json', 'CategoryController:renderCategoryJson')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#category@listjson');

    $this->get('/new', 'CategoryController:newCategoryTrigger')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#category@new');
});

class CategoryController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function renderCategoryJson($request, $response, $args){
        $categories = CategoryQuery::create()->find()->toJson();
        return $categories;
    }
    
    public function newCategoryTrigger($request, $response, $args){
        die();
        $a = ['Fire', 'Alien invasion', 'Virus'];
        foreach($a as $b){
            $c = new Category();
            $c->setName($b);
            $c->save();
        }
        die();
    }
    
}