<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/18/2017
 * Time: 8:26 AM
 */


session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title><?php $title ?></title>
    <link rel="stylesheet" type="text/css" href="../css/main.css" />
    <link rel="stylesheet" type="text/css" href="../css/format_table.css" />
</head><body><header class="header-style">
    <nav class="nav-style">
        <a href="almostdone.joshczoski.com">Home</a>
    </nav>
<?php if(!isset($_SESSION["username"])){
    echo "<a href='login.php'>Log In/Register</a>";
}
else {
    echo "Hello " . $_SESSION["username"];
    echo "\t\t\t <a href='logout.php'>Log Out</a>";
}
?>

</header>
