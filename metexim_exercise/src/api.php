<?php
include_once('Config/config.php');

$action = $_GET['action'];

if(!empty($action)){
	$finalArray = array();

	switch($action){

		case 'login':
			$username = $_GET['username'];
			$password = $_GET['password'];

			if(!empty($username) && !empty($password)){
				$finalArray['result'] = 1;
			}
			else{
				$finalArray['result'] = 0;
			}
			break;

		case 'courseList':
			$courses = array();
			$courseObj = new CourseController();
			$courses = $courseObj->getCourses();
			$finalArray['courses'] = $courses;
			break;

		case 'addCourse':
			$courseName = $_GET['courseName'];
			$insertInput['courseName'] = $courseName;
			$courseObj = new CourseController();
			$result = $courseObj->addCourse($insertInput);
			if($result){
				$finalArray['result'] = 1;
			}
			else{
				$finalArray['result'] = 0;
			}

			break;

		case 'deleteCourse':
			$courseId = $_GET['courseId'];
			$courseObj = new CourseController();
			$result = $courseObj->deleteCourse($courseId);
			if($result){
				$finalArray['result'] = 1;
			}
			else{
				$finalArray['result'] = 0;
			}
			break;	
	}

	echo json_encode($finalArray);

}
else{

}
?>