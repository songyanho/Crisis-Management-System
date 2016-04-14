<?php

use Propel\Runtime\Formatter\ObjectFormatter;

if (!defined('IN_CORE_SYSTEM')){die('INVALID DIRECT ACCESS');}

$app->group('/incident', function(){
    $this->get('/list/active', 'IncidentController:renderActiveIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-active');
    
    $this->get('/list/inactive', 'IncidentController:renderInactiveIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-inactive');
    
    $this->get('/list/all', 'IncidentController:renderAllIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list');
    
    $this->get('/list/cat/active', 'IncidentController:renderActiveCatIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-cat-active');
    
    $this->get('/list/cat/inactive', 'IncidentController:renderInactiveCatIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-cat-inactive');
    
    $this->get('/list/cat/all', 'IncidentController:renderAllCatIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list-cat');
    
    $this->get('/new', 'IncidentController:renderNewIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@new');
    
    $this->post('/new-incident', 'IncidentController:renderNewIncidentSubmitPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@new-incident');
    
    $this->post('/exist-incident', 'IncidentController:renderExistIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@exist-incident');
    
    $this->post('/find-incidents', 'IncidentController:renderSearchIncidentAroundPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@find-incidents');
    
    $this->post('/find-reporters', 'IncidentController:renderSearchReporterPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@find-reporters');
    
    $this->post('/new-reporter', 'IncidentController:renderNewReporterPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@new-reporter');
    
    $this->post('/new-resource', 'IncidentController:renderNewDispatchPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@new-resource');
    
    $this->post('/new-categories-and-resource', 'IncidentController:renderNewDispatchAndCategoryPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@new-categories-and-resource');
    
    $this->post('/get-categories-and-resources', 'IncidentController:renderCategoryAndResourceRecordPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@get-categories');
    
    $this->get('/view/{id}', 'IncidentController:renderIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@view');
    
    $this->get('/close/{id}', 'IncidentController:renderCloseIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@close-incident');
    
    $this->get('/open/{id}', 'IncidentController:renderOpenIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@open-incident');
    
    $this->map(['get', 'post'], '/search', 'IncidentController:renderSearchIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@search');
    
    $this->get('/active-incidents', 'IncidentController:renderActiveIncidentAroundPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@activeIncidents');
    
    $this->get('/severity/{id}/{severity}', 'IncidentController:renderSeverityIncidentPage')->setName(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@severity-incident');
});

class IncidentController{
    public function __construct($rdb) {
        $this->rdb = $rdb;
    }
    
    public function renderActiveIncidentPage($request, $response, $args){
        $incidents = IncidentQuery::create()->filterByActive(true)->orderByCreatedAt('desc')->limit(100)->find();
        $filter = new Twig_SimpleFilter("numberOfReporter", function ($incidentId) {
            $incident = IncidentQuery::create()->findPK($incidentId);
            if($incident == null)
                return 0;
            $incidentReporters = IncidentReporterQuery::create()->filterByIncident($incident)->count();
            return $incidentReporters > 0 ? $incidentReporters : 1;
        });
        $twig = $this->rdb->view->getEnvironment();
        $twig->addFilter($filter);
        return $this->rdb->view->render($response, 'Incident/list.html', [
            'title' => 'List incidents',
            'incidents' => $incidents,
            'group'=> 'list-cat-active'
        ]);
    }
    
    public function renderInactiveIncidentPage($request, $response, $args){
        $incidents = IncidentQuery::create()->filterByActive(false)->orderByCreatedAt('desc')->limit(100)->find();
        $filter = new Twig_SimpleFilter("numberOfReporter", function ($incidentId) {
            $incident = IncidentQuery::create()->findPK($incidentId);
            if($incident == null)
                return 0;
            $incidentReporters = IncidentReporterQuery::create()->filterByIncident($incident)->count();
            return $incidentReporters > 0 ? $incidentReporters : 1;
        });
        $twig = $this->rdb->view->getEnvironment();
        $twig->addFilter($filter);
        return $this->rdb->view->render($response, 'Incident/list.html', [
            'title' => 'List incidents',
            'incidents' => $incidents,
            'group'=> 'list-cat-inactive'
        ]);
    }
    
    public function renderAllIncidentPage($request, $response, $args){
        $incidents = IncidentQuery::create()->orderByCreatedAt('desc')->limit(100)->find();
        $filter = new Twig_SimpleFilter("numberOfReporter", function ($incidentId) {
            $incident = IncidentQuery::create()->findPK($incidentId);
            if($incident == null)
                return 0;
            $incidentReporters = IncidentReporterQuery::create()->filterByIncident($incident)->count();
            return $incidentReporters > 0 ? $incidentReporters : 1;
        });
        $twig = $this->rdb->view->getEnvironment();
        $twig->addFilter($filter);
        return $this->rdb->view->render($response, 'Incident/list.html', [
            'title' => 'List incidents',
            'incidents' => $incidents,
            'group'=> 'list-cat'
        ]);
    }
    
    public function renderActiveCatIncidentPage($request, $response, $args){
        $categories = [];
        $incidents = IncidentQuery::create()->filterByActive(true)->orderByCreatedAt('desc')->limit(100)->find();
        foreach($incidents as $incident){
            $cats = IncidentCategoryQuery::create()->filterByIncidentId($incident->getId())->find();
            if($cats->count() == 0){
                if(!$categories['Uncategorized Incidents'])
                    $categories['Uncategorized Incidents']= [];
                $categories['Uncategorized Incidents'][] = $incident;
            }
            foreach($cats as $cat){
                $category = $cat->getCategory(); //CategoryQuery::create()->filterById($cat->getCategoryId());
                if($category->getName() == ""){
                    if(!$categories['Uncategorized Incidents'])
                        $categories['Uncategorized Incidents']= [];
                    $categories['Uncategorized Incidents'][] = $incident;
                }else{
                    if(!$categories[$category->getName()])
                        $categories[$category->getName()] = [];
                    $categories[$category->getName()][] = $incident;
                }
            }
        }
        $filter = new Twig_SimpleFilter("numberOfReporter", function ($incidentId) {
            $incident = IncidentQuery::create()->findPK($incidentId);
            if($incident == null)
                return 0;
            $incidentReporters = IncidentReporterQuery::create()->filterByIncident($incident)->count();
            return $incidentReporters > 0 ? $incidentReporters : 1;
        });
        $twig = $this->rdb->view->getEnvironment();
        $twig->addFilter($filter);
//        Core::varDumpAndDie($categories);
        return $this->rdb->view->render($response, 'Incident/category.html', [
            'title' => 'List incidents',
            'incidents' => $incidents,
            'categories'=> $categories,
            'group'=> 'list-active'
        ]);
    }
    
    public function renderInactiveCatIncidentPage($request, $response, $args){
        $categories = [];
        $incidents = IncidentQuery::create()->filterByActive(false)->orderByCreatedAt('desc')->limit(100)->find();
        foreach($incidents as $incident){
            $cats = IncidentCategoryQuery::create()->filterByIncidentId($incident->getId())->find();
            if($cats->count() == 0){
                if(!$categories['Uncategorized Incidents'])
                    $categories['Uncategorized Incidents']= [];
                $categories['Uncategorized Incidents'][] = $incident;
            }
            foreach($cats as $cat){
                $category = $cat->getCategory(); //CategoryQuery::create()->filterById($cat->getCategoryId());
                if($category->getName() == ""){
                    if(!$categories['Uncategorized Incidents'])
                        $categories['Uncategorized Incidents']= [];
                    $categories['Uncategorized Incidents'][] = $incident;
                }else{
                    if(!$categories[$category->getName()])
                        $categories[$category->getName()] = [];
                    $categories[$category->getName()][] = $incident;
                }
            }
        }
        $filter = new Twig_SimpleFilter("numberOfReporter", function ($incidentId) {
            $incident = IncidentQuery::create()->findPK($incidentId);
            if($incident == null)
                return 0;
            $incidentReporters = IncidentReporterQuery::create()->filterByIncident($incident)->count();
            return $incidentReporters > 0 ? $incidentReporters : 1;
        });
        $twig = $this->rdb->view->getEnvironment();
        $twig->addFilter($filter);
        return $this->rdb->view->render($response, 'Incident/category.html', [
            'title' => 'List incidents',
            'incidents' => $incidents,
            'categories'=> $categories,
            'group'=> 'list-inactive'
        ]);
    }
    
    public function renderAllCatIncidentPage($request, $response, $args){
        $categories = [];
        $incidents = IncidentQuery::create()->orderByCreatedAt('desc')->limit(100)->find();
        foreach($incidents as $incident){
            $cats = IncidentCategoryQuery::create()->filterByIncidentId($incident->getId())->find();
            if($cats->count() == 0){
                if(!$categories['Uncategorized Incidents'])
                    $categories['Uncategorized Incidents']= [];
                $categories['Uncategorized Incidents'][] = $incident;
            }
            foreach($cats as $cat){
                $category = $cat->getCategory(); //CategoryQuery::create()->filterById($cat->getCategoryId());
                if($category->getName() == ""){
                    if(!$categories['Uncategorized Incidents'])
                        $categories['Uncategorized Incidents']= [];
                    $categories['Uncategorized Incidents'][] = $incident;
                }else{
                    if(!$categories[$category->getName()])
                        $categories[$category->getName()] = [];
                    $categories[$category->getName()][] = $incident;
                }
            }
        }
        $filter = new Twig_SimpleFilter("numberOfReporter", function ($incidentId) {
            $incident = IncidentQuery::create()->findPK($incidentId);
            if($incident == null)
                return 0;
            $incidentReporters = IncidentReporterQuery::create()->filterByIncident($incident)->count();
            return $incidentReporters > 0 ? $incidentReporters : 1;
        });
        $twig = $this->rdb->view->getEnvironment();
        $twig->addFilter($filter);
        return $this->rdb->view->render($response, 'Incident/category.html', [
            'title' => 'List incidents',
            'incidents' => $incidents,
            'categories'=> $categories,
            'group'=> 'list'
        ]);
    }
    
    public function renderNewIncidentPage($request, $response, $args){
        return $this->rdb->view->render($response, 'Incident/create.html', [
            'title' => 'New incident',
        ]);
    }
    
    public function renderExistIncidentPage($request, $response, $args){
        $params = $request->getParsedBody();
        if(!Core::checkNullValue($params["id"]))
            Core::apiErrorJson('ID number is required', 1700);
        if(!Core::checkNullValue($params["severity"]))
            Core::apiErrorJson('Severity is required', 1400);

        $newIncident = IncidentQuery::create()->findPK($params["id"]);
//        $newIncident = new Incident();
        $newIncident->setActive(true);
        $newIncident->setSeverity($params["severity"]);
        $newIncident->save();
        
//        $this->notification->newIncidentNotification($newIncident);

        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $pusher->trigger('incidents', 'new-incident', $newIncident->toJson());
        
        Core::successApiJson('New Incident is saved', false, ['id'=> $newIncident->getId()]);
    }
    
    public function renderNewIncidentSubmitPage($request, $response, $args){
        $params = $request->getParsedBody();
        if(!Core::checkNullValue($params["title"]))
            Core::apiErrorJson('Telephone number is required', 1700);
        if(!Core::checkNullValue($params["address"]))
            Core::apiErrorJson('Location is required', 1400);
        if(!Core::checkNullValue($params["lat"]))
            Core::apiErrorJson('System error: Latitude is required', 1500);
        if(!Core::checkNullValue($params["lng"]))
            Core::apiErrorJson('System error: Longitude is required', 1600);
        if(!Core::checkNullValue($params["severity"]))
            Core::apiErrorJson('System error: Severity is required', 1700);

        $newIncident = new Incident();
        $newIncident->setTitle(strtoupper($params["title"]));
        $newIncident->setLocation(strtoupper($params["address"]));
        $newIncident->setLatitude($params["lat"]);
        $newIncident->setLongitude($params["lng"]);
        $newIncident->setActive(true);
        $newIncident->setSeverity($params["severity"]);
        $newIncident->save();
        
//        $this->notification->newIncidentNotification($newIncident);

        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $pusher->trigger('incidents', 'new-incident', $newIncident->toJson());
        
        Core::successApiJson('New Incident is saved', false, ['id'=> $newIncident->getId()]);
    }
    
    public function renderSearchIncidentAroundPage($request, $response, $args){
        $params = $request->getParsedBody();
        if(!Core::checkNullValue($params["lat"]))
            Core::apiErrorJson('Latitude ID is required', 1000);
        if(!Core::checkNullValue($params["lng"]))
            Core::apiErrorJson('Longitude is required', 1100);
        
        $con = \Propel\Runtime\Propel::getReadConnection(\Map\IncidentTableMap::DATABASE_NAME);
        $query = "SELECT *, (6371 * acos ( cos ( radians(".$params['lat'].") ) * cos( radians( incident.latitude ) ) * cos( radians( incident.longitude ) - radians(".$params['lng'].") ) + sin ( radians(".$params['lat'].") ) * sin( radians( incident.latitude ) ) ) ) AS distance FROM `incident` HAVING distance < 2 ORDER BY distance LIMIT 0 , 20;";
        $stmt = $con->prepare($query);
        $res = $stmt->execute();
        $formatter = new ObjectFormatter();
        $formatter->setClass('Incident'); //full qualified class name
        $incidents = $formatter->format($con->getDataFetcher($stmt));
        Core::successApiJson('List of incidents', false, ['incidents'=>$incidents->count() ? $incidents->toJson() : '{}']);
    }
    
    public function renderSearchReporterPage($request, $response, $args){
        $params = $request->getParsedBody();
        if(!Core::checkNullValue($params["tel"]))
            Core::apiErrorJson('Telephone is required', 1200);
        
        $reporters = ReporterQuery::create()->findByTel($params["tel"]);
        
        Core::successApiJson('List of reporters', false, ['reporters'=>$reporters->count() ? $reporters->toJson() : '{}']);
    }
    
    public function renderNewReporterPage($request, $response, $args){
        $params = $request->getParsedBody();
        if(!Core::checkNullValue($params["id"]))
            Core::apiErrorJson('Incident ID is required', 1000);
        if(!Core::checkNullValue($params["reporterId"]))
            Core::apiErrorJson('Reporter ID is required', 1000);
        if($params["reporterId"] === 0){
            if(!Core::checkNullValue($params["name"]))
                Core::apiErrorJson('Name is required', 1100);
            if(!Core::checkNullValue($params["tel"]))
                Core::apiErrorJson('Telephone number is required', 1200);
        }
        if(!Core::checkNullValue($params["description"]))
            Core::apiErrorJson('Description is required', 1300);
        $existingReporter = null;
        if($params["reporterId"] > 0)
            $existingReporter = ReporterQuery::create()->findPK($params["reporterId"]);
        else{
            $existingReporter = new Reporter();
            $existingReporter->setName(strtoupper($params["name"]));
            $existingReporter->setTel($params["tel"]);
            $existingReporter->save();
        }

        $newIncident = IncidentQuery::create()->findPK($params["id"]);
        $newIncident->addReporter($existingReporter);
        $newIncident->save();

        $newIncidentReporter = IncidentReporterQuery::create()->filterByIncident($newIncident)->filterByReporter($existingReporter)->findOne();
        $newIncidentReporter->setDescription($params["description"]);
        $newIncidentReporter->save();

        Core::successApiJson('New Reporter is saved', false, ['id'=> $newIncident->getId(), 'reporterId'=>$existingReporter->getId()]);
    }
    
    public function renderNewDispatchPage($request, $response, $args){
        $params = $request->getParsedBody();
        if(!Core::checkNullValue($params["id"]))
            Core::apiErrorJson('Incident ID is required', 1000);
        
        $newIncident = IncidentQuery::create()->findPK($params["id"]);
        if($newIncident == null)
            Core::apiErrorJson('Invalid incident ID, '.$params["id"], 1000);
        $newIncident->setActive(true);
        $newIncident->save();
        
        $newIncident = IncidentQuery::create()->findPK($params["id"]);
        
        $resources = $params["resources"];
        foreach($resources as $v){
            if($v["selected"]){
                $resource = ResourceQuery::create()->findPK($v["Id"]);
                $newIncident->addResource($resource);
                $newRecord = new IncidentResourceRecord();
                $newRecord->setIncident($newIncident);
                $newRecord->setResource($resource);
                $newRecord->setReporterId(null);
                $newRecord->save();
                if($resource->isSms())
                    SmsService::send($newIncident->toMessage(), $resource->getTel());
                WhatsappService::send($newIncident->toMessage(), $resource->getTel());
            }
        }
        
        $newIncident->save();

        Core::successApiJson('New Category and Resource required is saved', false, ['id'=> $newIncident->getId()]);
    }
    
    public function renderNewDispatchAndCategoryPage($request, $response, $args){
        $params = $request->getParsedBody();
        if(!Core::checkNullValue($params["id"]))
            Core::apiErrorJson('Incident ID is required', 1000);
        if(!Core::checkNullValue($params["reporterid"]))
            Core::apiErrorJson('Reporter ID is required', 1000);
        $categories = explode(',', $params["categories"]);
        if($categories < 1)
            Core::apiErrorJson('At least one category is required', 1000);
        
        $newIncident = IncidentQuery::create()->findPK($params["id"]);
        if($newIncident == null)
            Core::apiErrorJson('Invalid incident ID, '.$params["id"], 1000);
        $newIncident->setActive(true);
        
        $previousCategories = $newIncident->getCategories();
        foreach($previousCategories as $t){
            IncidentCategoryQuery::create()->filterByIncidentId($newIncident->getId())->filterByCategoryId($t->getId())->delete();
        }
        
        $newIncident = IncidentQuery::create()->findPK($params["id"]);
        
        $matchedCategories = [];
        foreach($categories as $v){
            $cat = CategoryQuery::create()->orderById()->findOneByName(ucfirst($v));
            if($cat == null){
                $cat = new Category();
                $cat->setName(ucfirst($v));
                $cat->save();
            }
            $newIncident->addCategory($cat);
        }
        $newIncident->save();
        
        $reporter = ReporterQuery::create()->findPK($params["reporterid"]);
        $resources = $params["resources"];
        foreach($resources as $v){
            if($v["selected"]){
                $resource = ResourceQuery::create()->findPK($v["Id"]);
                $newIncident->addResource($resource);
                $newRecord = new IncidentResourceRecord();
                $newRecord->setIncident($newIncident);
                $newRecord->setResource($resource);
                $newRecord->setReporter($reporter);
                $newRecord->save();
                if($resource->isSms())
                    SmsService::send($newIncident->toMessage(), $resource->getTel());
                WhatsappService::send($newIncident->toMessage(), $resource->getTel());
            }
        }
        
        $newIncident->save();

        Core::successApiJson('New Category and Resource required is saved', false, ['id'=> $newIncident->getId()]);
    }
    
    public function renderCategoryAndResourceRecordPage($request, $response, $args){
        $params = $request->getParsedBody();
        if(!Core::checkNullValue($params["id"]))
            Core::apiErrorJson('Incident ID is required', 1000);
        
        $incident = IncidentQuery::create()->findPK($params["id"]);
        if($incident == null)
            Core::apiErrorJson('Incident ID is invalid', 1000, $this->rdb->router->pathFor(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'#incident@list'));
        
        $categories = $incident->getCategories();
        
        $availableResources = ResourceQuery::create()->find();
        
        $resources = $incident->getResources();
        $records = [];
        $record_s = IncidentResourceRecordQuery::create()->filterByIncident($incident)->orderByCreatedAt('desc')->find();
        foreach($record_s as $v){
            $records[] = [
                'resource_name' => $v->getResource()->getName(),
                'datetime' =>$v->getCreatedAt()
            ];
        }
        
        Core::successApiJson('Categories are fetched', false, [
            'categories'=> $categories->count() ? $categories->toJson() : '{}',
            'resources'=>$availableResources->count() ? $availableResources->toJson() : '{}',
            'records'=>json_encode($records)
        ]);
    }
    
    public function renderIncidentPage($request, $response, $args){
        $incident = IncidentQuery::create()->findPK($args["id"]);
        
//        $incidentReporters = $incident->getReporters();
        
        $resources = IncidentResourceRecordQuery::create()->filterByIncident($incident);
        
        $filter = new Twig_SimpleFilter("categoryJoin", function ($categories) {
            $results = "";
            foreach($categories as $v){
                if($results != "")
                    $results .= ", ";
                $results .= $v->getName();
            }
            return $results;
        });
        $twig = $this->rdb->view->getEnvironment();
        $twig->addFilter($filter);
        
        return $this->rdb->view->render($response, 'Incident/view.html', [
            'title' => 'View incident #'.$args["id"],
            'incident' => $incident,
//            'reporters' => $incidentReporters,
            'resources' => $resources
        ]);
    }
    
    public function renderCloseIncidentPage($request, $response, $args){
        $incident = IncidentQuery::create()->findPK($args["id"]);
        $incident->setActive(false);
        $incident->save();
        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $pusher->trigger('incidents', 'close-incident', $incident->toJson());
//        Core::successApiJson('Incident closed', false, ['id'=> $incident->getId()]);
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@view', ['id'=> $args["id"]]));
        return $response;
    }
    
    public function renderOpenIncidentPage($request, $response, $args){
        $incident = IncidentQuery::create()->findPK($args["id"]);
        $incident->setActive(true);
        $incident->save();
        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $pusher->trigger('incidents', 'new-incident', $incident->toJson());
//        Core::successApiJson('Incident closed', false, ['id'=> $incident->getId()]);
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@view', ['id'=> $args["id"]]));
        return $response;
    }
    
    public function renderSearchIncidentPage($request, $response, $args){
        if($request->isPost()){
            $params = $request->getParsedBody();
            $incident = IncidentQuery::create()->findPK($params["id"]);
            if($incident){
                $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@view', ['id'=> $incident->getId()]));
                return $response;
            }
        }
        return $this->rdb->view->render($response, 'Incident/search.html', [
            'title' => 'Search incidents'
        ]);
    }
    
    public function renderActiveIncidentAroundPage($request, $response, $args){
        $incidents = IncidentQuery::create()->filterByActive(true)->find();
        Core::successApiJson('List of active incidents', false, ['incidents'=>$incidents->count() ? $incidents->toJson() : '{}']);
    }
    
    public function renderSeverityIncidentPage($request, $response, $args){
        $incident = IncidentQuery::create()->findPK($args["id"]);
        if($incident != null){
            $s = ($args["severity"] < 1 || $args["severity"] > 5) ? 1 : $args["severity"];
            $incident->setSeverity($s);
            $incident->save();
        }
        $pusher = new Pusher(
            'e3633179b41c9a1b5cd6',
            '54b73acc62d4c5c8d74f',
            '188783',
            ['cluster' => 'ap1',
            'encrypted' => true]
        );
        $res = $pusher->trigger('incidents', 'severity', $incident->toJson());
        $response = $response->withStatus(302)->withHeader('Location', $this->rdb->router->pathFor(CMS::ROLE_CALL_OPERATOR.'&'.CMS::ROLE_AGENCY.'&'.CMS::ROLE_KEY_DECISION_MAKER.'#incident@view', ['id'=> $args["id"]]));
        return $response;
    }
}