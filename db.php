<?php
defined('allowed') or die("Not Found");

date_default_timezone_set('Europe/Paris');
$mysqli = new mysqli("mysqlhost", "mysqluser", "mysqlpassword", "mysqldatabasename");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

?>
