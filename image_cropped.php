<?php
/**
 * Created by PhpStorm.
 * User: JoshC
 * Date: 3/6/2017
 * Time: 7:49 AM
 */
ob_start();
include "includes/header.php";
include "includes/functions.php";

$db = db_connect();
$cropx = mysqli_real_escape_string($db,$_GET["cropx"]);
$cropy= mysqli_real_escape_string($db,$_GET["cropy"]);
$cropw= mysqli_real_escape_string($db,$_GET["cropw"]);
$croph= mysqli_real_escape_string($db,$_GET["croph"]);
$image = mysqli_real_escape_string($db,$_GET["image"]);


$img_r = imagecreatefromjpeg($image);
$dst_r = ImageCreateTrueColor( $cropw, $croph );

imagecopyresampled($dst_r,$img_r,0,0,$cropx,$cropy,
    $cropw,$croph,$cropw,$croph);
ob_clean();
header('Content-type: image/jpeg');
imagejpeg($dst_r, null, $jpeg_quality);
echo "<img id='image_to_crop' src='$image'>";

include "includes/footer.php";
ob_end_flush();
?>
