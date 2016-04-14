<?php

class Authentication{
    private $c;
    public function __construct($class, $container){
        $this->c = $container;
    }
    public function __invoke($request, $response, $next){
        $secured = false;
        if(method_exists($request->getAttribute('route'), 'getName')){
            $routeName = $request->getAttribute('route')->getName();
        }else{
            $response = $response->withStatus(404);
            return $response;
        }
        $route = new AuthRoute($routeName);
        $this->c->cms->setRoute($route);
        $thisUser = Core::checkLoggedUser();
        $this->c->cms->setUser($thisUser);
        
        if($this->publicAccess($route->getGroup())){
            $response = $next($request, $response);
            return $response;
        }
        
        if($this->restrictedAccess($route->getRoles(), $thisUser, $route->getAction())){
            // Change Name
            $response = $response->withStatus(301)->withHeader("Location", $this->c->router->pathFor(CMS::ROLE_GUEST.'#public@redirect'));
            $response = $next($request, $response);
            return $response;
        }
        // Must be a logged user
        if(!$this->userAccess($thisUser)){
            if($route->getGroup() === 'guest'){
                $response = $next($request, $response);
                return $response;
            }
            $response = $response->withStatus(301)->withHeader("Location", $this->c->router->pathFor(CMS::ROLE_GUEST.'#guest@login.login'));
            $response = $next($request, $response);
            return $response;
        }
        // Must have higher clearance
        else if(!$route->isAllowedByUser($thisUser)){
            // Invalid access
            $response = $response->withStatus(400);
//            $response->write('Invalid access');
            $response = $next($request, $response);
            return $response;
        }
        $response = $next($request, $response);
        return $response;
    }
    
    public function publicAccess($routeGroup){
        if($routeGroup === 'public')
            return true;
        return false;
    }
    
    public function restrictedAccess($roles, $user, $action){
        if(in_array(CMS::ROLE_GUEST, $roles) && 
           $user !== false && 
           $action !== 'logout')
            return true;
        return false;
    }
    
    public function userAccess($user){
        if($user !== false)
            return true;
        return false;
    }
}