<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 11/27/2016
 * Time: 10:30 PM
 */

//phpinfo();

$submit = $_POST["submit"];
echo ($_FILES["image"]);
print_r($_FILES["image"]);


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


$form=<<<END_OF_FORM
<img src="$thumb_filename" /><br />
<img src="$image_path" />
<form action="/files.php" method="POST" enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit" name="submit" value="Upload File" />

</form>

END_OF_FORM;

echo $form;
?>