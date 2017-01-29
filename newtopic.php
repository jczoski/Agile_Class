<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/22/2017
 * Time: 6:41 PM
 */
include "includes/header.php";

$post_topic = <<<TOPIC_FORM
<h2>Post New Topic:</h2>
<form>
<label for="topic">Topic:</label><br />
<input type="text" name="topic" placeholder="Topic" size="159"/><br />
<label for="message">Message:</label><br />
<textarea name="message" rows="25" cols="160"></textarea><br />
<input type="submit" name="submit" value="Post Topic" />
</form>
TOPIC_FORM;
echo "<div class=\"post_message\">";
echo $post_topic;

echo "</div>";
?>

<?php
include "includes/footer.php";
?>
