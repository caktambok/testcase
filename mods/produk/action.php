<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();

$act = isset($_POST['act']) ? $_POST['act'] : '';

$id_produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : '';
$id_kategori = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : '';
$nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';

$deskripsi_produk = isset($_POST['deskripsi_produk']) ? $_POST['deskripsi_produk'] : '';
$harga_produk = isset($_POST['harga_produk']) ? $_POST['harga_produk'] : '';
$image_produk = isset($_FILES['image_produk']) ? $_FILES['image_produk'] : '';

$update_image='N';
$imageData='';
$image_name='';
$image_tmp='';
$image_type='';

if($image_produk['error']==0)
{
    $imageData = base64_encode(file_get_contents($image_produk['tmp_name']));
    $image_tmp = $image_produk['tmp_name'];
    $image_name = $image_produk['name'];
    $image_type = $image_produk['type'];

    $update_image ='Y';
}

$error = $message = '';

switch ($act) {
    case 'add':
        $postdata = array(
            'image_name'=>$image_name,
            'image_produk'=>$imageData,
            'image_tmp'=>$image_tmp,
            'image_type'=>$image_type,
            'deskripsi_produk'=>$deskripsi_produk,
            'harga_produk'=>$harga_produk,
            'nama_produk'=>$nama_produk,
            'id_kategori'=>$id_kategori
        );

        $tables = apiPost(API_URL.'produk/insert-produk.php', $postdata, 'json_to_array');
        $error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
        $message  = isset($tables['results']['message']) ? $tables['results']['message'] : '';
        break;

    case 'edit':
        $postdata = array(
            'id_produk'=>$id_produk,
            'image_name'=>$image_name,
            'image_produk'=>$imageData,
            'image_tmp'=>$image_tmp,
            'image_type'=>$image_type,
            'update_image'=>$update_image,
            'deskripsi_produk'=>$deskripsi_produk,
            'harga_produk'=>$harga_produk,
            'nama_produk'=>$nama_produk,
            'id_kategori'=>$id_kategori
        );

        $tables = apiPost(API_URL.'produk/update-produk.php', $postdata, 'json_to_array');
        $error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
        $message  = isset($tables['results']['message']) ? $tables['results']['message'] : '';
        break;

    case 'delete':
        $postdata = array(
            'id_produk'=>$id_produk
        );

        $tables = apiPost(API_URL.'produk/delete-produk.php', $postdata, 'json_to_array');
        $error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
        $message  = isset($tables['results']['message']) ? $tables['results']['message'] : '';
        break;

    default:
        $error = 'Perintah tidak diketahui.';
        break;
}

if (!empty($error)) {
    Sessionset('err', 1);
    Sessionset('err_msg', $error);

    Urlredirect('produk');
}

if (!empty($message)) {
    Sessionset('err', 0);
    Sessionset('err_msg', $message);

    Urlredirect('produk');

}

Sessionset('err', 1);
Sessionset('err_msg', 'Invalid response.');

Urlredirect('produk');

/*$postdata = array(
    'images_P'=>$image_produk,
    'id_produk'=>$id_produk,
    'image_name'=>$image_name,
    'image_produk'=>$imageData,
    'image_tmp'=>$image_tmp,
    'image_type'=>$image_type,
    'update_image'=>$update_image,
    'deskripsi_produk'=>$deskripsi_produk,
    'harga_produk'=>$harga_produk,
    'nama_produk'=>$nama_produk,
    'id_kategori'=>$id_kategori
);*/

//$tables = apiPost(API_URL.'produk/insert-product.php', $postdata,'json_to_array');
//$src = 'data:'.mime_content_type($image_produk['tmp_name']).';base64,'.$imageData;

// tampil gambar
/*echo '<img src="',$src,'">';*/

//print_r($postdata);

