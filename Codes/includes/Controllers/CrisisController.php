<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/crisis', function(){
    $this->get('/list', 'CrisisController:renderCrisisPage')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#public@crisis.list');
    
    $this->get('/status', 'CrisisController:renderStatusPage')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#public@crisis.status');
    
    $this->get('/status/whole', 'CrisisController:renderWholeStatusPage')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#public@crisis.status');

    $this->get('/activate/{type}[/{id}]', 'CrisisController:activateCrisis')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#crisis@activate');
    
    $this->get('/activate-category/{name}', 'CrisisController:changeCategory')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#crisis@activate-category');
    
    $this->get('/deactivate-category/{name}', 'CrisisController:dechangeCategory')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#crisis@deactivate-category');
    
    $this->get('/deactivate/notwhole/{id}', 'CrisisController:deactivateCrisis')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#crisis@deactivate');
    
    $this->get('/deactivate/whole', 'CrisisController:deactivateWholeCrisis')->setName(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#crisis@deactivate');
});

class CrisisController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function renderCrisisPage($request, $response, $args){
        $wCrisis = CrisisQuery::create()->filterByActive(true)->filterByType('whole')->orderByCreatedAt('desc')->limit(100)->find();
        $cCrisis = CrisisQuery::create()->filterByActive(true)->filterByType('category')->orderByCreatedAt('desc')->limit(100)->find();
        $iCrisis = CrisisQuery::create()->filterByActive(true)->filterByType('incident')->orderByCreatedAt('desc')->limit(100)->find();
        $filter = new Twig_SimpleFilter("getCategory", function ($catId) {
            $category = CategoryQuery::create()->findPK($catId);
            if($category == null)
                return "-";
            return $category->getName();
        });
        $filter2 = new Twig_SimpleFilter("getIncident", function ($incidentId) {
            $incident = IncidentQuery::create()->findPK($incidentId);
            if($incident == null)
                return "-";
            return $incident->getTitle();
        });
        $twig = $this->rdb->view->getEnvironment();
        $twig->addFilter($filter);
        $twig->addFilter($filter2);
        return $this->rdb->view->render($response, 'Crisis/list.html', [
            'title' => 'List crisis',
            'wcrisis' => $wCrisis,
            'icrisis' => $iCrisis,
            'ccrisis' => $cCrisis
        ]);
    }
    
    public function renderStatusPage($request, $response, $args){
        $inCrisis = false;
        $crisis = CrisisQuery::create()->filterByActive(true)->find();
        if($crisis->count() > 0)
            $inCrisis = true;
        Core::successApiJson('Crisis updates', false, ['crisis'=>$inCrisis]);
    }
    
    public function renderWholeStatusPage($request, $response, $args){
        $inCrisis = false;
        $crisis = CrisisQuery::create()->filterByType('whole')->filterByActive(true)->find();
        if($crisis->count() > 0)
            $inCrisis = true;
        Core::successApiJson('Crisis updates', false, ['crisis'=>$inCrisis]);
    }
    
    public function activateCrisis($request, $response, $args){
        $crisis = new Crisis();
        $ccc = '';
        $crisis->setActive(true);
        if(strtolower($args["type"]) == 'whole'){
            $pCrisis = CrisisQuery::create()->filterByType('whole')->filterByActive(true)->find();
            if($pCrisis->count() > 0)
                die('got whole le');
            $crisis->setType('whole');
            $ccc = 'national';
        }elseif(strtolower($args["type"]) == 'category'){
            if(!Core::checkNullValue($args["id"]))
                die('no cat id');
            $pCrisis = CrisisQuery::create()->filterByType('category')->filterByActive(true)->filterByTypeId($args["id"])->find();
            if($pCrisis->count() > 0)
                die('got cat le');
            $crisis->setType('category');
            $crisis->setTypeId($args["id"]);
            $category = CategoryQuery::create()->findPK($args["id"]);
            $ccc = $category->getName();
        }elseif(strtolower($args["type"]) == 'incident'){
            if(!Core::checkNullValue($args["id"]))
                die('no id');
            $pCrisis = CrisisQuery::create()->filterByType('incident')->filterByActive(true)->filterByTypeId($args["id"])->find();
            if($pCrisis->count() > 0)
                die('got liao');
            $crisis->setType('incident');
            $crisis->setTypeId($args["id"]);
            $incident = IncidentQuery::create()->findPK($args["id"]);
            $ccc = $incident->getTitle();
        }else{die();}
        $crisis->save();
        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $response = $pusher->trigger('crisis', 'crisis', '{}');
        $this->postToSocialMedia($ccc, true);
        die('<html><head></head><body><script>window.close();</script></html>');
    }
    
    public function changeCategory($request, $response, $args){
        echo 3;
        $name = $args["name"];
        $category = CategoryQuery::create()->filterByName($name)->findOne();
        if($category == null){
            echo $name;
            die($name);
        }
        $pusher = new Pusher(
            '4e92c2e35b7ff5fbbc50',
            '660246915f3056fbe63b',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $crisis = CrisisQuery::create()->filterByActive(true)->filterByType('category')->filterByTypeId($category->getId())->find();
        if($crisis->count() == 0){
            $crisis = new Crisis();
            $crisis->setType('category');
            $crisis->setTypeId($category->getId());
            $crisis->save();
        }
        $response = $pusher->trigger('crisis', 'crisis', '{}');
        $this->postToSocialMedia($category->getName(), true);
        die($response);
    }
    
    public function dechangeCategory($request, $response, $args){
        $name = $args["name"];
        $category = CategoryQuery::create()->filterByName($name)->findOne();
        if($category == null)
            die($name);
        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $crisis = CrisisQuery::create()->filterByActive(true)->filterByType('category')->filterByTypeId($category->getId())->find();
        if($crisis->count() > 0){
            foreach($crisis as $c){
                $c->setActive(false);
                $c->save();
            }
        }
        $crisises = CrisisQuery::create()->filterByActive(true)->find();
        if($crisises->count()<=0)
            $response = $pusher->trigger('crisis', 'nocrisis', '{}');
        else
            $response = $pusher->trigger('crisis', 'crisis', '{}');
        $this->postToSocialMedia($category->getName(), false);
        die($response);
    }
    
    public function deactivateCrisis($request, $response, $args){
        $type = '';
        $typeId = '';
        $ccc = '';
        $crisis = CrisisQuery::create()->findPK($args["id"]);
        if($crisis){
            $type = $crisis->getType();
            $typeId = $crisis->getTypeId();
            $crisis->setActive(false);
            $crisis->save();
        }
        $crisis = CrisisQuery::create()->filterByActive(true)->find();
        if($crisis->count()<=0){
            $pusher = new Pusher(
                'e3633179b41c9a1b5cd6',
                '54b73acc62d4c5c8d74f',
                '188783',
                ['cluster' => 'ap1',
                'encrypted' => true]
            );
            $pusher->trigger('crisis', 'nocrisis', '{}');
        }
        if($type == 'whole')
            $ccc = 'national';
        elseif($type == 'category'){
            $cat = CategoryQuery::create()->findPK($typeId);
            $ccc = $cat->getName();
        }else{
            $incident = IncidentQuery::create()->findPK($typeId);
            $ccc = '"'.$incident->getTitle().'"';
        }
        $this->postToSocialMedia($ccc, false);
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#public@crisis.list'));
        return $response;
    }
    
    public function deactivateWholeCrisis($request, $response, $args){
        $crisis = CrisisQuery::create()->filterByActive(true)->filterByType('whole')->find();
        if($crisis->count() > 0){
            foreach($crisis as $c){
                $c->setActive(false);
                $c->save();
            }
        }
        $crisis = CrisisQuery::create()->filterByActive(true)->find();
        if($crisis->count()<=0){
            $pusher = new Pusher(
                'e3633179b41c9a1b5cd6',
                '54b73acc62d4c5c8d74f',
                '188783',
                ['cluster' => 'ap1',
                'encrypted' => true]
            );
            $pusher->trigger('crisis', 'nocrisis', '{}');
        }
        $this->postToSocialMedia('national', false);
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#public@crisis.list'));
        return $response;
    }
    
    public function postToSocialMedia($crisis, $status){
        $msg = '';
        if($status){
            $msg = 'Government has declared '.strtolower($crisis).' crisis. Please stay tuned for more information through local radio and TV stations. ';
        }else{
            $msg = 'Government has solved the '.strtolower($crisis).' crisis. ';
        }
        $msg .= date("Y-m-d H:i:s");
        // Facebook Post
        FacebookService::send($msg);
        // Twitter Post
        TwitterService::send($msg);
    }
    
}