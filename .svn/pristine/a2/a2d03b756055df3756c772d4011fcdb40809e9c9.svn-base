<?php

use Propel\Runtime\Formatter\ObjectFormatter;

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/map', function(){
    $this->get('/view', 'MapController:renderMapViewPage')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#map@view');
    
    $this->get('/category-statistics', 'MapController:renderCategoryStatisticsPage')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#map@statistics');
});

class MapController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function renderMapViewPage($request, $response, $args){
        return $this->rdb->view->render($response, 'Map/map.html');
    }
    
    public function renderCategoryStatisticsPage($request, $response, $args){
        $categories = CategoryQuery::create()->find();
        $results = [];
        foreach($categories as $v){
            $incidentCategories = IncidentCategoryQuery::create()->filterByCategory($v)->find();
            $incidentIds = [];
            foreach($incidentCategories as $ic)
                $incidentIds[] = $ic->getIncidentId();
            $incidentCount = IncidentQuery::create()->filterByActive(true)->findPKs($incidentIds);
            $crisis = CrisisQuery::create()->filterByActive(true)->filterByType('category')->filterByTypeId($v->getId())->findOne();
            
            $results[] = ['name'=> $v->getName(),
                          'number'=> $incidentCount->count(),
                          'crisis'=> ($crisis == null) ? false : true];
        }
        Core::successApiJson('Category Statistics', false, ['statistics'=>count($results) ? $results : []]);
    }
}