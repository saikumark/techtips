<?php
/**
 * 
 *
 * @author Saikumar K
 */
class CourseModel extends Model{
    
    /**
     * Contains DB table which contains course details.
     */
    private $dbTable = 'course';
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * @desc Used to get course for the given team.
     * @param type $ipArray
     */
    public function getCourses($ipArray=array()){
        
        $ipArray['table'] = $this->dbTable;
        $courseData = $this->dbInstance->getData($ipArray);
        return $courseData;
    }

    public function addCourse($ipArray){

        if(!empty($ipArray['id'])){
            //Update
        }
        else{
            $ipArray['table'] = $this->dbTable;
            $result = $this->dbInstance->insertData($ipArray);
            return $result;
        }
    }

    public function deleteCourse($ipArray){
        $ipArray['table'] = $this->dbTable;
        $result = $this->dbInstance->deleteData($ipArray);
        return $result;

    }
}