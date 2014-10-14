//Define Soccer Module
var soccerApp = angular.module('soccerApp', ['ngRoute']);

//Route various request to different controller
soccerApp.config(function($routeProvider,$locationProvider){
	$routeProvider
	.when('/', {
		templateUrl: 'pages/main.html',
		controller: 'mainController'
	})

	.when('/teams/:teamId', {
		templateUrl: 'pages/players.html',
		controller: 'teamController'
	})
    
	.when('/teams', {
		templateUrl: 'pages/teams.html',
		controller: 'teamController'
	});
	
	//$locationProvider.html5Mode(true);
});

//Main Controller which loads for default URL
soccerApp.controller('mainController', function($scope){
    $scope.message1 = 'Tech Stack: AngularJS, PHP, MySQL, CSS';
    $scope.message2 = 'Description: This project is to get list of data from PHP web services through AngularJS';
});

//Team controller which helps to load list of team and team players for specific team
soccerApp.controller('teamController', function($scope,$http,$routeParams){

	$scope.teamId = $routeParams.teamId;
	
	var apiUrl  = 'src/api.php';
	if($scope.teamId !=undefined){
            apiUrl = apiUrl + '?team=' + $scope.teamId;
	}
	
	if($scope.teamId !=undefined){
            var response = $http.get(apiUrl);
            response.success(function(data, status, headers, config){
                console.log(data);
                if(data!=''){
                    $scope.players = data;
                    console.log('i am here');
                }
                else{
                    $scope.error = "No Players available for selected Team";
                    console.log('i am here too');
                }
                
            });		
	}
	else{
            var response = $http.get(apiUrl);
            response.success(function(data, status, headers, config){
                $scope.teams = data;
            });	
	}
});