<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

class FacebookService{
    public static function send($msg){
        $fb = new Facebook\Facebook([
            'app_id' => '209084582786884', // Replace {app-id} with your app id
            'app_secret' => '6b61bf6de8e1e1e1b7599a2ca462a4aa', 'default_graph_version' => 'v2.2', ]);
        $fbApp = new Facebook\FacebookApp('209084582786884', '6b61bf6de8e1e1e1b7599a2ca462a4aa');
        $request = new Facebook\FacebookRequest($fbApp, 'CAACZBKUxI90QBAIJUxuFYcDDq7rH7NPJcvZB6t674ZAomvI9nRUUmmzDVSSbgYlnoIjXzMa6WPJC77ZA7oiiivqaAwZApQ2nNcYF5ejl1VPOFR0LjrPTRBZBZC5iZAu5nAo19gjZCeTRvvK46ZCV6ZCnRyIZBlJTDeOcJLctG9gFUlYS8hZB0xpZCudK0EZC8tRQGq2KngZD', 'GET', '/me/accounts?fields=access_token');
        try {
          $response = $fb->getClient()->sendRequest($request);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
//          echo 'Graph returned an error: ' . $e->getMessage();
//          exit;
            return;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
//          echo 'Facebook SDK returned an error: ' . $e->getMessage();
//          exit;
            return;
        }
        $pageToken = '';
        $graphEdge = $response->getGraphEdge();
        foreach ($graphEdge as $page) {
            if($page->getField('id') == '1710312422581221')
                $pageToken = $page->getField('access_token');
        }
        if($pageToken !== ''){
            $request = new Facebook\FacebookRequest($fbApp, $pageToken, 'POST', '/me/feed', ['message'=> $msg]);
            try {
              $response = $fb->getClient()->sendRequest($request);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              // When Graph returns an error
//              echo 'Graph returned an error: ' . $e->getMessage();
//              exit;
                return;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              // When validation fails or other local issues
//              echo 'Facebook SDK returned an error: ' . $e->getMessage();
//              exit;
                return;
            }
        }
    }
    
    public static function sendV0($msg){
        $fb = new Facebook\Facebook([
            'app_id' => '209084582786884', // Replace {app-id} with your app id
            'app_secret' => '6b61bf6de8e1e1e1b7599a2ca462a4aa',
            'default_graph_version' => 'v2.2',
        ]);
//        $request = new FacebookRequest(
//            $session,
//            'GET',
//            '/{page-id}/feed'
//        );
//        $response = $request->execute();
//        $graphObject = $response->getGraphObject();
//        $request = new FacebookRequest($session, 'GET', '/PAGE-ID?fields=access_token');
        $response = $fb->post('/me/feed', ['message'=>$msg],  'CAACZBKUxI90QBAMDbpXHs0GZCcHLDq7Y2TDwvZC9MFctGiZBsxnPaTfJKJfSoQRq2VjG1KCfO00Xrkc8TMBZC9EsoAO1Mh2quZAXjyo4RF2TOIMsLJ01l9wBk9xvt2yy3MGExL1D3JM2jz8Ui0GrduUZBRU4kUv2xzC1GLZAJE209fKxa6d8A2h7qtenWdg7DpkD4uPPSVDLeAZDZD');
        return $response;
    }
}