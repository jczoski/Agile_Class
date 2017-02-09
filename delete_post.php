<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 2/8/2017
 * Time: 9:40 PM
 */
ob_start();
include "includes/functions.php";
include "includes/header.php";

$db = db_connect();
$post_id = mysqli_real_escape_string($db,$_GET["id"]);
$return_site = $_SERVER['HTTP_REFERER'];
$sql = "Delete from posts where id=$post_id";
echo $sql;
$result = $db->query($sql);
ob_clean();
header("Location: $return_site");

?>