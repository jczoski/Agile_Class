<?php
/**
 * Created by PhpStorm.
 * User: russm
 * Date: 1/21/2017
 * Time: 4:03 AM
 */
ob_start();
include "includes/functions.php";
include "includes/header.php";

$db = db_connect();

$firstname = mysqli_real_escape_string( $db, $_POST["firstname"]);
$lastname = mysqli_real_escape_string( $db, $_POST["lastname"]);
$username = mysqli_real_escape_string( $db, $_POST["username"]);
$password = mysqli_real_escape_string( $db, $_POST["password"]);
$verifypassword = mysqli_real_escape_string( $db, $_POST["verifypassword"]);
$email = mysqli_real_escape_string( $db, $_POST["email"]);
$advanced_user_check = isset($_POST["advanced_user"])?TRUE:FALSE;
$submit = mysqli_real_escape_string( $db, $_POST["submit"]);

$encrypted_password = password_hash( $password, PASSWORD_DEFAULT );

$registration_error = "";
if( $submit ){
    if( empty( $username ) )
        $registration_error .= "Must supply username<br/>";
    if( empty( $email ) )
        $registration_error .= "Must supply email<br/>";
    if( empty( $password ) )
        $registration_error .= "Must supply password<br/>";
    if( $password != $verifypassword )
        $registration_error .= "Passwords must match<br/>";

    // Check that this is a unique user - by checking if they exist
    $sql = "SELECT user_name from users where user_name='$username'";
    $result = $db->query( $sql );
    if( $result->num_rows > 0){
        // Name already exists
        $registration_error .= "<p>Username already exists...try again!</p>";
    } else {
        if( empty($registration_error)){
            if(empty($advanced_user_check)){
                $advanced_user_check = 0;
            }
            // OK - insert the user into the db
            $sql = "INSERT INTO users (user_id, f_name, l_name, user_name, password, email, advanced)
                                values(null, '$firstname', '$lastname', '$username', '$encrypted_password', '$email', $advanced_user_check)";
            $result = $db->query( $sql );
            echo $sql;
            // Look at $result errors and display if there are some
//            if( ! $result ){
//                $registration_error .= "(" . $db->connect_errno . ")" .
//            $db->connect_error;
//            }
            ob_clean();
            if($advanced_user_check == 0){
                header( "Location: /login.php");
            } else {
                header( "Location: /advanced_application.php");
            }
        }
    }
    //create a new user
    $registration_error;  //redirect if ok
}

$form = <<<END_OF_FORM
    <br />
    <div class="aqua-text">
    <form method="POST" action="/registration.php">
        <label for="firstname">First Name: </label><br/>
        <input type="text" name="firstname" value="$firstname"/><br/>
        <label for="lastname">Last Name: </label><br/>
        <input type="text" name="lastname" value="$lastname"/><br/>
        <label for"username">Username: </label><br/>
        <input type="text" name="username" value="$username"/><br/>
        <label for="password">Password: </label><br/>
        <input type="password" name="password" value=""/><br/>
        <label for="verifypassword">Verify Password: </label><br/>
        <input type="password" name="verifypassword" value=""/><br/>
        <label for="email">Email: </label><br/>
        
        <input type="email" name="email" value="$email"/><br/>
        <label for="advanced_user">Advanced User</label>
        <input type="checkbox" name="advanced_user" id="advanced_user" value="yes" $advanced_user_check><br />
        <input type="submit" name="submit" value="Submit"/><br/>
    </form><br/>
</div>
END_OF_FORM;

echo $form;
include "includes/footer.php";
ob_end_flush()
?>