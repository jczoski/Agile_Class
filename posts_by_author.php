<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 2/13/2017
 * Time: 9:16 AM
 */
ob_start();
include "includes/header.php";
include "includes/functions.php";

if(!isset($_SESSION["username"])){
    header("Location: almostdone.joshczoski.com");
}
$db= db_connect();
$user_name = $_SESSION["username"];
$sql = "Select * from posts where author='$user_name'";
$result =$db->query($sql);
echo "<table class=\"table-style\"><th><h2>Topic</h2></th><th><h2>Message</h2></th>";

while(list($id, $author, $topic, $category, $post_date, $modify_date, $post_text,$op) = $db->query($sql)->fetch_row()){

$posts_by_author = <<<POSTS_BY_AUTHOR
<tr><td><a href='discussion.php?author=$author&category=$category'>$topic</a><td><td>posted: $post_date<br />$post_text</td></tr>

POSTS_BY_AUTHOR;
echo $posts_by_author;

}
echo "</table>";

?>

<?php
include  "includes/footer.php";
ob_end_flush();
?>
