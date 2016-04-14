<?php

//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);

define('IN_CORE_SYSTEM', true);
date_default_timezone_set('Asia/Singapore');
error_reporting(E_ERROR ^ E_WARNING);
// create session
session_cache_limiter(false);
session_start();

// Loads all dependencies namely Slim Framework
require_once 'vendor/autoload.php';

// Slim Initialization
require_once 'Init.php';

// Loads all Middleware, Models, Controller
require_once 'Autoload.php';

// Middleware Injection, Dependencies Injection
require_once 'Injection.php';

// Propel Setup
require_once 'generated-conf/config.php';

// Starts Slim Framework
$app->run();