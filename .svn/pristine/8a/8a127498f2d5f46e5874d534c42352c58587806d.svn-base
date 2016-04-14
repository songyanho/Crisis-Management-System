<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}
//die('included');
$app->get('/', 'LandingController:renderLandingPage')->setName(CMS::ROLE_GUEST.'#public@landingPage');

$app->get('/redirect', 'LandingController:renderRedirectPage')->setName(CMS::ROLE_GUEST.'#public@redirect');

class LandingController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function renderLandingPage($request, $response, $args) { 
        return $this->rdb->view->render($response, 'LandingPage/landing.html', []); 
    }
    
    public function renderRedirectPage($request, $response, $args){
        $user = $this->rdb->cms->getUser();
        $role = CMS::getUserRole($user);
        $path = '';
        switch($role){
            case CMS::ROLE_CALL_OPERATOR:
                $path = CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list';
                break;
            case CMS::ROLE_AGENCY:
                $path = CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list';
                break;
            case CMS::ROLE_KEY_DECISION_MAKER:
                $path = CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#map@view';
                break;
            case CMS::ROLE_MINISTER:
                $path = CMS::ROLE_KEY_DECISION_MAKER.'&'.CMS::ROLE_MINISTER.'#map@view';
                break;
            case CMS::ROLE_ADMIN:
                $path = CMS::ROLE_ADMIN.'#user@list';
                break;
            default:
                $path = CMS::ROLE_GUEST.'#public@landingPage';
                break;
        }
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor($path));
        return $response;
    }
}