<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "application/php/mysql_cheak.php";

$imgtop = $_POST['hidden_top'];
$imgtop = str_replace('data:image/png;base64,', '', $imgtop);
$imgtop = str_replace(' ', '+', $imgtop);
$data1 = base64_decode($imgtop);
$file_top = "images/temp_t.png";
$file_top_path = $_SERVER['DOCUMENT_ROOT'] . $file_top;
file_put_contents($file_top_path, $data1);

$imgdown = $_POST['hidden_down'];
$imgdown = str_replace('data:image/png;base64,', '', $imgdown);
$imgdown = str_replace(' ', '+', $imgdown);
$data2 = base64_decode($imgdown);
$file_down = "images/temp_d.png";
$file_down_path = $_SERVER['DOCUMENT_ROOT'] . $file_down;
file_put_contents($file_down_path, $data2);

$dest_image = imagecreatetruecolor(640, 480);
imagesavealpha($dest_image, true);
imagealphablending($dest_image, true);
$trans_background = imagecolorallocatealpha($dest_image, 0, 0, 0, 127);
imagefill($dest_image, 0, 0, $trans_background);
$top = imagecreatefrompng($file_top_path);
$down = imagecreatefrompng($file_down_path);
imagecopy($dest_image, $down, 0, 0, 0, 0, 640, 480);
imagecopy($dest_image, $top, 0, 0, 0, 0, 640, 480);
$final = "images/pics/" . mktime() . ".png";
imagepng($dest_image, $_SERVER['DOCUMENT_ROOT'] . $final);
imagedestroy($top);
imagedestroy($down);
imagedestroy($dest_image);
unlink($file_top_path);
unlink($file_down_path);

db_query_insert("`pictures`",
	array("file_path", "uid"),
	array("file_path" => $final, "uid" => $_SESSION["uid"])
);
$rat = db_query_select("*", "pictures", "uid = '".$_SESSION["uid"]."'");
echo json_encode(end($rat));
?>