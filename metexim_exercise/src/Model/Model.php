<?php
/**
 * Description of Model
 * @desc generic Model class to retrieve DB connections which will be extended by other Models
 * @author abhilaasha
 */
class Model {
    
    public $dbInstance;
    public function __construct(){ 
        $this->dbInstance = DbUtil::getInstance();
    }
}
