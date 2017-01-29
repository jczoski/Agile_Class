<?php
/**
 * Created by PhpStorm.
 * User: russm
 * Date: 1/21/2017
 * Time: 4:03 AM
 */
ob_start();
include "includes/functions.php";

$db = db_connect();

//
//$username = mysqli_real_escape_string( $db, $_POST["username"]);
//$password = mysqli_real_escape_string( $db, $_POST["password"]);
//$email = mysqli_real_escape_string( $db, $_POST["email"]);
//$submit = mysqli_real_escape_string( $db, $_POST["submit"]);
//
//$encrypted_password = password_hash( $password, PASSWORD_DEFAULT );
//
//$registration_error = "";
//if( $submit ){
//    if( empty( $username ) )
//        $registration_error .= "Must supply username<br/>";
//    if( empty( $email ) )
//        $registration_error .= "Must supply email<br/>";
//    if( empty( $password ) )
//        $registration_error .= "Must supply password<br/>";
//
//    // Check that this is a unique user - by checking if they exist
//    $sql = "SELECT username from users where username='$username'";
//    $result = $db->query( $sql );
//    if( $result->num_rows > 0){
//        // Name already exists
//        $registration_error .= "<p>Username already exists...try again!</p>";
//    } else {
//        if( empty($registration_error)){
//            // OK - insert the user into the db
//            $sql = "INSERT INTO users (id, username, password, email)
//                                values(null, '$username', '$encrypted_password', '$email')";
//            $result = $db->query( $sql );
//            // Look at $result errors and display if there are some
////            if( ! $result ){
////                $registration_error .= "(" . $db->connect_errno . ")" .
////            $db->connect_error;
////            }
//            ob_clean();
//            header( "Location: /");
//        }
//    }
//    //create a new user
//  $registration_error  //redirect if ok
//}

$form = <<<END_OF_FORM
    
    <form method="POST" action="/register.php">
        <label for"firstname">First Name: </label><br/>
        <input type="text" name="firstname" value="firstname"/><br/>
        <label for"lastname">Last Name: </label><br/>
        <input type="text" name="lastname" value="lastname"/><br/>
        <label for"username">Username: </label><br/>
        <input type="text" name="username" value="username"/><br/>
        <label for"password">Password: </label><br/>
        <input type="password" name="password" value=""/><br/>
        <label for"email">Email: </label><br/>
        <input type="email" name="email" value="email"/><br/>
        <input type="submit" name="submit" value="Submit"/><br/>
    </form><br/>
END_OF_FORM;

echo $form;
ob_end_flush()
?>