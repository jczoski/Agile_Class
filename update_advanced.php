<?php
/**
 * Created by PhpStorm.
 * User: russm
 * Date: 3/6/2017
 * Time: 12:00 AM
 */

ob_start();
include "includes/functions.php";
include "includes/header.php";

if (!isset($_SESSION["username"])) {
    /*if ($_SESSION['advanced'] != 3) {*/
    ob_clean();
    header("Location: /index.php");
    /*}*/
}

$db = db_connect();
$user_id = mysqli_real_escape_string($db, $_GET["user_id"]);
$sql = "Select from users where user_id=$user_id";
$result = $db->query($sql);
echo $result;
if ($result) {

    $submit = mysqli_real_escape_string($db, $_POST["submit"]);
    if (empty($submit)) {
        $sql = "SELECT from users where user_id=$user_id";
        $result = $db->query($sql);
        list($user_id, $f_name, $l_name,
            $user_name, $password, $email,
            $advanced, $image, $image_thumbnail,
            $text_size) = $result->fetch_row();
    } else {
        $advanced = mysqli_real_escape_string($db, $_POST["advanced"]);

        if (!empty($submit)) {
            $db = db_connect();
            $advanced = mysqli_escape_string($db, $advanced);

            $sql = "UPDATE users SET advanced='$advanced' WHERE user_id=$user_id";
            $result = $db->query($sql);
            ob_clean();
            header("Location: /admin_page.php");
        }
    }

    $form = <<<END_OF_FORM
    <br />
    <div class="table-style aqua-text">
    <form method="POST" action="/admin_page.php">
        <label for="firstname">First Name: $f_name</label><br/>
        <label for="lastname">Last Name: $l_name</label><br/>
        <label for"username">Username: $user_name</label><br/>
        <label for="email">Email: $email</label><br/>
        <label for="advanced_user">Advanced User</label>
        <select name="advanced">
            <option value="1">1 (basic)</option>
            <option value="2">2 (advanced)</option>
            <option value="3">3 (admin)</option>
        </select><br />
        <input type="submit" name="submit" value="Submit"/><br/>
    </form><br/>
</div>
END_OF_FORM;

    echo $form;

} /*else {
    header("Location: /admin_page.php?msg=Error_Updating_User");
}*/
ob_clean();

?>