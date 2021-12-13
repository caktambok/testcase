<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();
$postdata = array(
    'id_kategori'=>$_POST['id_kategori']
);
$tables = apiPost(API_URL.'kategori/get-kategori-single.php', $postdata, 'json_to_array');
$datas  = isset($tables['results']['data']) ? $tables['results']['data'] : array();

echo json_encode($datas);