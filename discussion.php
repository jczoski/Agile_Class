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
$author = mysqli_real_escape_string($db, $_GET["author"]);
$category = mysqli_real_escape_string($db, $_GET["category"]);

$sql = "SELECT * from posts where topic_name='$topic' and category='$category'";
$result = $db->query($sql);
echo "<h2>$topic</h2>";

echo "<table class=\"table-style\"><th>Author</th><th>Topic: $topic</th>";
while (list($id, $author, $topic, $category, $post_date, $modify_date, $post_text) = $result->fetch_row()) {
//$post_date = date("D",$post_date) . date("M",$post_date). date("j",$post_date).date("o",$post_date);
    $posts = <<<POSTS

<tr><td>$author</td><td>posted: $post_date<br />$post_text</td></tr>

POSTS;
}
echo $posts;
echo "</table>";
if (isset($_SESSION["username"])) {
//echo "<a href=\"reply.php\"><h2>Reply</h2></a>";

    ?>

    <div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="reply">Reply:</label><br/>
            <textarea name="reply" rows="15" cols="55"></textarea><br/>
            <input type="submit" name="submit" value="reply"/>
        </form>
    </div>

    <?php
}
include "includes/footer.php";
?>