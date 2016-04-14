<?php

use Propel\Runtime\Formatter\ObjectFormatter;

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/information', function(){
    $this->get('/list', 'InformationController:renderListPage')->setName(CMS::ROLE_AGENCY.'#information@list');
    
    $this->map(['get', 'post'], '/new', 'InformationController:renderNewInformationPage')->setName(CMS::ROLE_AGENCY.'#information@create');
    
    $this->get('/delete/{id}', 'InformationController:renderDeleteInformationPage')->setName(CMS::ROLE_AGENCY.'#information@delete');
    
    $this->get('/send-to-social-media', 'InformationController:renderSendToSocialMediaPage')->setName(CMS::ROLE_AGENCY.'#public@information-spread');
    
});

class InformationController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function renderListPage($request, $response, $args){
        $informations = InformationQuery::create()->orderByCreatedAt('desc')->limit(100)->find();
        return $this->rdb->view->render($response, 'Information/list.html', [
            'title' => 'Information',
            'informations' => $informations
        ]);
    }
    
    public function renderNewInformationPage($request, $response, $args){
        if($request->isPost()){
            $params = $request->getParsedBody();
            if(strlen($params["information"])>0){
                $information = new Information();
                $information->setContent($params["information"]);
                $information->save();
                $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_AGENCY.'#information@list'));
                return $response;
            }
        }
        return $this->rdb->view->render($response, 'Information/create.html', [
            'title' => 'New Information'
        ]);
    }
    
    public function renderDeleteInformationPage($reqeust, $response, $args){
        $information = InformationQuery::create()->findPK($args["id"]);
        if($information){
            $information->delete();
        }
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_AGENCY.'#information@list'));
        return $response;
    }
    
    public function renderSendToSocialMediaPage($request, $response, $args){
        $con = \Propel\Runtime\Propel::getReadConnection(\Map\InformationTableMap::DATABASE_NAME);
        $query = "SELECT * FROM information ORDER BY RAND() LIMIT 1";
        $stmt = $con->prepare($query);
        $res = $stmt->execute();
        $formatter = new ObjectFormatter();
        $formatter->setClass('Information'); //full qualified class name
        $informations = $formatter->format($con->getDataFetcher($stmt));
        
        foreach($informations as $v){
            $information = $v;
        }
        // Facebook Post
        FacebookService::send($information->getContent());
        // Twitter Post
        TwitterService::send($information->getContent());
        die();
    }
    
}