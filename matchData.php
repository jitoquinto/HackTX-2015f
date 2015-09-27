<?php

define('DIRECT',true);

$configs = require_once('config.php');
require('functions.php');

$conn = buildConn($configs);

if(empty($_GET)) {
  die();
}

$playerInfo = getPlayerInfo($conn, $_GET['id']);
echo '<p class="muted text-center">';
echo "Wins: " . $playerInfo['wins'] . "</br>";
echo "Losses: " . $playerInfo['losses'] . "</br>";
?>
