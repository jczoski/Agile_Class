<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/18/2017
 * Time: 8:26 AM
 */


session_start();
if(isset($_SESSION["username"])) {
    $u_name = $_SESSION["username"];
    $profile_pic_location = $_SESSION['profile_pic'];
    $profile_pic_image = "<img src='$profile_pic_location'>";//can be used anywhere in the page
    $preferred_size = $_SESSION['text_size']; //skipping 3 because that is the default
    $preferred_size_string="";
    if($preferred_size==1){
        $preferred_size_string = "10px";
    }
    else if($preferred_size ==2){
        $preferred_size_string = "15px";
    }
    else if($preferred_size==4){
        $preferred_size_string = "25px";
    }
    else if($preferred_size==5){
        $preferred_size_string = "30px";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php $title ?></title>
    <link rel="stylesheet" type="text/css" href="../css/main.css" />
    <link rel="stylesheet" type="text/css" href="../css/format_table.css" />
</head><body <?php echo $preferred_size==3?"":"style='font-size:$preferred_size_string;'"; ?>><header class="header-style">
    <nav class="nav-style">
        <a href="http://almostdone.joshczoski.com">Home</a>
    </nav>
    <?php if(!isset($_SESSION["username"])){
        echo "<a href='login.php'>Log In/Register</a>";
    }

    else {

        echo $profile_pic_image . "<br />Hello " ."<a href='profile.php'>$u_name</a>";
        echo "\t\t\t <a href='logout.php'>Log Out</a>";
        echo "<a href='admin_page.php'>admin page</a>";
    }
    ?>

</header>