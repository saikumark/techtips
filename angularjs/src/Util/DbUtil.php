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
            self::$dbInstance = new DbUtil();
        }
        return self::$dbInstance;
    }
    
    /**
     * @desc Used to connect database through PHP mysql_connect method
     */
    private static function connectDb(){
	self::$dbInstance=mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
	if(!self::$dbInstance){
		die('Could not connect: '.mysql_error());
	}
	mysql_select_db(DB_NAME,self::$dbInstance);
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
               //echo $query;
            $return = mysql_query($query);

            while($row=mysql_fetch_assoc($return))	{
                    $finalArray[] = $row;
            }

            return $finalArray;	
	}
    }

}