<?php
/**
 * Created by PhpStorm.
 * User: russm
 * Date: 1/29/2017
 * Time: 10:36 AM
 */

ob_start();
include "includes/functions.php";
include "includes/header.php";

$db = db_connect();
/*
$firstname = mysqli_real_escape_string( $db, $_POST["firstname"]);
$lastname = mysqli_real_escape_string( $db, $_POST["lastname"]);*/
$username = mysqli_real_escape_string( $db, $_POST["username"]);
$password = mysqli_real_escape_string( $db, $_POST["password"]);
/*$verifypassword = mysqli_real_escape_string( $db, $_POST["verifypassword"]);
$email = mysqli_real_escape_string( $db, $_POST["email"]);
$advanced_user = mysqli_real_escape_string( $db, $_POST["advanced_user"]);*/
$submit = mysqli_real_escape_string( $db, $_POST["submit"]);

if ($submit){
    $sql = "SELECT user_name,password from users where user_name='$username'";
    $result = $db->query( $sql );
    if( $result && $result->num_rows){
        list( $username, $password_hash ) = $result->fetch_row();
        if(password_verify( $password, $password_hash )){
            $sql = "Select image_thumbnail, text_size from users where user_name='$username'";
            $pic = $db->query($sql)->fetch_row()[0];
            $_SESSION['text_size'] = $db->query($sql)->fetch_row()[1];
            $_SESSION['username'] = $username;
            $_SESSION['profile_pic'] = $pic;
            ob_clean();
            header("Location: /");
        }
    } else {
        $error_msg = "Unknown credentials - Please try again";
    }
}

$login_form = <<<END_OF_FORM
    <p>$error_msg<p>
    <form method="POST" action="/login.php">
        <label for"username">Username: </label><br/>
        <input type="text" name="username" value="$username"/><br/>
        <label for"password">Password: </label><br/>
        <input type="password" name="password" value=""/><br/>
        <input type="submit" name="submit" value="Submit"/><br/>
    </form><br/>
END_OF_FORM;

echo "<div class=\"login_box\">";
echo $login_form;
echo "<a href=\"registration.php\">New User? Register here</a>";
echo "</div>";

include "includes/footer.php";
ob_end_flush();
?>