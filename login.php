<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/22/2017
 * Time: 4:51 PM
 */
include "includes/header.php";

$form = <<<LOGIN
<form method="POST" action="/index.php">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="username"/><br />
        <label for="password">Password:</label>
        <input type="text" name="password" placeholder="password" />
        &nbsp;&nbsp;&nbsp;
        <input type="submit" name="submit" value="Sign in"/>
    </form><br/>
LOGIN;
echo "<div class=\"login_box\">";
echo $form;
echo "<a href=\"registration.php\">New User? Register here</a>";
echo "</div>";
?>

<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 1/22/2017
 * Time: 4:51 PM
 */
include "includes/footer.php";
?>