<?php

function buildConn($configs) {
  $sqlServer = $configs['dbHost'];
  $sqlUser = $configs['dbUser'];
  $sqlPass = $configs['dbPass'];
  $sqlName = $configs['dbName'];
  try {
    $conn = new PDO("mysql:host=$sqlServer;dbname=$sqlName", $sqlUser, $sqlPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "SQL Connection established.";
  }
  catch(PDOException $e) {
    $genError = $e->getMessage();
    //echo "Connection failed: " . $e->getMessage();
    die();
  }
return $conn;
}


// pull an array of the best five players based on ratio
function bestFive($conn) {
  try {
    $sql = "SELECT * FROM players ORDER BY ratio DESC LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt -> execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // foreach ($rows as $row) {
    //     echo $row['playerName'];
    // }
  }
  catch(PDOException $e) {
    echo "Statement failed: " . $e->getMessage();
    die();
  }
  return $rows;
}

function fivePlayedMatches($conn) {
  $sql = "SELECT * FROM matches WHERE playDate < NOW() LIMIT 5";
  $stmt = $conn->prepare($sql);
  $stmt -> execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

function getPlayerList($conn) {
  $sql = "SELECT * FROM players ORDER BY playerName";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

function fiveUpcomingMatches($conn) {
  $sql = "SELECT * FROM matches WHERE playDate > NOW() LIMIT 5";
  $stmt = $conn->prepare($sql);
  $stmt -> execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

function fiveCourts($conn) {
  $sql = "SELECT * FROM locations LIMIT 5";
  $stmt = $conn->prepare($sql);
  $stmt -> execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

function resolveMatch($conn, $matchInfo) {
  $playerOneId = $matchInfo['player1id'];
  $playerTwoId = $matchInfo['player2id'];
  $sql = "SELECT playerName FROM players WHERE id = :playerId LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt -> execute(array(":playerId" => $playerOneId));
  $rows = $stmt->fetchColumn();
  $playerOneName = $rows;
  $sql = "SELECT playerName FROM players WHERE id = :playerId LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt -> execute(array(":playerId" => $playerTwoId));
  $rows = $stmt->fetchColumn();
  $playerTwoName = $rows;

  return array(
    "playerOne" => $playerOneName,
    "playerTwo" => $playerTwoName,
    "playerOneScore" => $matchInfo['score1'],
    "playerTwoScore" => $matchInfo['score2']
    );

}

function countUsers($conn) {
  $sql = "SELECT COUNT(*) FROM players";
  $stmt = $conn->prepare($sql);
  $stmt -> execute();
  $num = $stmt->fetchColumn();
  return $num;
}

function countCourts($conn) {
  $sql = "SELECT COUNT(*) FROM locations";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute();
  $num = $stmt->fetchColumn();
  return $num;
}

function countUpcomingMatches($conn) {
  $sql = "SELECT COUNT(*) FROM matches WHERE playDate > NOW()"; // fix later
  $stmt = $conn -> prepare($sql);
  $stmt -> execute();
  $num = $stmt->fetchColumn();
  return $num;
}

function countTotalMatches($conn) {
  $sql = "SELECT COUNT(*) FROM matches";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute();
  $num = $stmt->fetchColumn();
  return $num;
}


?>
