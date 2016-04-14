<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/geo', function(){
    $this->get('/try', 'GeoController:tryCtrl')->setName(CMS::ROLE_GUEST.'#public@geo.try');
//    $this->get('/register', 'WhatsappController:registerCode')->setName(CMS::ROLE_GUEST.'#public@whatsapp.register');
//    $this->get('/send', 'WhatsappController:send')->setName(CMS::ROLE_GUEST.'#public@whatsapp.send');
});

class GeoController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function tryCtrl($request, $response, $args){
        $geom1 = geoPHP::load(file_get_contents('./assets/kml/map1.kml'),'kml');
        $geom2 = geoPHP::load(file_get_contents('./assets/kml/map2.kml'),'kml');
        $geom3 = geoPHP::load(file_get_contents('./assets/kml/map3.kml'),'kml');
        $geom4 = geoPHP::load(file_get_contents('./assets/kml/map4.kml'),'kml');
        $geom5 = geoPHP::load(file_get_contents('./assets/kml/map5.kml'),'kml');
        $lat = 1.3442364;
        $lng = 103.6861052;
//        $point1 = geoPHP::load("POINT($lat $lng)","wkt");
        $point1 = geoPHP::load("POINT($lng $lat)","wkt");
//        Core::varDumpAndDie($geom1->getComponents()[0]);
//        var_dump($geom1->pointInPolygon($point1));
//        foreach($geom1->getComponents() as $g)
//            var_dump($g->pointInPolygon($point1));
//        echo "<br />";
//        foreach($geom2->getComponents() as $g)
//            var_dump($g->pointInPolygon($point1));
//        echo "<br />";
//        foreach($geom3->getComponents() as $g)
//            var_dump($g->pointInPolygon($point1));
//        echo "<br />";
//        foreach($geom4->getComponents() as $g)
//            var_dump($g->pointInPolygon($point1));
//        echo "<br />";
//        foreach($geom5->getComponents() as $g)
//            var_dump($g->pointInPolygon($point1));
//        echo "<br />";
//        var_dump($geom1->contains($point1));
//        var_dump($geom2->contains($point1));
//        var_dump($geom3->contains($point1));
//        var_dump($geom4->contains($point1));
//        var_dump($geom5->contains($point1));
//        echo count($gs);
        Core::varDumpAndDie('');
    }
    
    public function registerCode($request, $response, $args){
        $rs = WhatsappService::registerCode();
        Core::varDumpAndDie($rs);
    }
    
    public function send($request, $response, $args){
        $rs = WhatsappService::send('Test '.time(), '6598164552');
        Core::varDumpAndDie($rs);
    }
}