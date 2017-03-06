<?php
/**
 * Created by PhpStorm.
 * User: russm
 * Date: 3/6/2017
 * Time: 12:00 AM
 */

ob_start();
include "includes/functions.php";
include "includes/header.php";

if(!isset($_SESSION["username"])) {
    /*if ($_SESSION['advanced'] != 3) {*/
    ob_clean();
    header("Location: /index.php");
    /*}*/
}

$db = db_connect();
$user_id = mysqli_real_escape_string($db,$_GET["user_id"]);
$sql = "Delete from users where user_id=$user_id";
$result = $db->query($sql);
if( $result ){
    header("Location: /admin_page.php?msg=User-$user_id-successfully-deleted");
} else {
    header("Location: /admin_page.php?msg=Error-Deleting-User");
}
ob_end_flush();

?>