<?php

if (!defined('IN_CORE_SYSTEM')) {
    die('INVALID DIRECT ACCESS');
}

$app->group('/facebook', function (){
    $this->get('/try0', function ($request, $response, $args){
        
    })->setName('0#public@fb-trytry');
    $this->get('/try', function ($request, $response, $args){
        if(!$_GET['code']){
            $response = $response->withStatus(302)->withHeader('Location', 'https://graph.facebook.com/oauth/authorize?client_id=209084582786884&scope=manage_pages&redirect_uri=http://cms.local/facebook/try');
            return $response;
        }
        $response = $response->withStatus(302)->withHeader('Location', 'https://graph.facebook.com/oauth/access_token?client_id=209084582786884&redirect_uri=http://cms.local/facebook/try&client_secret=6b61bf6de8e1e1e1b7599a2ca462a4aa&code='.$_GET['code']);
        return $response;
        Core::varDumpAndDie($request);
    })->setName('0#public@fb-trytry');
    
    $this->get('/try2', function ($request, $response, $args){
        Core::varDumpAndDie($request);
    })->setName('0#public@fb-trytry');
    
    $this->get('/login', function ($request, $response, $args){
        $fb = new Facebook\Facebook([
            'app_id' => '209084582786884', // Replace {app-id} with your app id
            'app_secret' => '6b61bf6de8e1e1e1b7599a2ca462a4aa', 
            'default_graph_version' => 'v2.2', ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['publish_actions', 'manage_pages']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://cms.local/facebook/callback', $permissions);
        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
        die();
    })->setName(CMS::ROLE_GUEST . '#public@fb');
    // calback
    $this->get('/callback', function ($request, $response, $args){
        $fb = new Facebook\Facebook([
            'app_id' => '209084582786884', // Replace {app-id} with your app id
            'app_secret' => '6b61bf6de8e1e1e1b7599a2ca462a4aa', 
            'default_graph_version' => 'v2.2']);
        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        }catch(FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        }catch(FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            }
            else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }

            exit;
        }

        // Logged in

        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens

        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token

        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('209084582786884'); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
//         $tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        echo '<h3>Long-lived</h3>';
        var_dump($accessToken->getValue());
//        if (!$accessToken->isLongLived()) {
//
//            // Exchanges a short-lived access token for a long-lived one
//
//            try {
//                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
//            }
//
//            catch(FacebookExceptionsFacebookSDKException $e) {
//                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
//                exit;
//            }
//
//            echo '<h3>Long-lived</h3>';
//            var_dump($accessToken->getValue());
//        }

        $_SESSION['fb_access_token'] = (string)$accessToken;
        die();
    })->setName(CMS::ROLE_GUEST . '#public@callback');

    // status

    $this->get('/status', function ($request, $response, $args){
        $fb = new Facebook\Facebook([
            'app_id' => '209084582786884', // Replace {app-id} with your app id
            'app_secret' => '6b61bf6de8e1e1e1b7599a2ca462a4aa', 'default_graph_version' => 'v2.2', ]);
        $fbApp = new Facebook\FacebookApp('209084582786884', '6b61bf6de8e1e1e1b7599a2ca462a4aa');
        $request = new Facebook\FacebookRequest($fbApp, 'CAACZBKUxI90QBAIJUxuFYcDDq7rH7NPJcvZB6t674ZAomvI9nRUUmmzDVSSbgYlnoIjXzMa6WPJC77ZA7oiiivqaAwZApQ2nNcYF5ejl1VPOFR0LjrPTRBZBZC5iZAu5nAo19gjZCeTRvvK46ZCV6ZCnRyIZBlJTDeOcJLctG9gFUlYS8hZB0xpZCudK0EZC8tRQGq2KngZD', 'GET', '/me/accounts?fields=access_token');
        try {
          $response = $fb->getClient()->sendRequest($request);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
        $pageToken = '';
        $graphEdge = $response->getGraphEdge();
        foreach ($graphEdge as $page) {
            if($page->getField('id') == '1710312422581221')
                $pageToken = $page->getField('access_token');
        }
//        Core::varDumpAndDie($pageToken);
        if($pageToken !== ''){
            $request = new Facebook\FacebookRequest($fbApp, $pageToken, 'POST', '/me/feed', ['message'=> 'Post as admin']);
            try {
              $response = $fb->getClient()->sendRequest($request);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              // When Graph returns an error
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              // When validation fails or other local issues
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }
        }
        die();
    })->setName(CMS::ROLE_GUEST . '#public@fbpost');
});
