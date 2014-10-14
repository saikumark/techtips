<?php
include_once('Config/config.php');

//Authenciate API Request.
AuthController::authenticate();

//If authenticatoin success, then get required data
if(!empty($_GET['team'])){
	$teamId = $_GET['team'];
        $players = SoccerController::getPlayers();
}
else{
    $teams = SoccerController::getTeams();
}

if(!empty($teamId)){
	echo json_encode($players);
}
else{
	echo json_encode($teams);
}
?>