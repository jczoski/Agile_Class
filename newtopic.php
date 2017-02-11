<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/22/2017
 * Time: 6:41 PM
 */
ob_start();
include "includes/header.php";
include "includes/functions.php";

$db = db_connect();

$category = mysqli_real_escape_string($db,$_GET["forum_type"]);
$message_body = mysqli_real_escape_string($db,$_POST["message"]);
$topic = mysqli_real_escape_string($db,$_POST["topic"]);
$submit = $_POST["submit"];
$author = $_SESSION["username"];



if($submit) {
    $sql = "INSERT INTO posts (id,author,topic_name,category,post_date,modify_date,post_text,opening_post)
VALUES (null,'$author','$topic','$category',NOW(),NOW(),'$message_body',1 )";


$result = $db->query($sql);
if($result){
    ob_clean();
    header("Location: /post_list.php?forum_type=$category");
}
else
    echo $sql;
}
$post_topic = <<<TOPIC_FORM
<h2>Post New Topic:</h2>
<form action="newtopic.php?forum_type=$category" method="post">
<label for="topic">Topic:</label><br />
<input type="text" name="topic" placeholder="Topic" value="$topic" size="159"/><br />
<label for="message">Message:</label><br />
<textarea name="message" rows="25" cols="155">$message_body</textarea><br />
<input type="submit" name="submit" value="Post Topic" />
</form>
TOPIC_FORM;
echo "<div class=\"post_message\">";
echo $post_topic;

echo "</div>";
?>

<?php
include "includes/footer.php";
ob_end_flush();
?>