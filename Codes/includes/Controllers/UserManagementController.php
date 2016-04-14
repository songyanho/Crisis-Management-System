<?php

use Propel\Runtime\Formatter\ObjectFormatter;

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/user', function(){
    $this->get('/list', 'UserManagementController:renderListPage')->setName(CMS::ROLE_ADMIN.'#user@list');
    
    $this->map(['get', 'post'], '/new', 'UserManagementController:renderNewUserPage')->setName(CMS::ROLE_ADMIN.'#user@create');
    
    $this->get('/delete/{id}', 'UserManagementController:renderDeleteUserPage')->setName(CMS::ROLE_ADMIN.'#user@delete');
});

class UserManagementController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function renderListPage($request, $response, $args){
        $users = UserQuery::create()->orderByCreatedAt('asc')->limit(100)->find();
        return $this->rdb->view->render($response, 'User/list.html', [
            'title' => 'User Management',
            'users' => $users
        ]);
    }
    
    public function renderNewUserPage($request, $response, $args){
        $twigVars = [
            'title' => 'New User',
        ];
        if($request->isPost()){
            $params = $request->getParsedBody();
            if(UserQuery::create()->filterByUsername($params["username"])->count() > 0){
                $twigVars['username'] = $params["username"];
                return $this->rdb->view->render($response, 'User/create.html', $twigVars);
            }
            $class = $params["role"];
            $user = new $class();
            $user->setUsername($params["username"]);
            $user->setPassword(Core::createHashing($params["password"]));
            $user->setTel($params["contact-number"]);
            $user->setEmail($params["email"]);
            $user->save();
            $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_ADMIN.'#user@list'));
            return $response;
        }
        return $this->rdb->view->render($response, 'User/create.html', $twigVars);
    }
    
    public function renderDeleteUserPage($reqeust, $response, $args){
        $user = UserQuery::create()->findPK($args["id"]);
        if($user){
            $user->delete();
        }
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_ADMIN.'#user@list'));
        return $response;
    }
    
}