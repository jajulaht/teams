<?php
require_once '../TeamsConfig.php';
require_once __DBCONFIG_PATH . '/TeamsDb.php';

$playersObj = new TeamsDb();
$players = $playersObj->getOnePlayer();
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
  $playerList[] = array (
    'p_id' => 0,
    'p_sname' => 'Ei löytynyt pelaajaa',
    'p_fname' => 'jossain on tapahtunut virhe',
    'p_number' => 'anteeksi.',
    'p_team' => 0
  );
  $response = json_encode($playerList);
}

// Toimii testattu:
header('Content-type: application/json');
echo $response;
?>
