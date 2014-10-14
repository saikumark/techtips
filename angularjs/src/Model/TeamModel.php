<?php
/**
 * Description of Team
 * @desc Used to do DB operations with teams table.
 * @author Saikumar K
 */
class TeamModel extends Model{
    
    /**
     * Define table name for this model
     */
    private $dbTable = 'teams';
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * @desc Used to retrieve list of teams 
     * @param type $ipArray 
     */
    public function getTeams($ipArray=array()){
        
        $ipArray['table'] = $this->dbTable;
        $teamsData = $this->dbInstance->getData($ipArray);
        return $teamsData;
    }
}
