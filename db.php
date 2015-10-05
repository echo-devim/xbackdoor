<?php
defined('allowed') or die("Not Found");

$mysqli = new mysqli("mysqlhost", "mysqluser", "mysqlpassword", "mysqldatabasename");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

?>
