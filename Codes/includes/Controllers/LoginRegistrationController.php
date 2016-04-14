<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/guest', function(){
    /* Deprecated */
    $this->get('/new-admin-account', 'LoginRegisterController:newAccountTrigger')->setName(CMS::ROLE_GUEST.'#guest@account.create');
    
    $this->map(['get', 'post'], '/login', 'LoginRegisterController:renderLoginPage')->setName(CMS::ROLE_GUEST.'#guest@login.login');
    
    $this->get('/logout', 'LoginRegisterController:renderLogoutPage')->setName(CMS::ROLE_GUEST.'#public@login.logout');
});

class LoginRegisterController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function newAccountTrigger($request, $response, $args){
        die();
        $user = new Admin();
        $user->setUsername('admin');
        $user->setPassword(Core::createHashing('admin'));
        $user->setTel('84092272');
        $user->setEmail('hoso0003@e.ntu.edu.sg');
        $user->save();
        return $response;
    }
    
    public function renderLoginPage($request, $response, $args) {
        $twigVar = ['title' => 'Login', 'error' => false];
        if($request->isPost()){
            $params = $request->getParsedBody();
            $user = null;
            switch($params['domain']){
                case 'CallOperator':
                    $user = CallOperatorQuery::create()->findOneByUsername($params['username']);
                    break;
                case 'Agency':
                    $user = AgencyQuery::create()->findOneByUsername($params['username']);
                    break;
                case 'KeyDecisionMaker':
                    $user = KeyDecisionMakerQuery::create()->findOneByUsername($params['username']);
                    break;
                case 'Minister':
                    $user = MinisterQuery::create()->findOneByUsername($params['username']);
                    break;
                case 'Admin':
                    $user = AdminQuery::create()->findOneByUsername($params['username']);
                    break;
                default:
                    $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_GUEST.'#guest@login.login'));
                    return $response;
                    break;
            }
            if($user != false){
                if(Core::verifyHashing($params['password'], $user->getPassword())){
                    Core::loginUser($user);
                    $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_GUEST.'#public@redirect'));
                    return $response;
                }
            }
            $twigVar['error'] = true;
        }
        return $this->rdb->view->render($response, 'LoginRegistration/login.html', $twigVar);
    }
    
    public function renderLogoutPage($request, $response, $args){
        if($user != false){
            $currentSession = LoginSessionQuery::create()->filterByUserId($this->cms->getUser()->getId())
                                                         ->filterByUserType(get_class($this->cms->getUser()))
                                                         ->filterByDisabled(false)
                                                         ->findOne();
            if($currentSession != false){
                $currentSession->setDisabled(true);
                $currentSession->save();
            }
        }
        session_destroy();
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_GUEST.'#public@redirect'));
        return $response;
    }
    
    
}