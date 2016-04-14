<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

/**
 * userStatus - 0: guest
 *              1: loggedIn
 * sessionType- 'web'
 *            - 'api'
 */
class CMS{
    const SALT = 'yDjRYGRVph';
    
    const ROLE_ADMIN = 9;
    const ROLE_MINISTER = 7;
    const ROLE_KEY_DECISION_MAKER = 5;
    const ROLE_AGENCY = 3;
    const ROLE_CALL_OPERATOR = 1;
    const ROLE_GUEST = 0;
    
    protected $userStatus;
    protected $loggedUser;
    protected $session;
    protected $route;
    
    public static $instance;
    
    public static function createOrRetrieve(){
        if(self::$instance == null)
            self::$instance = new CMS();
        return self::$instance;
    }
    
    public function __construct(){
        $this->userStatus = 0;
        $this->loggedUser = false;
        $this->route = false;
        $this->sessionType = false;
        $this->session = false;
        $this->api = false;
        $this->route = null;
    }
    
    public function setUser($user){
        $this->userStatus = 1;
        $this->loggedUser = $user;
    }
    
    public function getUser(){
        return $this->loggedUser;
    }
    
    public function isLogged(){
        return $this->userStatus == 1;
    }
    
    public function logout(){
        $this->userStatus = 0;
        $this->loggedUser = false;
    }
    
    public function setRoute($newRoute){
        $this->route = $newRoute;
    }
    
    public function getRoute(){
        return $this->route;
    }
    
    public function getSessionType(){
        return $this->sessionType;
    }
    
    public function getSession(){
        return $this->session;
    }
    
    public function setSession($type, $session){
        $this->sessionType = $type;
        $this->session = $session;
    }
    
    public function getApi(){
        return $this->api;
    }
    
    public function setApi($api){
        $this->api = $api;
    }
    
    public function toArray(){
        return [
            'loggedUser'    => ($this->loggedUser) ? $this->loggedUser->toReadableArray() : ['username'  => 'Guest','role'  => CMS::ROLE_GUEST],
            'userStatus'    => $this->userStatus,
            'route'         => ($this->route) ? $this->route->toArray() : [],
            'session'       => $this->session ? $this->session : null,
            'sessionType'   => $this->sessionType ? $this->sessionType : null
        ];
    }
    
    public static function getUserRole($user){
        if($user == false)
            return CMS::ROLE_GUEST;
        if(get_class($user) === "CallOperator")
            return CMS::ROLE_CALL_OPERATOR;
        if(get_class($user) === "Agency")
            return CMS::ROLE_AGENCY;
        if(get_class($user) === "KeyDecisionMaker")
            return CMS::ROLE_KEY_DECISION_MAKER;
        if(get_class($user) === "Minister")
            return CMS::ROLE_MINISTER;
        if(get_class($user) === "Admin")
            return CMS::ROLE_ADMIN;
        return CMS::ROLE_GUEST;
    }
    
//    public static function checkAccess($routePath, $user){
//        $role = self::getUserRole($user);
//        $pos = strpos($route, '#');
//        if($pos !== false){}else
//            return false;
//        $roles = substr($route, 0, $pos);
//        $routeRoles   = explode('&', $roles);
//        if($routeRoles === $role || in_array($role, $routeRoles))
//            return true;
//        return false;
//    }
//    public static function checkAccessWithRole($routePath, $role){
//        $pos = strpos($route, '#');
//        if($pos !== false){}else
//            return false;
//        $roles = substr($route, 0, $pos);
//        $routeRoles   = explode('&', $roles);
//        if($routeRoles === $role || in_array($role, $routeRoles))
//            return true;
//        return false;
//    }
}