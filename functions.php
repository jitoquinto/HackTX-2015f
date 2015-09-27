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

function countUsers($conn) {
  $sql = "SELECT COUNT(*) from players";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute();
  $num = $stmt->fetchColumn();
  echo $num;
}

?>
