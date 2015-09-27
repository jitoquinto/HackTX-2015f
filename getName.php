<?php

define('DIRECT',true);

$configs = require_once('config.php');
require('functions.php');

$conn = buildConn($configs);

if(empty($_GET)) {
  die();
}

$playerInfo = getBestMatch($conn, $_GET['id']);
echo $playerInfo['playerName'];

?>
