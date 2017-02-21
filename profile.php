<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 2/13/2017
 * Time: 8:59 AM
 */
ob_start();
include "includes/header.php";
include "includes/functions.php";
if(!isset($_SESSION["username"])){
    ob_clean();
    header("Location: /index.php");
}

echo "<h4><a href='profile_edit.php'>Edit Profile</a></h4>";

echo "<h3><a href='posts_by_author.php'>See Posting History</a></h3>";


include "includes/footer.php";
ob_end_flush()
?>
