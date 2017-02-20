<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 2/13/2017
 * Time: 8:59 AM
 */
include "includes/header.php";
include "includes/functions.php";
if(!isset($_SESSION["username"])){
    header("Location: almostdone.joshczoski.com");
}
echo "<h3><a href='posts_by_author.php'>See Posting History</a></h3>";

?>

<?php
include "includes/footer.php";
?>
