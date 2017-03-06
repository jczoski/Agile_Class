<?php
/**
 * Created by PhpStorm.
 * User: russm
 * Date: 2/27/2017
 * Time: 9:32 AM
 */
ob_start();
include "includes/header.php";
include "includes/functions.php";

if(!isset($_SESSION["username"])) {
    /*if ($_SESSION['advanced'] != 3) {*/
        ob_clean();
        header("Location: /index.php");
    /*}*/
}

$db= db_connect();
$user_name = $_SESSION["username"];
$sql = "Select * from users";
$result =$db->query($sql);
echo "<table class=\"table-style\"><th><h2>User</h2></th><th><h2>Email</h2></th><th><h2>Name</h2></th><th><h2>User Level</h2></th><th><h2>Delete</h2></th>";

while(list($user_id, $f_name, $l_name, $user_name, $password, $email, $advanced, $image, $image_thumbnail, $text_size) = $result->fetch_row()){

    $users = <<<USERS_FORM
<tr><td>$user_name</td><td>$email</td><td>$f_name $l_name</td><td><a href='update_advanced.php?user_id=$user_id'>$advanced</a></td><td><a href='/delete_user.php?user_id=$user_id'>Delete User</a></td></tr>

USERS_FORM;
    echo $users;
}
echo "</table>";

?>

<?php
include  "includes/footer.php";
ob_flush();
?>
