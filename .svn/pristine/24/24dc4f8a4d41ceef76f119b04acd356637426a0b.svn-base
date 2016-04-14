<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

// Dependencies injection
$container = $app->getContainer();
$container['cms'] = function($c){
    return CMS::createOrRetrieve();
};

$container['notification'] = function($c){
    return new NotificationApi();
};

// Middleware Initialization and Injection
$app->add( new \TwigVariableInjectionMiddleware(Core::class, $container));
$app->add( new \Authentication(Core::class, $container));

//$twig->addFunction(new Twig_SimpleFunction('staticFunctionCall', function($class, $function, $args = array()) {
//    if (class_exists($class) && method_exists($class, $function))
//        return call_user_func_array(array($class, $function), $args);
//    return null;
//}));