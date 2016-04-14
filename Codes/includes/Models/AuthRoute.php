<?php

class AuthRoute{
    protected $routeName;
    protected $routeRoles;
    protected $routeGroup;
    protected $routeSecondGroup;
    protected $routeAction;
    
    function __construct($route){
        $pos = strpos($route, '#');
        if($pos !== false){}else
            return;
        $pos2 = strpos($route, '@');
        if($pos2 !== false){}else
            return;
        
        $this->routeName   = $route;
        $roles = substr($route, 0, $pos);
        $this->routeRoles   = array_map('intval', explode('&', $roles));
        $this->routeGroup  = substr($route, $pos+1, $pos2-$pos-1);
        $this->routeAction = substr($route, $pos2+1);
        
        $pos3 = strpos($this->routeAction, '.');
        if($pos3 !== false){
            $this->routeSecondGroup = substr($this->routeAction, 0, $pos3);
        }else{
            $this->routeSecondGroup = $this->routeAction;
        }
    }
    
    public function getName(){
        return $this->routeName;
    }
    
    public function getRoles(){
        return $this->routeRoles;
    }
    
    public function isAllowed($role){
        return in_array($role, $this->routeRoles);
    }
    
    public function isAllowedByUser($user){
        $role = CMS::ROLE_GUEST;
        switch(get_class($user)){
            case 'CallOperator':
                $role = CMS::ROLE_CALL_OPERATOR;
                break;
            case 'Agency':
                $role = CMS::ROLE_AGENCY;
                break;
            case 'KeyDecisionMaker':
                $role = CMS::ROLE_KEY_DECISION_MAKER;
                break;
            case 'MINISTER':
                $role = CMS::ROLE_MINISTER;
                break;
            default:
                $role = CMS::ROLE_GUEST;
                break;
        }
        return $this->isAllowed($role);
    }
    
    public function getGroup(){
        return $this->routeGroup;
    }
    
    public function getSecondGroup(){
        return $this->routeSecondGroup;
    }
    
    public function getAction(){
        return $this->routeAction;
    }
    
    public function toArray(){
        return [
            'routeName'         => $this->routeName,
            'routeRole'         => $this->routeRoles,
            'routeGroup'        => $this->routeGroup,
            'secondGroup'       => $this->routeSecondGroup,
            'routeAction'       => $this->routeAction
        ];
    }
}