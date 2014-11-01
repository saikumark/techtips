<?php
/**
 * Description of DbUtil
 * @desc DB wrapper to interact with MySQL database and do CRUD operations 
 *
 * @author Saikumar K
 */
class DbUtil {

    private static $dbInstance;
    /**
     * 
     */
    public function __construct(){
        self::connectDb();
    }
    
    /**
     * @desc In order to keep single instance of DB, we will not allow clone DB object
     * @throws Exception
     */
    public function __clone() {
       throw new Exception("Can't clone a singleton");
    }
    
    /**
     * @desc Single Design patter to keep single instance of DB at any time
     * @return type
     */
    public static function getInstance(){
        if(self::$dbInstance == null){
            new DbUtil();
        }
        return new DbUtil;
    }
    
    /**
     * @desc Used to connect database through PHP mysql_connect method
     */
    private static function connectDb(){
    	self::$dbInstance = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME,DB_PASSWORD);
    	if(!self::$dbInstance){
    		die('Could not connect: '.mysql_error());
    	}
    }

    /**
     * 
     * @desc Used to retrieve data from DB using various given details.
     * @param type $inputArray receives various details to construct query
     * @return type
     */
    public function getData($inputArray){

        $finalArray = array();
    	if(!empty($inputArray['table'])){
    	
                if(!empty($inputArray['fields'])){
                    $fieldsStr = implode(",",$inputArray['fields']);
                }
                else{
                    $fieldStr = " * ";
                }

                $query = "SELECT ".$fieldStr." FROM ".$inputArray['table'];

                if(!empty($inputArray['where'])){
                    $query.= " ".$inputArray['where'];
                }

                if(!empty($inputArray['group'])){
                    $query.=" ".$inputArray['group'];
                }   

                if(!empty($inputArray['order'])){
                    $query.=" ".$inputArray['order'];
                }    
                
                $sth = self::$dbInstance->prepare($query);
                $sth->execute();
                $finalArray = $sth->fetchAll();

                return $finalArray;	
    	}
    }

    public function insertData($inputArray){

        if(!empty($inputArray['table']) && !empty($inputArray['fields']) && !empty($inputArray['values'])){

            if(count($inputArray['fields']) == count($inputArray['values'])){
                $fieldStr = implode(',',$inputArray['fields']);
                $valueStr = '"'.implode('","',$inputArray['values']).'"';

                $query = 'INSERT INTO '.$inputArray['table'].' ( '. $fieldStr. ' ) VALUES ( '. $valueStr. ' ) ';
                //echo $query;
                $sth = self::$dbInstance->prepare($query);
                $result = $sth->execute();

                if($result){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }

    public function deleteData($inputArray){

        if(!empty($inputArray['table']) && !empty($inputArray['where'])){

            $query = "DELETE FROM ". $inputArray['table']. " ".$inputArray['where'];
            //echo $query;

            $sth = self::$dbInstance->prepare($query);
            $result = $sth->execute();

            if($result){
                return true;
            }
            else{
                return false;
            }

        }
        else{
            return false;
        }

    }
}