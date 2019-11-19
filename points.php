<?php
require_once 'TeamsConfig.php';

 $_SESSION['team_id'] = isset($_GET['team_id']) ? (int) $_GET['team_id'] : 0;

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
    // $teams = new TeamsDb();
    // $allTeams = $teams->getAllTeams();
    // $players = $teams->getAllPlayers();

    echo "<h2>Pistetilanne</h2>";

    ?>
    <div id="container"></div>

      <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
      <script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
      <script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
      <script src="https://unpkg.com/babel-core@5.8.38/browser.min.js"></script>
      <script type="text/babel" src="js/react-points.js"></script>

</div>
  </body>
</html>
