<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();

$url = WEB_URL.'kategori';

$add_apiurl = '';
$add_url = '';

$katakunci_txt = '';
if (!empty($q)) {
    $add_apiurl .= '&q='.urlencode($q);
    $add_url .= '&q='.$q;
    $katakunci_txt .= '<p>Kata kunci: <strong>'.$q.'</strong> <a href="'.$url.'" title="reset cari">[x]</a></p>';
}

$dataPerPage = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$q = isset($_GET['q']) ? $_GET['q'] : '';
if ($page < 1) $page = 1;

$url .= $add_url;

$css_link .= '
<link rel="stylesheet" type="text/css" href="'.THEME_DIR_URL.'assets/css/selects/select2.min.css">
<link rel="stylesheet" type="text/css" href="'.THEME_DIR_URL.'assets/css/tables/datatable/datatables.min.css">

';

$js_link .='
<script src="'.THEME_DIR_URL.'assets/js/select/select2.full.min.js"></script>
<script src="'.THEME_DIR_URL.'assets/js/tables/datatable/datatables.min.js"></script>
';

$tables = apiGet(API_URL.'kategori/get-kategori.php?q='.$q.'&page='.$page.'&limit='.$dataPerPage, 'json_to_array');
$datas  = isset($tables['results']['data']) ? $tables['results']['data'] : array();
$error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
$total  = isset($tables['results']['total']) ? $tables['results']['total'] : 0;

if (!empty($error)) {
    Sessionset('err', 1);
    Sessionset('err_msg', $error);
}

$title = 'List Kategori - '.WEB_NAME;
$description = 'List Kategori - '.WEB_NAME;
$keywords = 'List Kategori, '.WEB_NAME;

$js_embed .= '
            function addData() {
                $("#form_manage").modal("show");
        
                $("#titleLabel").html("Tambah Kategori");
                $("#act").val("add");
                $("#id_kategori").val("");
        
                $("#nama_kategori").val("");
                $("#deskripsi_kategori").val("");
            }
                              
            function editData(did) {
        
                $("#titleLabel").html("Edit Kategori");
                $("#act").val("edit");
                $("#id_kategori").val("");
        
                $("#nama_kategori").val("Please wait...");
                $("#deskripsi_kategori").val("Please wait...");
                              
                $.ajax({
                    type: "POST",
                    data: "id_kategori="+did,
                    url: "'.WEB_URL.'kategori/get-single",
                    success: function(e) {
                        try {
                            var data = $.parseJSON(e);
                            $("#id_kategori").val(data.id_kategori);
                            $("#nama_kategori").val(data.nama_kategori);
                            $("#deskripsi_kategori").val(data.deskripsi_kategori);
                        } catch (s) {
                            alert("Gagal saat load data, silahkan ulangi kembali [0].");
                        }
                    },
                    beforeSend: function(e) {
                        $("#form_manage").modal("show");
                    },
                    complete: function(e) {
        
                    },
                    error: function(e, s, a) {
                        alert("Gagal saat load data, silahkan ulangi kembali [1].");
                    }
                })
            }

            function deleteData(did) {
                $("#modal_delete").modal("show");

                $("#id_kategori_delete").val(did);

                var jdl = $("#tr"+did+" .toggle_data").html();
                $("#div_judul_delete").html("<strong>"+jdl+"</strong>");
            }
';

$js_onready .='    
    $("#table_data").DataTable({
        responsive: true,
        "paging":false,
        "bInfo" : false
    });
    
    $(".td_hl").on("click", function(){
        $("#table_data tr").removeClass("bg-warning bg-lighten-2 white");

        $(this).parent().addClass("bg-warning bg-lighten-2 white");
    });
    $(".toggle_data").on("click", function(){
        $("#table_data tr").removeClass("bg-warning bg-lighten-2 white");

        $(this).parent().parent().addClass("bg-warning bg-lighten-2 white");
    });
';
$css_embed .='
.select2-selection.select2-selection--single{
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 40px!important;
    }
    .select2-container--default .select2-selection--single{
        height: 40px!important;
    }
    .select2-selection__arrow{
        height: 40px!important;
    }
';

include THEME_DIR.'header.php';
include THEME_DIR.'menu.php';

?>
    <main role="main" class="container">
        <h3>List Kategori : </h3>
        <?php
        showError();
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button onclick="addData()" class="btn btn-primary mb-1" style="float: right"><i class="la la-plus"></i> Tambah Kategori</button>
                    </div>
                    <div class="card-body card-dashboard">
                        <div class="table-responsive" style="margin-top: 20px;">
                            <table id="table_data" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Deskripsi</th>
                                    <th class="text-center">Entry By</th>
                                    <th class="text-center">::</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = ($page-1)*$dataPerPage;
                                foreach ($datas as $arr) {
                                    $no++;
                                    $id_kategori = $arr['id_kategori'];
                                    $nama_kategori = $arr['nama_kategori'];

                                    echo '
                                         <tr id="tr'.$id_kategori.'" class="tr_data">
                                             <td class="text-center">'.$no.'</td>
                                             <td class="text-center"><p class="toggle_data"><a href="'.WEB_URL.'produk?q='.$nama_kategori.'" target="_blank" class="btn btn-sm btn-outline-primary">'.strtoupper($nama_kategori).'</a></p></td>
                                             <td class="">'.$arr['deskripsi_kategori'].'</td>
                                             <td class="text-center"><strong>'.$arr['nama_user'].'</strong></td>
                                             <td class="text-center">
                                                <div class="btn-group">
                                                     <button onclick="editData(\''.$id_kategori.'\')" class="btn btn-sm btn-warning" title="Edit"><span class="la la-edit"></span></button>
                                                     <button onclick="deleteData(\''.$id_kategori.'\')" class="btn btn-sm btn-danger" title="Hapus"><span class="la la-trash"></span></button>
                                                </div>
                                             </td>
                                         </tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <?php
                        echo paging($url,$total,$dataPerPage,$page);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- form manage -->
    <div class="modal fade" id="form_manage" tabindex="-1" role="dialog" aria-hidden="true">
        <form action="<?php echo WEB_URL; ?>kategori/action" method="post">

            <input type="hidden" name="act" id="act" value="none">
            <input type="hidden" name="id_kategori" id="id_kategori" value="">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="titleLabel">Tambah/Edit Kategori</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Nama Kategori</label>
                                    <input type="text" name="nama_kategori" id="nama_kategori" required class="form-control" placeholder="Nama"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Deskripsi Kategori</label>
                                    <input type="text" name="deskripsi_kategori" id="deskripsi_kategori" required class="form-control" placeholder="Deskrispi">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="la la-save"></i> Simpan</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="la la-times"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- form manage -->

    <!-- Modal delete -->
    <div class="modal fade text-left" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel10"
         aria-hidden="true">
        <form action="<?php echo WEB_URL; ?>kategori/action" method="post">

            <input type="hidden" name="act" value="delete">
            <input type="hidden" name="id_kategori" id="id_kategori_delete" value="">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger white">
                        <h4 class="modal-title white" id="myModalLabel10">Hapus Data!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin akan menghapus data ini?</p>
                        <div id="div_judul_delete"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal delete -->
<?php
include THEME_DIR.'footer.php';
