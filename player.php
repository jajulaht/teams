<?php
require_once 'TeamsConfig.php';
$_SESSION['p_id'] = isset($_GET['p_id']) ? (int) $_GET['p_id'] : 0;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Pelipörssi</title>
    <script src="https://kit.fontawesome.com/bcbf987373.js"></script>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,600,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link href="style/styles.css" rel="stylesheet" type="text/css" />

  </head>
  <body>
<div id="mastercontainer">
<h1><a href="index.php"><i class="fas fa-running"></i>Pelipörssi</a></h1>

<?php
    require_once __DBCONFIG_PATH . '/TeamsDb.php';
    $playersObj = new TeamsDb();
    // $allTeams = $teams->getAllTeams();
    $player = $playersObj->getOnePlayer();

    echo "<h2>Pelaajan tiedot</h2>";


// $response = json_encode($player);
// print_r($response);



    /* <Select User Role Navigation, vähän köpösti toteutettu> **
      echo "<p id='navbar'>";
      echo "Select your role: ";
      foreach($users as $user) {
        $bgcolor = "transparent";
        if ($_SESSION['user_id'] == $user['id']) $bgcolor = "#ffc";
        echo "<a href='react-chat-index.php?user_id={$user['id']}'><span style='background-color: $bgcolor'>{$user['username']}</span></a>" . "\n";
      } 
      echo "</p>";
    * </Select User Role Navigation, vähän köpösti toteutettu> **/ 


    ?>
    <div id="container"></div>

      <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
      <script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
      <script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
      <script src="https://unpkg.com/babel-core@5.8.38/browser.min.js"></script>
      <script type="text/babel" src="js/react-one-player.js"></script>

</div>
  </body>
</html>
