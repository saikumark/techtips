//API URL
var apiUrl = "src/api.php";

//Define Soccer Module
var collegeApp = angular.module('collegeApp', ['ngRoute', 'ngCookies']);

//Route various request to different controller
collegeApp.config(function($routeProvider,$locationProvider){
	$routeProvider
	.when('/', {
		templateUrl: 'pages/main.html',
		controller: 'mainController'
	})

	.when('/deleteCourse/:courseId', {
		templateUrl: 'pages/courses.html',
		controller: 'courseController'
	})

	.when('/courses', {
		templateUrl: 'pages/courses.html',
		controller: 'courseController'
	})
	
	.when('/login', {
		templateUrl: 'pages/login.html',
		controller: 'loginController'
	})

	.when('/logout', {
		templateUrl: 'pages/login.html',
		controller: 'logoutController'
	})

	.when('/editCourse/:courseId', {
		templateUrl: 'pages/addCourse.html',
		controller: 'courseController'
	})


	//$locationProvider.html5Mode(true);
});

collegeApp.service('loginService', function($cookieStore,$http) {
  
  	return {
		getStatus: function() {
			return $cookieStore.get('loggedin');
		},

		login: function (username, password) {

			loginApiUrl = apiUrl + "?action=login&username="+username+"&password="+password;
			var loginResponse = $http.get(loginApiUrl);
	        loginResponse.success(function(data, status, headers, config){
	            //console.log(data);
	            if(data.result!=undefined && data.result == "1"){
	            	$cookieStore.put('loggedin', true);
	            	return true;
	            }
	            else{
	                return false;
	            }
	            
	        });
		}

  	};
});

collegeApp.controller('loginController',function($scope, $cookieStore, $window, $timeout, loginService){

	$scope.loggedIn = false;
	$scope.$parent.loggedIn=false;


	$scope.validateLogin = function() {

		var username = $("#username").val();
		var password = $("#password").val();

		if(username == undefined && password == undefined){
			alert('Username and Password are mandatory fields');
		}
		else{

			loginData = loginService.login(username,password);
			$timeout(updateHeader,100,false);
    		
		}
	}

	updateHeader = function(){
		var loginStatus = loginService.getStatus();
		
		if(loginStatus == true){
			$scope.coursePageTitle = "Manage Courses";
			$scope.loggedIn = true;
			$scope.$parent.loggedIn = true;
		}
		else{
			$scope.coursePageTitle = "View Courses";
			$scope.loggedIn = false;
			$scope.$parent.loggedIn = false;
		}

		$window.location.href = "/#/courses";

	}
});


collegeApp.controller('logoutController',function($scope,$cookieStore,$location){
	$cookieStore.put('loggedin', false);
	$scope.loggedIn= false;
	$scope.$parent.loggedIn=false;
	$location.path("/courses");

});


//Main Controller which loads for default URL
collegeApp.controller('mainController', function($scope,loginService){
    $scope.message1 = 'Tech Stack: AngularJS, PHP, MySQL, CSS';
    $scope.message2 = 'Description: This project is to get list of data from PHP web services through AngularJS';

	var loginStatus = loginService.getStatus();
	
	if(loginStatus ==true){
		$scope.loggedIn = true;
	}
	else{
		$scope.loggedIn = false;
	}

    //alert($scope.loggedIn);

});

//Team controller which helps to load list of team and team players for specific team
collegeApp.controller('courseController', function($scope,$http,$routeParams,$window,loginService){

	var loginStatus = loginService.getStatus();
	
	if(loginStatus == true){
		$scope.coursePageTitle = "Manage Courses";
		$scope.loggedIn = true;
		$scope.$parent.loggedIn = true;
	}
	else{
		$scope.coursePageTitle = "View Courses";
		$scope.loggedIn = false;
		$scope.$parent.loggedIn = false;
	}
	//alert($routeParams);
	$scope.courseId = $routeParams.courseId;
	
	var apiUrl  = 'src/api.php';
	
	var deleteCourse = function(deleteCourseId){

		if(deleteCourseId !=undefined){

			var deleteCourseApiUrl = apiUrl + "?action=deleteCourse&courseId=" + deleteCourseId;
	        var response = $http.get(deleteCourseApiUrl);
	        response.success(function(data, status, headers, config){
	            if(data.result == 1){
	                $window.location.href = "/#/courses";
	            }
	            else{
	                alert("Error when deleting course");
	            }
	        });

		}
		else{
			alert("Invalid input");
		}
	}

	var tmpCourseDetail = $scope.courseId;
	if(tmpCourseDetail!=undefined && !tmpCourseDetail.indexOf("delete")){
		var deleteCourseId = tmpCourseDetail.replace("delete-","");
		deleteCourse(deleteCourseId);
	}
	else{
		if($scope.courseId !=undefined){
            apiUrl = apiUrl + '?course=' + $scope.courseId;
		}

		if($scope.courseId !=undefined){
            var response = $http.get(apiUrl);
            response.success(function(data, status, headers, config){
                console.log(data);
                if(data!=''){
                    $scope.chapters = data;
                }
                else{
                    $scope.error = "No Players available for selected Team";
                }
                
            });		
		}
		else{
			var listApiUrl = apiUrl + "?action=courseList";
	        var response = $http.get(listApiUrl);
	        response.success(function(data, status, headers, config){
	            $scope.courses = data.courses;
	        });	
		}
	}


	var getCourses = function(){
		var listApiUrl = apiUrl + "?action=courseList";
        var response = $http.get(listApiUrl);
        response.success(function(data, status, headers, config){
            $scope.courses = data.courses;
        });	
	}

	$scope.addCourse = function(){
		var courseName = $("#courseName").val();
		if(courseName == undefined){
			alert("Please enter Course Name");
		}
		else{
			var addCourseApiUrl = apiUrl + "?action=addCourse&courseName=" + courseName;
	        var response = $http.get(addCourseApiUrl);
	        response.success(function(data, status, headers, config){
	            if(data.result == 1){
	                getCourses();
	                $scope.showDetails = ! $scope.showDetails;
	            }
	            else{
	                alert("Error when adding course");
	            }
	        });
		}
	}

});