<?php

use Propel\Runtime\Formatter\ObjectFormatter;

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->get('/report[/{secret}]', 'ReportController:renderReportPage')->setName(CMS::ROLE_GUEST.'#public@report');

$app->get('/generate-report', 'ReportController:generateReportTrigger')->setName(CMS::ROLE_GUEST.'#public@generate-report');
$app->get('/generate-statistics', 'ReportController:renderRegionStatistics')->setName(CMS::ROLE_GUEST.'#public@generate-statistics');

class ReportController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function renderReportPage($request, $response, $args){
    //    if(!Core::checkNullValue($args["secret"]))
    //        die('Access denied');
    //    if($args["secret"] !== "dfsljhznYMYIENHlihfsk3879")
    //        die('Access denied!');
        $now = new DateTime();
        $today = $now->format('Y-m-d 0:0:0');
        
        $totalCases = IncidentQuery::create()->filterByCreatedAt(['min'=> $today])->find();
        $totalActiveCases = IncidentQuery::create()->filterByCreatedAt(['min'=> $today])->filterByActive(true)->find();
        $output = ['1'=> 0, // west
                   '2'=> 0,
                   '3'=> 0, // north
                   '4'=> 0,
                   '5'=> 0]; // east
        $g = new GeoService();
        foreach($totalCases as $incident){
            $output[$g->pointInPolygon($incident->getLatitude(), $incident->getLongitude())]++;
        }
        
        $stats = [
            'today'=> $totalCases->count(),
            'today-active'=> $totalActiveCases->count(),
            'today-inactive'=> $totalCases->count()-$totalActiveCases->count(),
            'solve-rate'=> number_format(1- ($totalActiveCases->count() - $totalCases->count()), 2)*100,
        ];
        
        $crisisQuery = CrisisQuery::create()->filterByActive(true)->find();
        $crisis = $crisisQuery->count() ? true : false;
        
        $cats = [];
        foreach($totalCases as $v){
            foreach($v->getCategories() as $c){
                if(!in_array($c->getName(), $cats))
                    $cats[$c->getName()] = 0;
                $cats[$c->getName()]++;
            }
        }
        $cats['Dengue']=243;
        
        $catss = [];
        foreach($cats as $k=>$v)
            $catss[] = ['name'=> $k, 'value'=>$v];
        
        $catsA = [];
        foreach(array_keys($cats) as $c){
            $catsA[] = ['label'=> $c,
                        'color'=> '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                        'value'=> $cats[$c]];
        }

        return $this->rdb->view->render($response, 'Report/view.html', [
            'title' => 'Status Report',
            'stats' => $stats,
            'crisis'=> $crisis,
            'categories'=> json_encode($catsA,JSON_UNESCAPED_UNICODE),
            'statcount'=> json_encode($output)
        ]);
    }
    
    public function renderRegionStatistics($request, $response, $args){
        set_time_limit(0);
        $g = new GeoService();
        $now = new DateTime();
        $today = $now->format('Y-m-d 0:0:0');
        $incidents = IncidentQuery::create()->filterByCreatedAt(['min'=> $today])->find();
        $output = ['1'=> 0, // west
                   '2'=> 0,
                   '3'=> 0, // north
                   '4'=> 0,
                   '5'=> 0]; // east
        foreach($incidents as $incident){
            $output[$g->pointInPolygon($incident->getLatitude(), $incident->getLongitude())]++;
        }
        Core::successApiJson('Crisis updates', false, ['stats'=>$output]);
    }
    
    public function generateReportTrigger($request, $response, $args){
        $now = new DateTime();
        $today = $now->format('Y-m-d 0:0:0');
        
        $totalCases = IncidentQuery::create()->filterByCreatedAt(['min'=> $today])->find();
        $totalActiveCases = IncidentQuery::create()->filterByCreatedAt(['min'=> $today])->filterByActive(true)->find();
        
        $stats = [
            'today'=> $totalCases->count(),
            'today-active'=> $totalActiveCases->count(),
            'today-inactive'=> $totalCases->count()-$totalActiveCases->count(),
            'solve-rate'=> number_format(1- ($totalActiveCases->count() - $totalCases->count()), 2)*100,
        ];
        $crisisQuery = CrisisQuery::create()->filterByActive(true)->find();
        $crisis = $crisisQuery->count() ? true : false;
        
        $subject = "CMS Status Report";
        $to = "minister@minister.sg";
        $message = "
        <html>
        <head>
        <title>Report is ready</title>
        </head>
        <body>
        <p>Status: ".($crisis ? 'CRISIS' : 'Safe')."</p>
        <p>Case(Today): ".$stats['today']."</p>
        <p>Acitve Case(Today): ".$stats['today-active']."</p>
        <p>Inactive Case(Today): ".$stats['today-inactive']."</p>
        <p>Conversion Rate(Today): ".$stats['solve-rate']."</p><br />
        <p>Click <a href=\"http://172.21.148.164/report\">here</a> to view complete report<p>
        </body>
        </html>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From: <webmaster@example.com>' . "\r\n";
        $headers .= 'Cc: myboss@example.com' . "\r\n";
        mail($to,$subject,$message,$headers);
        
    }
    
}