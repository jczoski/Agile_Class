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

$db = db_connect();
$id = mysqli_real_escape_string($db, $_GET["id"]);
$submit = mysqli_real_escape_string($db, $_POST["submit"]);
$submit_pic = $_POST["submit_pic"];
$username = $_SESSION["username"];
$submit_text = $_POST["submit_text"];
//$text_size = $_POST["text_size"];
$text_size = $_POST["preferred_size"] == "" ? $_SESSION['text_size'] : $_POST["preferred_size"];
$submit_profile = $_POST["submit_profile"];
$f_name = $_POST["firstname"];
$l_name = $_POST["lastname"];
$email = $_POST["email"];
$advanced_user_check = isset($_POST["advanced_user"]) ? TRUE : FALSE;


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
if (empty($submit_profile)) {
    $sql = "SELECT * from users WHERE user_name='$username'";
    $result = $db->query($sql);
    list($user_id, $f_name, $l_name, $username, $password, $email, $advanced, $image, $image_thumbmail, $text_size) = $result->fetch_row();
} else {

    $error = "";
    if (empty($f_name) && $submit_profile) {
        $error = "First Name is required";
    }
    if (empty($l_name) && $submit_profile) {
        $error .= "<br>Last Name is required";
    }
    if (empty($email) && $submit_profile) {
        $error .= "<br>Email is required";
    }
    if (($submit_profile) && (empty($error))) {
        if (empty($advanced_user_check)) {
            $advanced_user_check = 0;
        }
        $sql = "UPDATE users SET f_name='$f_name',l_name='$l_name',email='$email',advanced=$advanced_user_check WHERE user_name='$username'";
        $result = $db->query($sql);
        ob_clean();
        if ($advanced_user_check == 0) {
            header("Location: /profile.php");
        } else {
            header("Location: /advanced_application.php");
        }


    }
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
$big_image = $_SESSION["large_profile_pic"];

echo "<img id='image_to_crop' src='$big_image'>";
$image_crop_form =<<<IMAGE_CROP_FORM
<form action="image_cropped.php" id="image_crop_form">
  <input type="hidden" name="cropx" id="cropx" value="0" />
  <input type="hidden" name="cropy" id="cropy" value="0" />
  <input type="hidden" name="cropw" id="cropw" value="0" />
  <input type="hidden" name="croph" id="croph" value="0" />
  <input type="hidden" name="image" id="image" value=$big_image>
  <input type="submit" value="Save Coordinates" />
</form>
IMAGE_CROP_FORM;
echo $image_crop_form;


$profile_form = <<<END_OF_FORM
    <br />
    <div class="table-style aqua-text center_this">
    $error
    <form method="POST" action="/profile_edit.php">
        <label for="firstname">First Name: </label>
        <input type="text" name="firstname" value="$f_name"/><br/>
        <label for="lastname">Last Name: </label>
        <input type="text" name="lastname" value="$l_name"/><br/>
        <label for="email">Email: </label>
        <input type="email" name="email" value="$email"/><br/>
        <label for="advanced_user">Advanced User</label>
        <input type="checkbox" name="advanced_user" id="advanced_user" value="$advanced_user_check"><br />
        <input type="submit" name="submit_profile" value="Submit Profile Changes"/><br/>
    </form><br/>
</div>
END_OF_FORM;


echo $profile_form;
echo "<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>";
echo "<script src='http://jcrop-cdn.tapmodo.com/v0.9.12/js/jquery.Jcrop.min.js'></script>";
echo "<link rel='stylesheet' href='http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.css' type='text/css'>";
echo "<script src='scripts/slider.js'></script>";
echo "<script src='scripts/crop_it.js'></script>";
include "includes/footer.php";
ob_end_flush();
?>
