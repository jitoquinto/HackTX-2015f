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

function countUsers($conn) {
  $sql = "SELECT COUNT(*) FROM players";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute();
  $num = $stmt->fetchColumn();
  return $num;
}

function countCourts($conn) {
  $sql = "SELECT COUNT(*) FROM courts";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute();
  $num = $stmt->fetchColumn();
  return $num;
}

function countMatches($conn) {
  $sql = "SELECT COUNT(*) FROM matches WHERE id > :matchId "; // fix later
  $stmt = $conn -> prepare($sql);
  $stmt -> execute(array(":matchId" => 1));
  $num = $stmt->fetchColumn();
  return $num;
}

?>
