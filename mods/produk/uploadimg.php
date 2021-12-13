<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();

/* Getting file name */
$filename = $_FILES['userImage']['name'];
/* Location */
$dir = dirname(__FILE__)."/upload";

$location = $dir."/".$filename;
$uploadOk = 1;
$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

$imageFileType = strtolower($imageFileType);

/* Valid Extensions */
$valid_extensions = array("jpg","jpeg","png");
/* Check file extension */
if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
	echo 'error, file bukan foto/gambar [0]';
	exit();
   	$uploadOk = 0;
}

if (!exif_imagetype($_FILES['userImage']['tmp_name'])) {
	echo 'error, kelihatannya file bukan foto/gambar [ERR1]';
	exit();
}

/* Upload file */
/*if (move_uploaded_file($_FILES['file']['tmp_name'],$location)) {
	echo $location;
} else {
   echo 'error, upload gagal [02]';
   exit();
}*/

//https://github.com/gumlet/php-image-resize
include dirname(__FILE__).'/ImageResize.php';

use \Gumlet\ImageResize;

//$image = new ImageResize();
$image = new ImageResize($_FILES['userImage']['tmp_name']);
$image->resizeToHeight(500);
$image->save($dir.'/h500_'.$filename);

if (is_file($dir.'/h500_'.$filename)) {
	$data = file_get_contents($dir.'/h500_'.$filename);
	$base64 = 'data:image/' . $imageFileType . ';base64,' . base64_encode($data);
	echo $base64;

	@unlink($dir.'/h500_'.$filename);
	exit();
} else {
   echo 'error, upload gagal [02]';
   exit();
}

exit();
$path_hasil = 'http://localhost/testcase/produk/upload/h500_'.$filename;

echo '<img src="http://localhost/testcase/produk/upload/'.$filename.'" />';
echo '<br />';
echo '<img src="'.$path_hasil.'" />';
echo '<br />';
$data = file_get_contents($dir.'/h500_'.$filename);
$base64 = 'data:image/' . $imageFileType . ';base64,' . base64_encode($data);

echo $base64;
echo '<img src="'.$base64.'" />';

exit();

