<?php
include('login.php');
define('allowed',true);
include('../db.php');

$id = (int) $_GET['id'];
$tname = str_replace("'","\\'",$_GET['t']);
$previous = $_GET['p'];
$mysqli->query("DELETE FROM ".$tname." WHERE id=".$id.";");
header("Location: ".$previous);
$mysqli->close();
?>
