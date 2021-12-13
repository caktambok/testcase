<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();
$postdata = array(
    'id_produk'=>$_POST['id_produk']
);
$tables = apiPost(API_URL.'produk/get-produk-single.php', $postdata, 'json_to_array');
$datas  = isset($tables['results']['data']) ? $tables['results']['data'] : array();

echo json_encode($datas);