<?php

if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();

$dataPerPage = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;


$url = WEB_URL.'users';

/*$tables = apiGet(API_URL.'produk/get-produk.php?page='.$page.'&limit='.$dataPerPage, 'json_to_array');//


$datas  = isset($tables['results']['data']) ? $tables['results']['data'] : array();
$error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
$total  = isset($tables['results']['total']) ? $tables['results']['total'] : 0;

if (!empty($error)) {
    Sessionset('err', 1);
    Sessionset('err_msg', $error);
}*/

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
<div class="container">
    <div class="row jumbotron">
        <?php
        showError();
        ?>
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <form action="<?php echo WEB_URL; ?>users/action" method="post">
                <input type="hidden" name="act" value="add">
                <div class="card">
                    <div class="card-header"><h4>Form Tambah User</h4></div>
                    <div class="card-body">
                        <h4>Data Diri</h4>
                        <hr>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="nama_user" placeholder="Nama" aria-label="Nama User" required>
                            <div class="input-group-append">
                                <span class="input-group-text">*</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="alamat_user" id="" cols="30" rows="10" class="form-control">Alamat</textarea>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="telp_user" placeholder="Telp" aria-label="Telp User" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><span class="la la-phone"></span></span>
                            </div>
                        </div>
                        <h4>Data Login</h4>
                        <hr>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Username" aria-label="username" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><span class="la la-user"></span></span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" aria-label="password" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><span class="la la-lock"></span></span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="repassword" placeholder="Re-Password" aria-label="Re password" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><span class="la la-lock"></span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <select name="status_user" id="" class="form-control">
                                <option value="aktif" selected>Status Aktif</option>
                                <option value="nonaktif" >Non Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="level_user" id="" class="form-control">
                                <option value="admin" selected>Level Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">Submit <span class="la la-save"></span></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>
<?php
include THEME_DIR.'footer.php';
