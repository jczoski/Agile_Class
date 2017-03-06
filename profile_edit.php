<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 11/19/2016
 * Time: 9:16 PM
 */
ob_start();
include "includes/header.php";
include "includes/functions.php";
?>

<?php
$db = db_connect();

$id = mysqli_real_escape_string($db, $_GET["id"]);
$submit = mysqli_real_escape_string($db, $_POST["submit"]);
$submit_pic = $_POST["submit_pic"];
$username = $_SESSION["username"];
$submit_text = $_POST["submit_text"];
//$text_size = $_POST["text_size"];
$text_size = $_POST["preferred_size"] == "" ? $_SESSION['text_size'] : $_POST["preferred_size"];
$submit_profile = $_POST["submit_profile"];
$f_name = mysqli_real_escape_string( $db, $_POST["firstname"]);
$l_name = mysqli_real_escape_string( $db, $_POST["lastname"]);
$db_email = mysqli_real_escape_string( $db, $_POST["email"]);
$db_advanced = isset($_POST["advanced_user"])?TRUE:FALSE;

$sql = "SELECT * from users WHERE user_name = '$username'";
$result = $db->query($sql);
list($user_id, $f_name, $l_name, $username, $password, $db_email, $db_advanced, $image, $image_thumbnail, $text_size) = $result->fetch_row();


if ($submit_text) {

    $sql = "UPDATE users SET text_size=$text_size
WHERE user_name='$username'";
    $result = $db->query($sql);
    $_SESSION['text_size'] = $text_size;
    //  ob_clean();
    header("Location: /profile_edit.php");
}

if ($submit_pic) {
    $uploaded_file_name = $_FILES["image"]["tmp_name"];
    move_uploaded_file($uploaded_file_name, "upload/" . $_FILES["image"]["name"]);
    $image_path = "upload/" . $_FILES["image"]["name"];
    $file_type = $_FILES["image"]["type"];

    if ($file_type == "image/png") {
        $src = imagecreatefrompng($image_path);
    } else if ($file_type == "image/jpeg") {
        $src = imagecreatefromjpeg($image_path);
    } else if ($file_type == "image/gif") {
        $src = imagecreatefromgif($image_path);
    }
    list($width, $height) = getimagesize($image_path);
    $new_width = 60;
    $new_height = ($height / $width) * $new_width;

    $tmp = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    $thumb_filename = "images/thumbs/" . $_FILES["image"]["name"];
    imagejpeg($tmp, $thumb_filename, 100);
    imagedestroy($src);
    imagedestroy($tmp);
    $sql = "UPDATE users SET image='$image_path',image_thumbnail='$thumb_filename'
WHERE user_name='$username'";

    $result = $db->query($sql);

    $_SESSION['profile_pic'] = $thumb_filename;
}



/*
    $sql = "Select text_size from users where user_name = '$username'";
    list($text_size)=$db->query($sql)->fetch_row()[0];
    echo "text: " .$text_size;
*/
$text_size_form = <<<TEXT_SETTING
<form action="/profile_edit.php" method="POST" style="color:white;">
 <label for="text_size">Text Size Preference: $text_size</label><br>
<!-- <input name="text_size" value="1" type="radio">smallest<br>
<input name="text_size" value="2" type="radio">small<br>
<input name="text_size" value="3" type="radio">normal<br>
<input name="text_size" value="4" type="radio">larger<br>
<input name="text_size" value="5" type="radio">largest<br> -->
<input type="range" id="text_size" min="10" max="30" name="text_size" value=$text_size> 
<input type="hidden" id="preferred_size" name="preferred_size" value="">
<input type="submit" name="submit_text" value="Update Text Size" />
</form>
TEXT_SETTING;

echo $text_size_form;
//echo "<button onclick='default_text_size'>Reset Size to Default</button>";
$image_form = <<<END_OF_FORM
<img src="$thumb_filename" /><br />
<form action="/profile_edit.php" method="POST" enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit" name="submit_pic" value="Update Image" />

</form>

END_OF_FORM;

echo $image_form;

$profile_form = <<<END_OF_FORM
    <br />
    <div class="table-style aqua-text">
    <form method="POST" action="/profile_edit.php">
        <label for="firstname">First Name: </label>
        <input type="text" name="firstname" value="$f_name"/><br/>
        <label for="lastname">Last Name: </label>
        <input type="text" name="lastname" value="$l_name"/><br/>
        <label for="email">Email: </label>
        <input type="email" name="email" value="$db_email" /><br/>
        <label for="advanced_user">Advanced User</label>
        <input type="checkbox" name="advanced_user" id="advanced_user" value="$db_advanced"><br />
        <input type="submit" name="submit_profile" value="Submit Profile Changes"/><br/>
    </form><br/>
</div>
END_OF_FORM;

echo $profile_form;
if ($submit_profile) {
    $sql = "UPDATE users SET f_name='$f_name', l_name='$l_name', email='$db_email', advanced=$db_advanced WHERE user_name='$username'";
    $result = $db->query($sql);
    ob_clean();
    if ($advanced_user_check == 0) {
        header("Location: /");
    } else {
        header("Location: /advanced_application.php");
    }
}
echo "<script src='scripts/slider.js'></script>";
echo "<script src='http://jcrop-cdn.tapmodo.com/v0.9.12/js/jquery.Jcrop.min.js'></script>";
echo "<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>";
?>
<?php
/*
// example upload output: ArrayArray ( [name] => url.txt [type] => text/plain [tmp_name] => /tmp/phpVAkaNU [error] => 0 [size] => 56 )
if(!empty($submit)){
    $uploaded_file_name = $_FILES["image"]["tmp_name"];
    move_uploaded_file($uploaded_file_name, "upload/".$_FILES["image"]["name"]);
    $image_path = "upload/" . $_FILES["image"]["name"];
    $file_type = $_FILES["image"]["type"];
    //
    if( $file_type == "image/png"){
        $src = imagecreatefrompng($image_path);
    }
    else if( $file_type == "image/jpeg"){
        $src = imagecreatefromjpeg($image_path);
    }
    else if( $file_type == "image/gif"){
        $src = imagecreatefromgif($image_path);
    }
    list($width,$height)= getimagesize($image_path);
    $new_width = 60;
    $new_height =($height/$width) * $new_width;

    $tmp = imagecreatetruecolor($new_width,$new_height);
    imagecopyresampled($tmp,$src,0,0,0,0,$new_width,$new_height,$width,$height);
    $thumb_filename = "images/thumbs/" . $_FILES["image"]["name"];
    imagejpeg($tmp, $thumb_filename, 100);
    imagedestroy($src);
    imagedestroy($tmp);
}


$image_form=<<<END_OF_FORM
<img src="$thumb_filename" /><br />
<img src="$image_path" />
<form action="/files.php" method="POST" enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit" name="submit" value="Upload File" />

</form>

END_OF_FORM;

echo $image_form;*/
?>
<?php
include "includes/footer.php";
ob_end_flush();
?>
