<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/22/2017
 * Time: 5:54 PM
 */
echo"<h2>$forum_type forum</h2>";
$category_link = $_SERVER["REQUEST_URI"];
if(isset($_SESSION["username"]))
echo "<div class=\"forum_header\"> <a href=\"newtopic.php?forum_type=$forum_type&url=$category_link\">Post New Topic</a> </div>";
?>