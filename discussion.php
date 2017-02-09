<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 2/4/2017
 * Time: 7:01 PM
 */
include "includes/header.php";
include "includes/functions.php";

$db = db_connect();

$topic = mysqli_real_escape_string($db, $_GET["topic_name"]);
if(!$topic) {
    $topic = mysqli_real_escape_string($db, $_POST["reply_topic"]);
}
$copy_topic = $topic;
$author = mysqli_real_escape_string($db, $_GET["author"]);
$category = mysqli_real_escape_string($db, $_GET["category"]);
if(!$category){
$category =mysqli_real_escape_string($db, $_POST["reply_category"]);
}
$copy_category=$category;
$submit = $_POST["submit"];
$reply_text = mysqli_real_escape_string($db,$_POST["reply"]);
$reply_user = mysqli_real_escape_string($db, $_POST["reply_user"]);

if($submit){
    $sql = "INSERT INTO posts(id,author,topic_name,category,post_date,modify_date,post_text)
VALUES(null,'$reply_user','$topic','$category',NOW(),NOW(),'$reply_text')";
    $result = $db->query($sql);

}


$sql = "SELECT * from posts where topic_name='$topic' and category='$category'";

$result = $db->query($sql);
echo "<h2>$topic</h2>";

echo "<table class=\"table-style\"><th>Author</th><th>Topic: $topic</th>";
while (list($id, $author, $topic, $category, $post_date, $modify_date, $post_text) = $result->fetch_row()) {
//$post_date = date("D",$post_date) . date("M",$post_date). date("j",$post_date).date("o",$post_date);
    $editable = "&nbsp;";
    if ($author === $_SESSION["username"]) {
        $editable = "<a href='edit_post.php?id=$id'>Edit post</a>";
    }
    $posts = <<<POSTS

<tr><td>$author</td><td>posted: $post_date<br />$post_text</td><td>$editable</td></tr>

POSTS;

    echo $posts;
}
echo "</table>";
if (isset($_SESSION["username"])) {
    $user_name = $_SESSION["username"];
    $return_address = $_SERVER['PHP_SELF'];
$reply_form=<<<REPLY_FORM
    <div>
        <form action="$return_address" method="post">
            <label for="reply">Reply:</label><br/>
            <textarea name="reply" rows="15" cols="55"></textarea><br/>
            <input type="hidden" name="reply_user" value="$user_name">
            <input type="hidden" name="reply_topic" value="$copy_topic" >
            <input type="hidden" name="reply_category" value="$copy_category" >
            <input type="submit" name="submit" value="reply"/>
        </form>
    </div>
REPLY_FORM;
echo $reply_form;
}
include "includes/footer.php";
?>