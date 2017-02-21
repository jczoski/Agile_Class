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

$db = db_connect();

$username = mysqli_real_escape_string( $db, $_GET["username"]);

$sql = "SELECT * from users WHERE user_name = '$username'";
$result = $db->query($sql);
list($user_id, $firstname, $l_name, $username, $password, $email, $advanced, $image, $image_thumbnail, $text_size) = $result->fetch_row();

if($advanced == 1){
    $advanced_user_check = "advanced user: Yes";
} else {
    $advanced_user_check = "advanced user: No";
}

if($text_size == 0 || 3){
    $text_size_check = "Normal Text Size";
} elseif($text_size == 1){
    $text_size_check = "Smallest Text Size";
} elseif($text_size == 2){
    $text_size_check = "Small Text Size";
} elseif($text_size == 4){
    $text_size_check = "Larger Text Size";
} else {
    $text_size_check = "Largest Text Size";
}

$form = <<<END_OF_FORM
    <br />
    <div class="table-style aqua-text">
    <form>
        <label for="firstname">$firstname</label><br/>
        <label for="lastname">$l_name</label><br/>
        <label for"username">$username</label><br/>
        <label for="email">$email</label><br/>
        <label for="advanced_user">$advanced_user_check</label>
        <img src="$image" /><br />
        <label for="text_size">$text_size_check</label>
    </form><br/>
</div>
END_OF_FORM;

echo $form;

echo "<h4><a href='profile_edit.php'>Edit Profile</a></h4>";
echo "<h3><a href='posts_by_author.php'>See Posting History</a></h3>";


include "includes/footer.php";
ob_end_flush()
?>
