<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/27/2017
 * Time: 8:49 PM
 */
function db_connect()
{
    $db = new mysqli('mysql.almostdone.joshczoski.com', 'almost_doners', 'JoshRussDustinftw', 'mysql_almostdone_joshczoski_com');
    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db->connect_errno . ")" . $db->error;
        return $db;
    }
    return $db;
}
?>