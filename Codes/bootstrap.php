<?php

define('IN_CORE_SYSTEM', true);
require_once 'vendor/autoload.php';
require_once 'includes/Middlewares/Authentication.php';
require_once 'includes/Dependencies/CMS.php';
require_once 'includes/Dependencies/NotificationApi.php';

require_once 'includes/Sdk/Pusher.php';
require_once 'includes/Sdk/TwitterSdk/TwitterOAuth.php';
require_once 'includes/Sdk/TwitterSdk/TwitterPoster.php';
require_once 'includes/Sdk/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
require_once 'includes/Sdk/pdfcrowd.php';

// System Models
require_once 'includes/Models/Core.php';
require_once 'includes/Models/AuthRoute.php';

// Services
require_once 'includes/Services/FacebookService.php';
require_once 'includes/Services/TwitterService.php';
require_once 'includes/Services/SmsService.php';
