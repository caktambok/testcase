<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';

$tables = apiGet(API_URL.'kategori/get-kategori-cari.php?q='.$search, 'json_to_array');

$datas = $tables['results']['data'];
$list = array();
foreach($datas as $n => $data)
{
    $list[$n]['id']=$data['id_kategori'];
    $list[$n]['text']=strtoupper($data['nama_kategori']);
}
echo json_encode($list);
