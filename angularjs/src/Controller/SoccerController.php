<?php

/**
 * Description of SoccerController
 * @desc Controler which receives input from the user and returns the data by using Models
 * @author Saikumar K
 */
class SoccerController {
    
    /**
     * 
     */
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * @desc Used to retrieve all teams in the system
     */
    public static function getTeams(){
        
        $teamObj = new TeamModel();
        $teams = $teamObj->getTeams();
        return $teams;
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
