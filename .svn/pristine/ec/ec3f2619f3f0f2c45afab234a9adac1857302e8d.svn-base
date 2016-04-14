<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

class Core{
    // User login functions
    public static function checkLoggedUser(){
        $currentSession = self::getLoginSession();
        if(!$currentSession)
            return false;
        $class = $currentSession->getUserType().'Query';
        $user = $class::create()->findPK($currentSession->getUserId());
        return $user == false ? false : $user;
    }
    
    public static function getLoginSession(){
        if(!isset($_SESSION["loggedSessionId"]) || !isset($_SESSION["loggedSessionKey"]))
            return false;
        if(!self::verifyHashing($_SESSION["loggedSessionId"], $_SESSION["loggedSessionKey"]))
            return false;
        $currentSession = LoginSessionQuery::create()->filterByDisabled(false)->findOneBySessionId($_SESSION["loggedSessionId"]);
        if($currentSession == null || $_SESSION["loggedSessionKey"]!=$currentSession->getSessionKey())
            return false;
        if($currentSession->getCreatedAt()->diff(new DateTime(), true)->d > 1){
            $currentSession->setDisabled(true);
            $currentSession->save();
            return false;
        }
        return $currentSession;
    }
    
    public static function loginUser($user){
        if($user === null || $user === false)
            return;
        $i=1;
        $sessionId = session_id()."-".self::generateRandomString($i);
        while(true){
            $thisLoginSession = LoginSessionQuery::create()->findOneBySessionId($sessionId);
            if($thisLoginSession === null)
                break;
            else
                $sessionId = session_id()."-".self::generateRandomString(++$i);
        }
        $previousSessions = LoginSessionQuery::create()->filterByUserId($user->getId())->filterByUserType(get_class($user))->filterByDisabled(false)->find();
        foreach($previousSessions as $ps){
            $ps->setDisabled(true);
            $ps->true;
        }
        $sessionKey = self::createHashing($sessionId);
        $thisLoginSession = new LoginSession();
        $thisLoginSession->setUserId($user->getId());
        $thisLoginSession->setUserType(get_class($user));
        $thisLoginSession->setSessionId($sessionId);
        $thisLoginSession->setSessionKey($sessionKey);
        $thisLoginSession->setDisabled(false);
        $thisLoginSession->save();
        $_SESSION["loggedSessionId"] = $sessionId;
        $_SESSION["loggedSessionKey"] = $sessionKey;
    }
    
    // Hash related functions
    public static function verifyHashing($original, $hash){
        return ($hash == hash('sha256', $original.CMS::SALT));
    }
    
    public static function createHashing($p){
        return hash('sha256', $p.CMS::SALT);
    }
    
    public static function generateRandomString($l=15){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $l; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    // Form validation
    public static function checkNullValue($param){
        return (isset($param) && $param !== null && $param!==''); 
    }
    
    public static function normalizePostJson($json){
        echo 'Depreciated. Please use $request->getParsedBody();';
        die();
        if($json[0] == '"' && $json[strlen($json)-1] == '"')
            $json = substr($json, 1, strlen($json)-2);
        $a = json_decode($json, true);
        if(!is_array($a))
            $a = json_decode(str_replace('\"','"',$json), true);
        return (is_array($a)) ? $a : false;
    }
    
    // Error checking & response
    public static function apiErrorJson($message="Unexpected error", $code=100, $redirect=false, $data=false){
        echo json_encode(array('success'    => "error",
                               'error'      => 'apiError',
                               'message'    => $message,
                               'redirect'   => $redirect,
                               'code'       => $code,
                               'data'       => $data));
        // Code
        // 0    - Success
        // 100  - System error
        // 1000 - New Incident | At least one category required
        // 1100 - New Incident | Name is required
        // 1200 - New Incident | Telephone number is required
        // 1300 - New Incident | Description is required
        // 1400 - New Incident | Location is required
        // 1500 - New Incident | System error: Latitude is required
        // 1600 - New Incident | System error: Longitude is required
        die();
    }
    
    public static function successApiJson($message="success", $redirect=false, $data=false){
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(array('success'    => 'success',
                               'error'      => 'false',
                               'message'    => $message,
                               'redirect'   => $redirect,
                               'code'       => 0,
                               'data'       => $data));
        die();
    }
    
    // Testing method
    public static function varDumpAndDie($param, $die=true){
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
        if($die)
            die();
    }
    
    // Extra
    public static function createSlugFromString($string){
        $s = str_replace(' ', '-', $string);
        $s = preg_replace('/[^A-Za-z0-9\-]/', '', $s);
        return preg_replace('/-+/', '_', $s);
    }
    
    public static function getUserRoleString($user){
        if($user == false)
            return 'Guest';
        if(get_class($user) === "CallOperator")
            return 'Call Operator';
        if(get_class($user) === "Agency")
            return 'Agency';
        if(get_class($user) === "KeyDecisionMaker")
            return 'Key Decision Maker';
        if(get_class($user) === "Minister")
            return 'Minister';
        return 'Guest';
    }
}