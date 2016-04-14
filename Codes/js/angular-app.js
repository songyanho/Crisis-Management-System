var app = angular.module('cms', ['ngFlash', 'angularMoment', 'pusher-angular']).constant('angularMomentConfig', {
    timezone: 'Asia/Singapore' // e.g. 'Europe/London'
})
.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });
 
                event.preventDefault();
            }
        });
    };
})
//.directive('capitalize', function() {
//   return {
//     require: 'ngModel',
//     link: function(scope, element, attrs, modelCtrl) {
//        var capitalize = function(inputValue) {
//           if(inputValue == undefined) inputValue = '';
//           var capitalized = inputValue.toUpperCase();
//           if(capitalized !== inputValue) {
//              modelCtrl.$setViewValue(capitalized);
//              modelCtrl.$render();
//            }         
//            return capitalized;
//         }
//         modelCtrl.$parsers.push(capitalize);
//         capitalize(scope[attrs.ngModel]);  // capitalize initial value
//     }
//   };
//})
.directive('bootstrapSwitch', [
        function() {
            return {
                restrict: 'A',
//                scope: { callbackFn: '&' },
                require: '?ngModel',
                link: function(scope, element, attrs, ngModel) {
                    element.bootstrapSwitch();

                    element.on('switchChange.bootstrapSwitch', function(event, state) {
                        if (ngModel) {
                            scope.$apply(function() {
                                ngModel.$setViewValue(state);
                            });
                        }
                    });

                    scope.$watch(attrs.ngModel, function(newValue, oldValue) {
//                        scope.callbackFn({arg1: attrs.ngModel, arg2: newValue});
//                        MapViewController.updateCategoryCrisis(attr.ngModel, newValue);
                        if (newValue) {
                            element.bootstrapSwitch('state', true, true);
//                            console.log("on"); 
                        } else {
                            element.bootstrapSwitch('state', false, true);
//                            console.log("off");
                        }
                    });
                }
            };
        }
    ])
.filter('reverse', function () {
    return function (items) {
        return items.slice().reverse();
    };
})
.controller('NewIncidentController', ['$scope', '$http', '$window', 'Flash', '$timeout', function($scope, $http, $window, Flash, $timeout){
    var $this = this;
    this.id = 0;
    this.title = '';
    this.name = '';
    this.tel = '';
    this.description = '';
    this.categories = "";
    this.address = '';
    this.hasAddress = false;
    this.step = 0;
    this.selectedAddressIndex = 0;
    this.addressResults = [];
    this.incidents = []
    this.reporters = [];
    this.reporterId = 0;
    this.hasTel = false;
    this.geocodingLoading = false;
    this.telLoading = false;
    this.severity = 1;
    this.resources = [];
    this.records = [];
    
    this.getLatLong = function(){
        var geocoder = $window.geocoder;
        this.geocodingLoading = true;
        geocoder.geocode({
            address: this.address,
            componentRestrictions: {
                country: 'SG'
            }
        }, function(results, status) {
            $this.geocodingLoading = false;
            if(status !== google.maps.GeocoderStatus.OK)
                return;
            $this.selectedAddressIndex = 0;
            $this.addressResults = [];
            if(results.length >= 1){
                $scope.$apply( function(){
                    $this.addressResults = $this.convertResults(results);
                    $this.addMarkers();
                    $this.showOnMap(0);
                    $this.hasAddress = true;
                });
            }
        });
    };
    
    this.setSeverity = function(severity){
        this.severity = severity;
    };
    
    this.fetchCasesNearMe = function(){
        $http({
            url: '/incident/find-incidents',
            method: 'POST',
            data: {
                lat: this.addressResults[this.selectedAddressIndex].lat,
                lng: this.addressResults[this.selectedAddressIndex].lng,
            },
        }).then(function successCallback(response) {
//            console.log(response.data);
            var obj = response.data;
            if (obj.success == 'success') {
                $this.incidents = JSON.parse(obj.data.incidents);
                if($this.incidents.Incidents){
                    $this.incidents = $this.incidents.Incidents;
                    for(var i=0; i<$this.incidents.length; i++){
                        $this.incidents[i].dateTime = new Date($this.incidents[i].CreatedAt);
//                        console.log($this.incidents[i]);
                    }
                }else
                    $this.incidents = 1;
                if (obj.message != 'success') {
                    Flash.create('success', obj.message, 0, {class: 'customAlert'});
                }
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
//                console.log(response.data);
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 'customAlert');
            }
        }, function errorCallback(response) {
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
//            console.log(response.data);
            Flash.create('danger', message, 'customAlert');
        });
    };
    
    this.selectIncident = function(selectedId, index){
        this.id = selectedId;
        if(selectedId = 0)
            this.severity = 1;
        else
            this.severity = this.incidents[index]['Severity'];
    };
    
    this.selectReporter = function(selectedId){
        this.reporterId = selectedId;
    };
    
    this.selectResource = function(resource){
        resource.selected = !resource.selected;
    };
    
    this.convertResults = function(results){
        var t = [];
        for(i=0; i<results.length; i++){
            t.push({'formatted_address': results[i].formatted_address,
                    'lat': results[i].geometry.location.lat(),
                    'lng': results[i].geometry.location.lng(),
                    'selected': false
                   });
        }
        return t;
    };
    
    this.addMarkers = function(){
        var i;
        for(i=0; i<$window.markers.length; i++){
            $window.markers[i].setMap(null);
        }
        $window.markers = [];
        for(i=0; i<this.addressResults.length; i++){
            var a = this.addressResults[i];
            var position = {lat: a.lat, lng: a.lng};
            var marker = new google.maps.Marker({
                position: position,
                map: $window.map,
                title: a.formatted_address,
                draggable: true,
            });
            marker.addListener('dragend',function(event) {
                $this.updateLatLng(event.latLng.lat(), event.latLng.lng())
            });
            $window.markers.push(marker);
        }
    };
    
    this.updateLatLng = function(lat, lng){
        this.addressResults[this.selectedAddressIndex].lat = lat;
        this.addressResults[this.selectedAddressIndex].lng = lng;
        
        this.fetchCasesNearMe();
    };
    
    this.showOnMap = function(index){
        this.selectedAddressIndex = index;
        var selectedAddress = this.addressResults[index];
//        console.log(selectedAddress);
        for(var i=0; i<this.addressResults.length; i++){
            this.addressResults[i].selected = false;
        }
        selectedAddress.selected = true;
        var position = {lat: selectedAddress.lat, lng: selectedAddress.lng};
        $window.map.setCenter(position);
        $window.map.setZoom(15);
        
        this.fetchCasesNearMe();
    };
    
    this.createNewIncident = function(){
        if(this.id != 0){
            this.step = 1;
            $http({
                url: './incident/exist-incident',
                method: 'POST',
    //            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
                data: {
                    id: this.id,
                    severity: this.severity,
                },
            }).then(function successCallback(response) {
                console.log(response.data);
                var obj = response.data;
                if (obj.success == 'success') {
                    $this.step = 1;
                    $this.id = obj.data.id;
                    if (obj.message != 'success') {
                        Flash.create('success', obj.message, 3000, {class: 'customAlert'});
                    }
                    if (obj.redirect != false) {
                        if (obj.message != 'success') {
                            $timeout(function () {
                                $window.location.href = obj.redirect;
                            }, 3000);
                        } else {
                            $window.location.href = obj.redirect;
                        }
                    }
                } else {
    //                console.log(response.data);
                    var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                    Flash.create('danger', message, 3000, {class: 'customAlert'});
                }
            }, function errorCallback(response) {
                var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
    //            console.log(response.data);
                Flash.create('danger', message, 3000, {class: 'customAlert'});
            });
            return;
        }
        $http({
            url: './incident/new-incident',
            method: 'POST',
//            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
            data: {
                title: this.title,
                address: this.address,
                lat: this.addressResults[this.selectedAddressIndex].lat,
                lng: this.addressResults[this.selectedAddressIndex].lng,
                severity: this.severity,
            },
        }).then(function successCallback(response) {
//            console.log(response.data);
            var obj = response.data;
            if (obj.success == 'success') {
                $this.step = 1;
                $this.id = obj.data.id;
                if (obj.message != 'success') {
                    Flash.create('success', obj.message, 3000, {class: 'customAlert'});
                }
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
//                console.log(response.data);
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 3000, {class: 'customAlert'});
            }
        }, function errorCallback(response) {
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
//            console.log(response.data);
            Flash.create('danger', message, 3000, {class: 'customAlert'});
        });
    };
    
    this.createNewReporter = function(){
        $http({
            url: './incident/new-reporter',
            method: 'POST',
            data: {
                id: this.id,
                reporterId: this.reporterId,
                name: this.name,
                tel: this.tel,
                description: this.description
            },
        }).then(function successCallback(response) {
//            console.log(response.data);
            var obj = response.data;
            if (obj.success == 'success') {
                $this.step = 2;
                $this.reporterId = obj.data.reporterId;
                $this.getCategoriesAndResource();
                if (obj.message != 'success') {
                    Flash.create('success', obj.message, 3000, {class: 'customAlert'});
                }
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
//                console.log(response.data);
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 3000, {class: 'customAlert'});
            }
        }, function errorCallback(response) {
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
//            console.log(response.data);
            Flash.create('danger', message, 3000, {class: 'customAlert'});
        });
    };
    
    this.findReporterByTel = function(){
        this.hasTel = false;
        this.telLoading = true;
        $http({
            url: './incident/find-reporters',
            method: 'POST',
            data: {
                tel: this.tel
            },
        }).then(function successCallback(response) {
            $this.telLoading = false;
            var obj = response.data;
            if (obj.success == 'success') {
                $this.hasTel = true;
                $this.reporters = JSON.parse(obj.data.reporters);
                if($this.reporters.Reporters)
                    $this.reporters = $this.reporters.Reporters;
                else
                    $this.reporters = 1;
                if (obj.message != 'success') {
                    Flash.create('success', obj.message, 3000, {class: 'customAlert'});
                }
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
                console.log(response.data);
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 3000, {class: 'customAlert'});
            }
        }, function errorCallback(response) {
            $this.telLoading = true;
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
            console.log(response.data);
            Flash.create('danger', message, 3000, {class: 'customAlert'});
        });
    };
    
    this.getCategoriesAndResource = function(){
        $http({
            url: './incident/get-categories-and-resources',
            method: 'POST',
            data: {
                id: this.id
            },
        }).then(function successCallback(response) {
            var obj = response.data;
            if (obj.success == 'success') {
                if (obj.message != 'success') {
                    Flash.create('success', obj.message, 3000, {class: 'customAlert'});
                }
                
                $('input#categoryInput').tagsinput(window.inputoption);
                
                var t = JSON.parse(obj.data.categories);
                if(t.Categories){
                    t = t.Categories;
                    $this.categories = "";
                    for(var i=0; i<t.length; i++){
                        $('input#categoryInput').tagsinput('add', t[i].Name);
//                        $this.categories += ($this.categories == "") ? t[i].Name : ", "+t[i].Name;
                    }
                }else
                    $this.categories = "";
                
                $this.resources = JSON.parse(obj.data.resources);
                if($this.resources.Resources)
                    $this.resources = $this.resources.Resources;
                else
                    $this.resources = [];
                for(var i=0; i<$this.resources.length; i++){
                    $this.resources[i].selected = false;
                }
                
                $this.records = JSON.parse(obj.data.records);
                
                
                console.log($('input#categoryInput'));
                
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
                console.log(response.data);
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 3000, {class: 'customAlert'});
            }
        }, function errorCallback(response) {
            $this.telLoading = true;
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
            console.log(response.data);
            Flash.create('danger', message, 3000, {class: 'customAlert'});
        });
    };
    
    this.createNewCategoriesAndResource = function(){
        $http({
            url: './incident/new-categories-and-resource',
            method: 'POST',
            data: {
                id: this.id,
                reporterid: this.reporterId,
                categories: this.categories,
                resources: this.resources
            },
        }).then(function successCallback(response) {
            console.log(response.data);
            var obj = response.data;
            if (obj.success == 'success') {
                $this.step = 3;
                if (obj.message != 'success') {
                    Flash.create('success', obj.message, 3000, {class: 'customAlert'});
                }
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 3000, {class: 'customAlert'});
            }
        }, function errorCallback(response) {
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
            console.log(response.data);
            Flash.create('danger', message, 3000, {class: 'customAlert'});
        });
    };
}])
.controller('MapViewController', ['$scope','$http', '$pusher', '$window', 'Flash', function($scope, $http, $pusher, $window, Flash){
    var $this = this;
    this.dengue = [];
    this.denguevalue = 0;
    this.incidents = {};
    this.weather = [];
    this.weatherDate = new Date();
    this.haze = [];
    this.activeCatagories = [];
//    this.crisis = false;
    this.infowindow = null;
    
    var client = new Pusher('e3633179b41c9a1b5cd6', {
        cluster: 'ap1',
        encrypted: true
    });
    
    this.severities = ['Z','E','D','C','B','A'];
    
    this.pusher = $pusher(client);
    this.channel = this.pusher.subscribe('incidents');
    this.pusher.bind('new-incident', function(data) {
        var json = JSON.parse(data);
        json['marker'] = new google.maps.Marker({
            position: {lat: json['Latitude'], lng: json['Longitude']},
            map: $window.map,
            title: '<h4>'+json.Title+'<h4>'+
            '<p>Location: '+json.Location+' ('+json.Latitude+', '+json.Longitude+')<br />'+
            '<a href="./incident/view/'+json.Id+'">View details</a><br /><a href="./crisis/activate/incident/'+json.Id+'" target="_blank"><strong>Declare Crisis</strong></a>',
            label: {text: $this.severities[json.Severity]},
            icon: $window.pinImage[parseInt(json.Severity)-1],
            shadow: $window.pinShadow
        });
        
        json['marker'].addListener('click', function() {
            infowindow.setContent(this.getTitle());
            infowindow.open($window.map, this);
        });
        $this.incidents[json.Id] = json;
        $this.fetchActiveCatagories();
    });
    this.pusher.bind('severity', function(data) {
        var json = JSON.parse(data);
        if($this.incidents[json.Id]){
            var marker = $this.incidents[json.Id]['marker'];
            marker.setMap(null);
            marker = null;
            $this.incidents[json.Id] = null;
        }
        json['marker'] = new google.maps.Marker({
            position: {lat: json['Latitude'], lng: json['Longitude']},
            map: $window.map,
            title: '<h4>'+json.Title+'<h4>'+
            '<p>Location: '+json.Location+' ('+json.Latitude+', '+json.Longitude+')<br />'+
            '<a href="./incident/view/'+json.Id+'">View details</a><br /><a href="./crisis/activate/incident/'+json.Id+'" target="_blank"><strong>Declare Crisis</strong></a>',
            label: {text: $this.severities[json.Severity]},
            icon: $window.pinImage[parseInt(json.Severity)-1],
            shadow: $window.pinShadow
        });
        
        json['marker'].addListener('click', function() {
            infowindow.setContent(this.getTitle());
            infowindow.open($window.map, this);
        });
        $this.incidents[json.Id] = json;
        $this.fetchActiveCatagories();
    });
    this.pusher.bind('close-incident', function(data){
        var json = JSON.parse(data);
        if($this.incidents[json.Id]){
            var marker = $this.incidents[json.Id]['marker'];
            marker.setMap(null);
            marker = null;
            $this.incidents[json.Id] = null;
        }
        $this.fetchActiveCatagories();
    });
    
    this.fetchActiveCatagories = function () {
        $http.get('/map/category-statistics').then(function successCallback(response) {
            var temp = [];
            temp = response.data.data.statistics;
            $this.activeCatagories = [];
            for (var i in temp) {
                if (!(temp).hasOwnProperty(i)) {
                    continue;
                }
                if ((temp)[i] != 0) {
                    $this.activeCatagories.push({
                        'name': temp[i].name,
                        'value': temp[i].number,
                        'crisis': temp[i].crisis
                    });
                }
            }
        }, function errorCallback(response) {
            console.log(response);
        });
    };
    
    this.declareCatagoryCrisis = function(categoryName, crisis){
//        console.log(categoryName+' > '+crisis);
//        console.log("crisis/activate-category/"+categoryName);
        if(crisis)
            $http.get("./crisis/activate-category/"+categoryName);
        else
            $http.get("./crisis/deactivate-category/"+categoryName);
    }
    
    this.fetchWeatherApi = function(){
        $http.get('http://www.nea.gov.sg/api/WebAPI/?dataset=12hrs_forecast&keyref=781CF461BB6606ADE5BD65643F1781748ED3F12640A8E5DC',{
            transformResponse: function (cnv) {
                var x2js = new X2JS();
                var aftCnv = x2js.xml_str2json(cnv);
                return aftCnv;
            }
        }).then(function successCallback(response){
            $this.weather = response.data.channel.item;
//            console.log($this.weather);
        }, function errorCallback(response){
            console.log(response);
        });
    };
    
    this.fetchHazeApi = function(){
        $http.get('http://www.nea.gov.sg/api/WebAPI/?dataset=pm2.5_update&keyref=781CF461BB6606AD62B1E1CAA87ECA61A3831F6F41D88ECD',{
            transformResponse: function(cnv) {
                var x2js = new X2JS();
                var aftCnv = x2js.xml_str2json(cnv);
                return aftCnv;
            }
        }).then(function successCallback(response){
            $this.haze = response.data.channel;
//            console.log($this.haze);
        }, function errorCallback(response){
           console.log(response); 
        });
    };
    
    this.fetchActiveIncidents = function(){
        $http.get('incident/active-incidents').then(function successCallback(response){
//            console.log(response);
//            console.log(response.data.data);
            var is = JSON.parse(response.data.data.incidents);
            is = is.Incidents;
            $this.incidents = {};
            this.infowindow = new google.maps.InfoWindow({
                content: "Empty"
            });
            for(var i=0; i< is.length; i++){
                is[i]['marker'] = new google.maps.Marker({
                    position: {lat: is[i]['Latitude'], lng: is[i]['Longitude']},
                    label: {text: $this.severities[is[i]['Severity']]},
                    map: $window.map,
                    title: '<h4>'+is[i].Title+'<h4>'+
                            '<p>Location: '+is[i].Location+' ('+is[i].Latitude+', '+is[i].Longitude+')<br />'+
                            '<a href="./incident/view/'+is[i].Id+'">View details</a><br /><a href="./crisis/activate/incident/'+is[i].Id+'" target="_blank"><strong>Declare Crisis</strong></a>',
                    icon: $window.pinImage[parseInt(is[i]['Severity'])-1],
                    shadow: $window.pinShadow
                });
                is[i]['marker'].addListener('click', function() {
                    infowindow.setContent(this.getTitle());
                    infowindow.open($window.map, this);
                });
                $this.incidents[is[i]['Id']] = is[i];
            }
        }, function errorCallback(response){
            console.log(response);
        });
    };
    
    this.CSVToArray = function(strData){
        strDelimiter = ",";
        var objPattern = new RegExp((
        "(\\" + strDelimiter + "|\\r?\\n|\\r|^)" +
        "(?:\"([^\"]*(?:\"\"[^\"]*)*)\"|" +
        "([^\"\\" + strDelimiter + "\\r\\n]*))"), "gi");
        var arrData = [[]];
        var arrMatches = null;
        while (arrMatches = objPattern.exec(strData)) {
        var strMatchedDelimiter = arrMatches[1];
        if (strMatchedDelimiter.length && (strMatchedDelimiter != strDelimiter)) {
            arrData.push([]);
        }
        if (arrMatches[2]) {
            var strMatchedValue = arrMatches[2].replace(
            new RegExp("\"\"", "g"), "\"");
        } else {
            var strMatchedValue = arrMatches[3];
        }
        arrData[arrData.length - 1].push(strMatchedValue);
    }
    return (arrData);
    }
    
    this.CSV2JSON = function(csv) {
        var array = $this.CSVToArray(csv);
        var objArray = [];
        for (var i = 1; i < array.length; i++) {
            objArray[i - 1] = {};
            for (var k = 0; k < array[0].length && k < array[i].length; k++) {
                var key = array[0][k];
                objArray[i - 1][key] = array[i][k]
            }
        }

        var json = JSON.stringify(objArray);
        var str = json.replace(/},/g, "},\r\n");

        return str;
    }
    
    this.fetchDengueIncidents = function(){
        $http.get('https://data.gov.sg/dataset/e51da589-b2d7-486b-adfc-4505d47e1206/resource/ef7e44f1-9b14-4680-a60a-37d2c9dda390/download/weekly-infectious-bulletin-cases.csv',{
            transformResponse: function(cnv){
                var data = $this.CSV2JSON(cnv);
                return data;
            }
        }).then(function successCallback(response){
            $this.dengue = JSON.parse(response.data);
            for(var i = $this.dengue.length-1; i>= 0; i--){
                if("Dengue Fever" == $this.dengue[i].disease){
                    $this.denguevalue = $this.dengue[i].number_of_cases;
                    break;
                }
            }
        }, function errorCallback(response){
            console.log(response);
        });
    };
    
    this.fetchDengueIncidents();
    this.fetchActiveIncidents();
    this.fetchHazeApi();
    this.fetchWeatherApi();
    this.fetchActiveCatagories();
}])
.controller('ViewIncidentController', ['$http', 'Flash', '$window', function ($http, Flash, $window){
    var $this = this;
    this.id = $window.incidentId;
    this.resources = [];
    this.records = [];
    
    this.getCategoriesAndResource = function(){
        $http({
            url: './incident/get-categories-and-resources',
            method: 'POST',
            data: {
                id: this.id
            },
        }).then(function successCallback(response) {
            var obj = response.data;
            if (obj.success == 'success') {
                if (obj.message != 'success') {
                    Flash.create('success', obj.message, 3000, {class: 'customAlert'});
                }
                
                $this.resources = JSON.parse(obj.data.resources);
                if($this.resources.Resources)
                    $this.resources = $this.resources.Resources;
                else
                    $this.resources = [];
                for(var i=0; i<$this.resources.length; i++){
                    $this.resources[i].selected = false;
                }
                
                $this.records = JSON.parse(obj.data.records);
                
                console.log(obj.data);
                
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
                console.log(response.data);
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 3000, {class: 'customAlert'});
            }
        }, function errorCallback(response) {
            $this.telLoading = true;
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
            console.log(response.data);
            Flash.create('danger', message, 3000, {class: 'customAlert'});
        });
    };
    this.getCategoriesAndResource();
    
    this.createNewCategoriesAndResource = function(){
        $http({
            url: './incident/new-resource',
            method: 'POST',
            data: {
                id: this.id,
                resources: this.resources
            },
        }).then(function successCallback(response) {
            console.log(response.data);
            var obj = response.data;
            if (obj.success == 'success') {
                $window.location.reload()
                if (obj.message != 'success') {
                    Flash.create('success', obj.message, 3000, {class: 'customAlert'});
                }
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 3000, {class: 'customAlert'});
            }
        }, function errorCallback(response) {
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
            console.log(response.data);
            Flash.create('danger', message, 3000, {class: 'customAlert'});
        });
    };
    
    this.selectResource = function(resource){
        resource.selected = !resource.selected;
    };
}])
.controller('HeaderController', ['$http', '$pusher', '$window', 'Flash', function($http, $pusher, $window, Flash){ 
    var $this = this;
    this.crisis = false;
    this.wholecrisis = false;
    
    var client = new Pusher('e3633179b41c9a1b5cd6', {
        cluster: 'ap1',
        encrypted: true
    });
    this.pusher = $pusher(client);
    this.channel = this.pusher.subscribe('crisis');
    this.pusher.bind('crisis', function(data){
        $this.checkCrisis();
    });
    this.pusher.bind('nocrisis', function(data){
        $this.checkCrisis();
    });
    
    this.updateMap = function(){
        if(!$window.map)
            return;
        if(this.crisis){
            $window.map.setOptions({'styles': $window.style_dark});
        }else{
            $window.map.setOptions({'styles': $window.style_light});
        }
    };
    
    this.checkCrisis = function(){
        $http({
            url: '/crisis/status',
            method: 'GET',
        }).then(function successCallback(response) {
            
//            console.log(response.data);
            var obj = response.data;
            if (obj.success == 'success') {
                $this.crisis = obj.data.crisis;
                $this.updateMap();
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
//                console.log(response.data);
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 'customAlert');
            }
        }, function errorCallback(response) {
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
//            console.log(response.data);
            Flash.create('danger', message, 'customAlert');
        });
        $http({
            url: '/crisis/status/whole',
            method: 'GET',
        }).then(function successCallback(response) {
//            console.log(response.data);
            var obj = response.data;
            if (obj.success == 'success') {
                $this.wholecrisis = obj.data.crisis;
                if (obj.redirect != false) {
                    if (obj.message != 'success') {
                        $timeout(function () {
                            $window.location.href = obj.redirect;
                        }, 3000);
                    } else {
                        $window.location.href = obj.redirect;
                    }
                }
            } else {
//                console.log(response.data);
                var message = 'We encountered an error in handling your submission. (Error: ' + obj.code + ':' + obj.message + ')';
                Flash.create('danger', message, 'customAlert');
            }
        }, function errorCallback(response) {
            var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
//            console.log(response.data);
            Flash.create('danger', message, 'customAlert');
        });
    };
    this.checkCrisis();
    
    this.stateCrisis = function(){
        if($this.wholecrisis){
            $http({
                url: '/crisis/deactivate/whole',
                method: 'GET',
            }).then(function successCallback(response) {
                $this.checkCrisis();
            }, function errorCallback(response) {
                var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
    //            console.log(response.data);
                Flash.create('danger', message, 'customAlert');
            });
        }else{
            $http({
                url: '/crisis/activate/whole',
                method: 'GET',
            }).then(function successCallback(response) {
                $this.checkCrisis();
            }, function errorCallback(response) {
                var message = 'We encountered an error in handling your submission. (Error: Please check your internet connectivity)';
    //            console.log(response.data);
                Flash.create('danger', message, 'customAlert');
            });
        }
    }
}])