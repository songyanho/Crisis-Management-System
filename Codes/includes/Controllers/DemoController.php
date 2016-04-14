<?php

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}
$app->group('/demo', function(){
    $this->get('/generate-incidents', 'DemoController:startDemonstrationPage')->setName(CMS::ROLE_GUEST.'#public@generate-incidents');
    $this->get('/remove-incidents', 'DemoController:removeDemonstrationPage')->setName(CMS::ROLE_GUEST.'#public@remove-incidents');
});

class DemoController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function startDemonstrationPage($request, $response, $args){
        set_time_limit(0);
        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $latlons = [[1.3257190374609673, 103.81886668417974],
                    [1.3209138008351875, 103.77354808066411],
                    [1.3209138008351875, 103.70488352988286],
                    [1.3751437810907292, 103.7014503023438],
                    [1.272174452894161, 103.66986460898443],
                    [1.3099303679931262, 103.88066477988286],
                    [1.3964235660027766, 103.72204966757818],
                    [1.3710250910380073, 103.91293711875005],
                    [1.3435669772930412, 103.97954173300786],
                    [1.3723979885106354, 103.85045237753911],
                    [1.350431534909673, 103.79414744589849],
                    [1.4465332610027213, 103.77080149863286],
                    [1.4286860972707336, 103.8497657320313],
                    [1.4238810678889176, 103.80101390097661],
                    [1.3902455836487855, 103.90744395468755],
                    [1.401228652166145, 103.85182566855474],
                    [1.3531773525332127, 103.92872996542974],
                    [1.3531773525332127, 103.74470896933599],
                    [1.2474611900786088, 103.82710643027349],
                    [1.2900227735304848, 103.78590769980474],
                    [1.3483721696559445, 103.88066477988286],
                    [1.3078709689631158, 103.8882178804688],
                    [1.3250325756560657, 103.92872996542974],
                    [1.34082114883984, 103.78247447226568],
                    [1.3964235660027766, 103.67535777304693],
                    [1.2941415990368859, 103.77560801718755],
                    [1.389559140165749, 103.92598338339849]];
        for($i=0; $i<count($latlons); $i++){
            $newIncident = new Incident();
            $newIncident->setTitle("Alien Invasion");
            $newIncident->setLocation("Unknown Location");
            $newIncident->setLatitude($latlons[$i][0]);
            $newIncident->setLongitude($latlons[$i][1]);
            $newIncident->setSeverity(1);
            $newIncident->setActive(true);
            $cat = CategoryQuery::create()->orderById()->findOneByName(ucfirst('Alien Invasion'));
            if($cat == null){
                $cat = new Category();
                $cat->setName(ucfirst('Alien Invasion'));
                $cat->save();
            }
            $newIncident->addCategory($cat);
            $newIncident->save();
            $pusher->trigger('incidents', 'new-incident', $newIncident->toJson());
            usleep(200000);
        }
        die("Done");
    }
    
    public function removeDemonstrationPage($request, $response, $args){
        set_time_limit(0);
        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $incidents = IncidentQuery::create()->filterByLocation("Unknown Location")->find();
        foreach($incidents as $incident){
            $incident->setActive(false);
            $incident->save();
            $pusher->trigger('incidents', 'close-incident', $incident->toJson());
            usleep(100000);
        }
        $incidents = IncidentQuery::create()->filterByLocation("Unknown Location")->delete();
        die("Remove");
    }
    
}