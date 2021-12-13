<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();

$act = isset($_POST['act']) ? $_POST['act'] : '';

$id_kategori = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : '';
$nama_kategori = isset($_POST['nama_kategori']) ? $_POST['nama_kategori'] : '';

$deskripsi_kategori = isset($_POST['deskripsi_kategori']) ? $_POST['deskripsi_kategori'] : '';

$error = $message = '';

switch ($act) {
    case 'add':
        $postdata = array(
            'nama_kategori'=>$nama_kategori,
            'deskripsi_kategori'=>$deskripsi_kategori,
        );

        $tables = apiPost(API_URL.'kategori/insert-kategori.php', $postdata, 'json_to_array');
        $error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
        $message  = isset($tables['results']['message']) ? $tables['results']['message'] : '';
        break;

    case 'edit':
        $postdata = array(
            'id_kategori'=>$id_kategori,
            'nama_kategori'=>$nama_kategori,
            'deskripsi_kategori'=>$deskripsi_kategori
        );

        $tables = apiPost(API_URL.'kategori/update-kategori.php', $postdata, 'json_to_array');
        $error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
        $message  = isset($tables['results']['message']) ? $tables['results']['message'] : '';
        break;

    case 'delete':
        $postdata = array(
            'id_kategori'=>$id_kategori
        );

        $tables = apiPost(API_URL.'kategori/delete-kategori.php', $postdata, 'json_to_array');
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

    Urlredirect('kategori');
}

if (!empty($message)) {
    Sessionset('err', 0);
    Sessionset('err_msg', $message);

    Urlredirect('kategori');

}

Sessionset('err', 1);
Sessionset('err_msg', 'Invalid response.');

Urlredirect('kategori');