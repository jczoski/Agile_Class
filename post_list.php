<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/22/2017
 * Time: 5:54 PM
 */
include "includes/functions.php";
include "includes/header.php";
$db = db_connect();
$forum_type = mysqli_real_escape_string($db,$_GET["forum_type"]);
echo"<h2>$forum_type</h2>";
if(isset($_SESSION["username"]))
echo "<div class=\"forum_header\"> <a href=\"newtopic.php?forum_type=$forum_type\">Post New Topic</a> </div>";

$sql = "SELECT author, topic_name,category,post_date,modify_date from posts where category='$forum_type' and opening_post=1";
$result = $db->query($sql);
//<td></td>
echo "<table class=\"table-style\">";
while(list($author,$topic_name,$category,$post_date,$modify_date) = $result->fetch_row()){
    $post_list = <<<POST_LIST

<tr><td><h3><a href="discussion.php?author=$author&topic_name=$topic_name&category=$category"> $topic_name</a></h3><br />started by $author</td><td></td><td></td><td></td></tr>

POST_LIST;
    echo $post_list;
}
echo "</table>";

include "includes/footer.php";
?>