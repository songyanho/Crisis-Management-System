<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

// Middleware
require_once 'includes/Middlewares/Authentication.php';
require_once 'includes/Middlewares/TwigVariableInjectionMiddleware.php';

// Dependencies
require_once 'includes/Dependencies/CMS.php';
require_once 'includes/Dependencies/NotificationApi.php';

require_once 'includes/Sdk/Pusher.php';
require_once 'includes/Sdk/TwitterSdk/TwitterOAuth.php';
require_once 'includes/Sdk/TwitterSdk/TwitterPoster.php';
require_once 'includes/Sdk/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
//require_once 'includes/Sdk/pdfcrowd.php';
require_once 'includes/Sdk/geoPHP/geoPHP.inc';

// System Models
require_once 'includes/Models/Core.php';
require_once 'includes/Models/AuthRoute.php';

// Services
require_once 'includes/Services/FacebookService.php';
require_once 'includes/Services/TwitterService.php';
require_once 'includes/Services/SmsService.php';
require_once 'includes/Services/WhatsappService.php';
require_once 'includes/Services/GeoService.php';
// Controller
//$container = $app->getContainer();
//foreach (glob("includes/Controllers/*.inc.php") as $filename){
//    require_once $filename;
//    $controllerClassName = basename($filename, ".inc.php");
//    $container[$controllerClassName] = function ($c) {
//        Core::varDumpAndDie($c);
//        return new $controllerClassName($c->get('rdb'));   
//    };
//}
require_once 'includes/Controllers/LandingController.inc.php';
require_once 'includes/Controllers/LoginRegistrationController.php';
require_once 'includes/Controllers/MapController.php';
require_once 'includes/Controllers/IncidentController.php';
require_once 'includes/Controllers/CategoryController.php';
require_once 'includes/Controllers/InformationController.php';
require_once 'includes/Controllers/ReportController.php';
require_once 'includes/Controllers/CrisisController.php';
require_once 'includes/Controllers/DemoController.php';
require_once 'includes/Controllers/UserManagementController.php';
require_once 'includes/Controllers/WhatsappController.php';
//require_once 'includes/Controllers/TwitterController.php';
//require_once 'includes/Controllers/FacebookController.php';
require_once 'includes/Controllers/GeoController.php';
//require_once 'includes/Controllers/SMSController.php'; 

