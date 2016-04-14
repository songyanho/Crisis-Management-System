<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

class GeoService{
//    public $kmls;
    
    public function __construct(){
//        $this->kmls['1'] = geoPHP::load(file_get_contents('./assets/kml/map1.kml'),'kml');
//        $this->kmls['2'] = geoPHP::load(file_get_contents('./assets/kml/map2.kml'),'kml');
//        $this->kmls['3'] = geoPHP::load(file_get_contents('./assets/kml/map3.kml'),'kml');
//        $this->kmls['4'] = geoPHP::load(file_get_contents('./assets/kml/map4.kml'),'kml');
//        $this->kmls['5'] = geoPHP::load(file_get_contents('./assets/kml/map5.kml'),'kml');
    }
    
    public function pointInPolygon($lat, $lng){
        $lat = floatval($lat);
        $lng = floatval($lng);
//        Core::varDumpAndDie($lat);
        if($lat >= 1.445439)
            return 1;
        if($lat <= 1.404639)
            return 4;
        if($lng <= 103.885345)
            return 2;
        return 3;
//        $point1 = geoPHP::load("POINT($lng $lat)","wkt");
//        foreach($this->kmls as $k=>$geom){
//            foreach($geom->getComponents() as $g){
//                if($g->pointInPolygon($point1) == true)
//                    return $k;
//            }
//        }
//        return 0;
    }
}