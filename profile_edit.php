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
$id =  mysqli_real_escape_string($db,$_GET["id"]);
$submit = mysqli_real_escape_string($db,$_POST["submit"]);
$submit_pic= $_POST["submit_pic"];
$username = $_SESSION["username"];
$submit_text = $_POST["submit_text"];
$text_size = $_POST["text_size"];

if($submit_text){
    $sql = "UPDATE users SET text_size=$text_size
WHERE user_name='$username'";
    $result = $db->query($sql);
    $_SESSION['text_size'] = $text_size;
    ob_clean();
    header("Location: /profile_edit.php");
}

if($submit_pic){
    $uploaded_file_name = $_FILES["image"]["tmp_name"];
    move_uploaded_file($uploaded_file_name, "upload/".$_FILES["image"]["name"]);
    $image_path = "upload/" . $_FILES["image"]["name"];
    $file_type = $_FILES["image"]["type"];

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
    $sql = "UPDATE users SET image='$image_path',image_thumbnail='$thumb_filename'
WHERE user_name='$username'";

    $result = $db->query($sql);
}

$text_size_form=<<<TEXT_SETTING
<form action="/profile_edit.php" method="POST" style="color:white;">
<label for="text_size">Text Size Preference:</label><br>
<input name="text_size" value="1" type="radio">smallest<br>
<input name="text_size" value="2" type="radio">small<br>
<input name="text_size" value="3" type="radio">normal<br>
<input name="text_size" value="4" type="radio">larger<br>
<input name="text_size" value="5" type="radio">largest<br>
<input type="submit" name="submit_text" value="Update Text Size" />
</form>
TEXT_SETTING;

echo $text_size_form;

$image_form=<<<END_OF_FORM
<img src="$thumb_filename" /><br />
<form action="/profile_edit.php" method="POST" enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit" name="submit_pic" value="Update Image" />

</form>

END_OF_FORM;

echo $image_form;

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