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
$edit_delete_return = mysqli_real_escape_string($db,$_POST["for_edit_delete"]);
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
    $sql = "INSERT INTO posts(id,author,topic_name,category,post_date,modify_date,post_text,opening_post)
VALUES(null,'$reply_user','$topic','$category',NOW(),NOW(),'$reply_text',0)";
    $result = $db->query($sql);
}

$sql = "SELECT * from posts where topic_name='$topic' and category='$category'";
$result = $db->query($sql);

echo "<table class='table-style'><th><h2>Author</h2></th><th><h2>Topic: $topic</h2></th>";
while (list($id, $author, $topic, $category, $post_date, $modify_date, $post_text,$opening_post) = $result->fetch_row()) {
//$post_date = date("D",$post_date) . date("M",$post_date). date("j",$post_date).date("o",$post_date);
    $sql = "Select image_thumbnail from users where user_name='$author'";
    $pic = $db->query($sql)->fetch_row()[0];
    $editable = "&nbsp;";
    $delete = "&nbsp;";
    if ($author === $_SESSION["username"]) {
        $author = "<a href='profile.php'>" . $author. "</a>";
        $editable = "<a href='edit_post.php?id=$id&discussion_return=$edit_delete_return'>Edit post</a>";
        $delete = "<a href='delete_post.php?id=$id&discussion_return=$edit_delete_return'>Delete post</a>";
    }
    $posts = <<<POSTS

<tr><td>$author <img src='$pic' /></td><td>posted: $post_date<br />$post_text</td><td>$editable</td><td>$delete</td></tr>

POSTS;

    echo $posts;
}
echo "</table>";
if (isset($_SESSION["username"])) {
    $user_name = $_SESSION["username"];
    $return_address = $_SERVER['PHP_SELF'];
//    $edit_delete_return = $_SERVER['HTTP_REFERER'];
    echo $edit_delete_return;
$reply_form=<<<REPLY_FORM
    <div>
        <form class="table-style" action="$return_address" method="post">
            <label for="reply">Reply:</label><br/>
            <textarea name="reply" rows="15" cols="55"></textarea><br/>
            <input type="hidden" name="reply_user" value="$user_name">
            <input type="hidden" name="reply_topic" value="$copy_topic" >
            <input type="hidden" name="reply_category" value="$copy_category" >
            <input type="hidden" name="for_edit_delete" value="$edit_delete_return">
            <input type="submit" name="submit" value="reply"/>            
        </form>
    </div>
REPLY_FORM;
echo $reply_form;
}
include "includes/footer.php";
?>