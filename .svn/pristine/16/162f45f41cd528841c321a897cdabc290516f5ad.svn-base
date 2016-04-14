<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

class NotificationApi{
    const API_URL = 'https://onesignal.com/api/v1/notifications';
    const APP_ID = 'ac42c166-b1bd-401f-abc0-01a282ab8863';
    const REST_KEY = 'MjcyZTI3ZTctMDQxYS00NWRmLWI2ZGQtZGI4ZDU2ZGQxMzFm';
    const HEADINGS = 'CMS Updates';
    
    public function newIncidentNotification($incident){
        $data = ['app_id' => self::APP_ID,
                 'contents' => ["en"=> "New incident: ".$incident->getTitle()],
                 'headings' => ["en"=> self::HEADINGS],
                 'isSafari' => true,
                 'isAnyWeb' => true,
                 'included_segments' => ['Key Decision Maker'],
                 'data' => ['incidentId' => $incident->getId(),
                            'incidentTitle' => $incident->getTitle(),
                            'incidentLatitude' => $incident->getLatitude(),
                            'incidentLongitude' => $incident->getLongitude()]];
        
        $results = $this->sendMessage($data);
        return $results;
    }
    
    private function sendMessage($data){
        $fields = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json',
        'Authorization: Basic '.self::REST_KEY]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}