<?php
require_once '../TeamsConfig.php';
require_once __DBCONFIG_PATH . '/TeamsDb.php';

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
    $teamList[] = array (
      't_id' => 0,
      't_name' => 'Ei vielä joukkueita, mutta voit lisätä niitä.' ,
      't_mngr' => 'Kiitos.'
  );
  $response = json_encode($teamList);
}

// Toimii testattu:
header('Content-type: application/json');
echo $response;
?>
