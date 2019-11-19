<?php

class TeamsDb {
  private $dbConnection;
  
  public function __construct() {
	try {
	    $this->dbConnection = new PDO('mysql:host=mysql.labranet.jamk.fi;dbname=N0464;charset=utf8',
		          'N0464', 'JbOjmEt3L3ZOa27Dr3Gbq2Cw99wWjznm');
	    //$this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
	    //$this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	     $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $ex) {
	    echo "ErrMsg to enduser!<hr>\n";
	    echo "CatchErrMsg: " . $ex->getMessage() . "<hr>\n";
	    //logError($ex->getMessage());
	}
  }





    /******************************************  getAllTeams   ******************************** *****/
    public function getAllTeams() {
      $teams = array();
      $query = <<<SQL
          SELECT 
            `joukkue`.`IDjoukkue`, 
            `joukkue`.`joukkueNimi`,
            `joukkue`.`managerNimi`
          FROM `joukkue`
SQL;
      
      $resultObj = $this->dbConnection->prepare($query);
      $resultObj->execute();
      
      while ($row = $resultObj->fetch(PDO::FETCH_ASSOC)) {
        $teams[] = $row;
      }
      
      return $teams;
    }


    /******************************************  getAllPlayers   ******************************** *****/
    public function getAllPlayers() {
      $players = array();
      $query = <<<SQL
          SELECT 
            `pelaaja`.`IDpelaaja`, 
            `pelaaja`.`etunimi`,
            `pelaaja`.`sukunimi`,
            `pelaaja`.`numero`,
            `pelaaja`.`joukkue_IDjoukkue`
          FROM `pelaaja`
          WHERE `pelaaja`.`joukkue_IDjoukkue` = :session_t_id
SQL;
      
      $resultObj = $this->dbConnection->prepare($query);
      $resultObj->bindValue(':session_t_id', $_SESSION['t_id'], PDO::PARAM_INT);
      $resultObj->execute();
      // $resultObj = $this->dbConnection->prepare($query);
      // $resultObj->execute();
      
      while ($row = $resultObj->fetch(PDO::FETCH_ASSOC)) {
        $players[] = $row;
      }
      
      return $players;
    }


    /******************************************  getOnePlayer   ******************************** *****/
    public function getOnePlayer() {
      $players = array();
      $query = <<<SQL
          SELECT 
            `pelaaja`.`IDpelaaja`, 
            `pelaaja`.`etunimi`,
            `pelaaja`.`sukunimi`,
            `pelaaja`.`numero`,
            `pelaaja`.`joukkue_IDjoukkue`
          FROM `pelaaja`
          WHERE `pelaaja`.`IDpelaaja` = :session_p_id
SQL;
      
      $resultObj = $this->dbConnection->prepare($query);
      $resultObj->bindValue(':session_p_id', $_SESSION['p_id'], PDO::PARAM_INT);
      $resultObj->execute();
      // $resultObj = $this->dbConnection->prepare($query);
      // $resultObj->execute();
      
      while ($row = $resultObj->fetch(PDO::FETCH_ASSOC)) {
        $players[] = $row;
      }
      
      return $players;
    }

    /******************************************  getAllPlayersG   ******************************** *****/
    public function getAllPlayersG() {
      $players = array();
      $query = <<<SQL
          SELECT 
            `pelaaja`.`IDpelaaja`, 
            `pelaaja`.`etunimi`,
            `pelaaja`.`sukunimi`,
            `pelaaja`.`numero`,
            `pelaaja`.`joukkue_IDjoukkue`,
            count(*) AS maalit,
            `joukkue`.`joukkueNimi`
          FROM `pelaaja`
          INNER JOIN `maali`
          ON `pelaaja`.`IDpelaaja` = `maali`.`pelaaja_IDtekija`
          INNER JOIN `joukkue`
          ON `joukkue_IDjoukkue` = `IDjoukkue`
          GROUP BY `pelaaja`.`IDpelaaja`
SQL;

// echo $query,  $_SESSION['t_id']; exit();
      
      $resultObj = $this->dbConnection->prepare($query);
      $resultObj->execute();
      
      while ($row = $resultObj->fetch(PDO::FETCH_ASSOC)) {
        $players[] = $row;
      }
      
      return $players;
    }


      /******************************************  addTeam   ***********************************/

  public function addTeam($t_name, $t_mngr) {
    $addResult = 0;
    
    $query = <<<SQL
      INSERT INTO `joukkue`(`joukkueNimi`, `managerNimi`)
      VALUES (:jnimi, :mnimi)
SQL;

    $result = $this->dbConnection->prepare($query);
    $result->bindValue(':jnimi', $t_name, PDO::PARAM_STR);
    $result->bindValue(':mnimi', $t_mngr, PDO::PARAM_STR);
    $result->execute(); 


    if ($result->rowCount() == 1) {
      $addResult = $this->dbConnection->lastInsertId();
    } else {
      echo $this->dbConnection->error;
    }
    
    return $addResult;
  }


  /******************************************  addPlayer   ***********************************/

  public function addPlayer($p_fname, $p_sname, $p_number) {
    $addResult = 0;
    
    $query = <<<SQL
      INSERT INTO `pelaaja`(`etunimi`, `sukunimi`, `numero`, `joukkue_IDjoukkue`)
      VALUES (:enimi, :snimi, :numero, :session_t_id)
SQL;

// echo $query,  $_SESSION['t_id']; exit();

    $result = $this->dbConnection->prepare($query);
    $result->bindValue(':enimi', $p_fname, PDO::PARAM_STR);
    $result->bindValue(':snimi', $p_sname, PDO::PARAM_STR);
    $result->bindValue(':numero', $p_number, PDO::PARAM_STR);
    $result->bindValue(':session_t_id', $_SESSION['t_id'], PDO::PARAM_INT);
    $result->execute(); 


    if ($result->rowCount() == 1) {
      $addResult = $this->dbConnection->lastInsertId();
    } else {
      echo $this->dbConnection->error;
    }
    
    return $addResult;
  }
        

}
