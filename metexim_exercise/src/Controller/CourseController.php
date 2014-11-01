<?php

/**
 * Description of CourseController
 * @desc Controler which receives input from the user and returns the data by using Models
 * @author Saikumar K
 */
class CourseController {
    
    /**
     * 
     */
    public function __construct(){
    }
    
    /**
     * @desc Used to retrieve all teams in the system
     */
    public static function getCourses(){
        
        $courseObj = new CourseModel();
        $courses = $courseObj->getCourses();
        return $courses;
    }

    public static function addCourse($data){
        $courseObj = new CourseModel();
        if(!empty($data['courseName'])){
            $ipArray['fields']  = array('name');
            $ipArray['values']  = array($data['courseName']);
            $result = $courseObj->addCourse($ipArray);
            return $result;
        }
        else{
            return false;
        }
    }

    public static function deleteCourse($id){
        $courseObj = new CourseModel();
        if(!empty($id)){
            $ipArray = array();
            $ipArray['where'] = " WHERE id = ".$id;
            $result = $courseObj->deleteCourse($ipArray);
            return $result;
        }
        else{
            return false;
        }
    }
    
    /**
     * @desc Used to retrieve all players for the given team Id
     * @return Array contains player information
     */
    public static function getPlayers(){

        if(!empty($_GET['team']) && $_GET['team'] > 0){
            $teamId = $_GET['team'];
            
            $ipArray = array();
            $ipArray['where'] = " WHERE teamId=\"$teamId\"";
            
            $playerObj = new PlayerModel();
            $players = $playerObj->getPlayers($ipArray);
            return $players;
        }
    }

}
