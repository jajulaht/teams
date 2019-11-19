<?php
require_once '../TeamsConfig.php';
require_once __DBCONFIG_PATH . '/TeamsDb.php';

$playersObj = new TeamsDb();
$players = $playersObj->getAllPlayersG();
//var_dump($users);exit();

$playerList = array();

if (!empty($players)) {
  foreach ($players as $player) {
    $p_id = (int) $player['IDpelaaja'];
    $p_fname = $player['etunimi'];
    $p_sname = $player['sukunimi'];
    $p_number = $player['numero'];
    $p_team = $player['joukkue_IDjoukkue'];
    $p_goals = $player['maalit'];
    $p_tname = $player['joukkueNimi'];
    $playerList[] = array (
        'p_id' => $p_id,
        'p_sname' => $p_sname,
        'p_fname' => $p_fname,
        'p_number' => $p_number,
        'p_team' => $p_team,
        'p_goals' => $p_goals,
        't_name' => $p_tname
    );
  }
  $response = json_encode($playerList);
} else {
  echo '<span style="margin-left: 15px;">No chat users available!</span>';
}

// Toimii testattu:
header('Content-type: application/json');
echo $response;
?>
