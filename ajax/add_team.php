<?php
require_once '../TeamsConfig.php';
require_once __DBCONFIG_PATH . '/TeamsDb.php';


if (isset($_POST['t_name'])) {
  
  $t_name = strip_tags(($_POST['t_name']));
  $t_mngr = strip_tags(($_POST['t_mngr']));
  
  $newTeamObj = new TeamsDb();
  // Call addTeam method
  $result = $newTeamObj->addTeam($t_name, $t_mngr);

  // Send back the updated teams
  $teamsObj = new TeamsDb();
    $teams = $teamsObj->getAllTeams();

    $teamList = array();

    if (!empty($teams)) {
    foreach ($teams as $team) {
        $t_id = (int) $team['IDjoukkue'];
        $t_name = $team['joukkueNimi'];
        $t_mngr = $team['managerNimi'];
        $teamList[] = array (
            't_id' => $t_id,
            't_name' => $t_name,
            't_mngr' => $t_mngr
        );
    }
    $response = json_encode($teamList);
    } else {
    echo '<span style="margin-left: 15px;">No teams available!</span>';
    }

    header('Content-type: application/json');
    echo $response;
    }
?>
