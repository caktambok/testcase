<?php

if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();

$dataPerPage = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;


$url = WEB_URL.'dashboard';

$tables = apiGet(API_URL.'produk/get-produk.php?page='.$page.'&limit='.$dataPerPage, 'json_to_array');//


$datas  = isset($tables['results']['data']) ? $tables['results']['data'] : array();
$error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
$total  = isset($tables['results']['total']) ? $tables['results']['total'] : 0;

if (!empty($error)) {
    Sessionset('err', 1);
    Sessionset('err_msg', $error);
}

$css_link .= '
';

$js_link .='
';

$title = 'Dashboard - '.WEB_NAME;
$description = 'Dashboard - '.WEB_NAME;
$keywords = 'POS MINI, '.WEB_NAME;

include THEME_DIR.'header.php';
include THEME_DIR.'menu.php';
?>
    <main role="main" class="container">
        <?php
        showError();
        ?>
        <h3>Our Products : </h3>
        <div class="row">
            <?php
                foreach ($datas as $arr)
                {
                    echo '
                        <div class="col-lg-3">
                            <div class="card" style="border: 1px solid forestgreen; border-radius: 1rem;">
                            <div class="card-body">
                                <p><img src="'.API_URL.'/fls/'.$arr['image_name'].'" alt="'.$arr['nama_produk'].'" class="img card-img"></p>
                                <p align="center"><strong>'.strtoupper($arr['nama_produk']).'</strong></p>
                                <p align="center"><strong style="font-size: 20pt; color: forestgreen;">Rp '.number_format($arr['harga_produk']).'</strong></p>
                                <strong style="font-size: 8pt;" class="text-justify">'.$arr['deskripsi_produk'].'</strong>
                                <br>
                                <p align="center"><a href="#" class="btn btn-primary"><span class="la la-shopping-cart"></span> Beli</a></p>
                            </div>
                            </div>
                        </div>
                    ';
                }
            ?>
        </div>
    </main>
<?php
include THEME_DIR.'footer.php';
