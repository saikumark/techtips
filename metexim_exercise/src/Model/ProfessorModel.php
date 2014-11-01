<?php
/**
 * Description of Player
 *
 * @author abhilaasha
 */
class PlayerModel extends Model{
    
    /**
     * Contains DB table which contains player details.
     */
    private $dbTable = 'players';
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * @desc Used to get players for the given team.
     * @param type $ipArray
     */
    public function getPlayers($ipArray=array()){
        
        if(!empty($ipArray['where'])){
            $ipArray['table'] = $this->dbTable;
            $playerData = $this->dbInstance->getData($ipArray);
            return $playerData;
        }
        else{
            return false;
        }
    }
}