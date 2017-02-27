<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 2/8/2017
 * Time: 7:01 PM
 */
ob_start();
include "includes/functions.php";
include "includes/header.php";

$db = db_connect();
$post_id = mysqli_real_escape_string($db,$_GET["id"]);

$back_link= mysqli_real_escape_string($db,$_GET['discussion_return'])===""?$_SERVER['HTTP_REFERER']:
    mysqli_real_escape_string($db,$_GET['discussion_return']);

$submit = $_POST["submit"];
$modified_message = mysqli_real_escape_string($db,$_POST["message"]);
$id = mysqli_real_escape_string($db, $_POST["same_id"]);
$topic_return = mysqli_real_escape_string($db, $_POST["topic_return"]);
if($submit){
    $sql = "update posts set post_text='$modified_message', modify_date=NOW() where id=$id";
    echo $sql;
    $result = $db->query($sql);
    ob_clean();
    header("Location: $topic_return");
}
else {
    $sql = "SELECT * from posts where id=$post_id";
    list($id, $author, $topic, $category, $post_date, $modify_date, $post_text,$op) = $db->query($sql)->fetch_row();
}
$post_topic = <<<TOPIC_FORM
<h2>Edit Post - $topic</h2>
<form action="edit_post.php" method="post">
<label for="message">Message:</label><br />
<textarea name="message" rows="25" cols="155">$post_text</textarea><br />
<input type="hidden" name="same_id" value=$post_id>
<input type="hidden" name="topic_return" value="$back_link">
<input type="submit" name="submit" value="Edit Post" />
</form>
TOPIC_FORM;
echo "<div class=\"post_message\">";
echo $post_topic;

echo "</div>";

include "includes/footer.php";
ob_end_flush();
?>