<?php
/**
 * Created by PhpStorm.
 * User: coder
 * Date: 2/5/2017
 * Time: 10:01 PM
 */

$title = "Advanced User Application";
include "includes/header.php";
include "includes/functions.php";
$db = db_connect();
?>

<?php

$firstname = mysqli_real_escape_string( $db, $_POST["firstname"]);
$lastname = mysqli_real_escape_string( $db, $_POST["lastname"]);
$username = mysqli_real_escape_string( $db, $_POST["username"]);
$email = mysqli_real_escape_string( $db, $_POST["email"]);
$message = mysqli_real_escape_string( $db, $_POST["message"]);
$submit = mysqli_real_escape_string( $db, $_POST["submit"]);

$registration_error = "";
if( $submit ){
    if( empty( $message ) )
        $registration_error .= "Must provide info<br/>";

    // Check that this is a unique user - by checking if they exist

        if( empty($registration_error)){
            ob_clean();
            header( "Location: /login.php");
        }

    //create a new user
    echo $registration_error;  //redirect if ok
}

$form = <<<END_OF_FORM
<br />
<div class="aqua-text">
  <form method="POST" action="/advanced_application.php">
    <textarea name="message" placeholder="Your application message goes here" maxlength="1000" rows="8" cols="50" required>$message</textarea><br/>
    <input type="submit" name="submit" value="Submit"/><br/>
  </form><br/>
</div>
END_OF_FORM;

echo $form;

?>
<?php
include "includes/footer.php";
?>

