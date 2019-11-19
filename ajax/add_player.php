<?php
require_once '../TeamsConfig.php';
require_once __DBCONFIG_PATH . '/TeamsDb.php';


if (isset($_POST['p_fname'])) {
  $t_id = (int) $_SESSION['t_id'];
  $p_fname = strip_tags(($_POST['p_fname']));
  $p_sname = strip_tags(($_POST['p_sname']));
  $p_number = strip_tags(($_POST['p_number']));

  
  $newPlayerObj = new TeamsDb();
  // Call addTeam method
  $result = $newPlayerObj->addPlayer($p_fname, $p_sname, $p_number, $t_id);

  // Send back the updated teams
  
$playersObj = new TeamsDb();
$players = $playersObj->getAllPlayers();
//var_dump($users);exit();

$playerList = array();

if (!empty($players)) {
  foreach ($players as $player) {
    $p_id = (int) $player['IDpelaaja'];
    $p_fname = $player['etunimi'];
    $p_sname = $player['sukunimi'];
    $p_number = $player['numero'];
    $p_team = $player['joukkue_IDjoukkue'];
    $playerList[] = array (
        'p_id' => $p_id,
        'p_sname' => $p_sname,
        'p_fname' => $p_fname,
        'p_number' => $p_number,
        'p_team' => $p_team
    );
  }
  $response = json_encode($playerList);
} else {
  echo '<span style="margin-left: 15px;">No chat users available!</span>';
}
}
// Toimii testattu:
header('Content-type: application/json');
echo $response;
?>
