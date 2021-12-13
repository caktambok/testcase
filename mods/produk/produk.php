<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();

$url = WEB_URL.'produk';

$add_apiurl = '';
$add_url = '';

$katakunci_txt = '';
if (!empty($q)) {
    $add_apiurl .= '&q='.urlencode($q);
    $add_url .= '&q='.$q;
    $katakunci_txt .= '<p>Kata kunci: <strong>'.$q.'</strong> <a href="'.$url.'" title="reset cari">[x]</a></p>';
}

$dataPerPage = 10;
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
<script src="'.THEME_DIR_URL.'assets/plugin/ckeditor/ckeditor.js"></script>
<script src="'.THEME_DIR_URL.'assets/plugin/ckeditor/adapters/jquery.js"></script>
';

$tables = apiGet(API_URL.'produk/get-produk.php?q='.$q.'&page='.$page.'&limit='.$dataPerPage, 'json_to_array');
$datas  = isset($tables['results']['data']) ? $tables['results']['data'] : array();
$error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
$total  = isset($tables['results']['total']) ? $tables['results']['total'] : 0;

if (!empty($error)) {
    Sessionset('err', 1);
    Sessionset('err_msg', $error);
}

$title = 'List Produk - '.WEB_NAME;
$description = 'List Produk - '.WEB_NAME;
$keywords = 'List Produk, '.WEB_NAME;

$js_embed .= '                  
            function editData(did) {
        
                $("#titleLabel").html("Edit Produk");
                $("#act").val("edit");
                $("#id_produk").val("");
        
                $("#nama_produk").val("Please wait...");
                $("#deskripsi_produk").val("Please wait...");
                $("#harga_produk").val("Please wait...");
                $("#id_kategori").val("Please wait...");
               
                $.ajax({
                    type: "POST",
                    data: "id_produk="+did,
                    url: "'.WEB_URL.'produk/get-single",
                    success: function(e) {
                        try {
                            var data = $.parseJSON(e);
                            $("#id_produk").val(data.id_produk);
                            $("#nama_produk").val(data.nama_produk);
                            CKEDITOR.instances["deskripsi_produk"].setData(data.deskripsi_produk);
                            $("#harga_produk").val(data.harga_produk);
                            $("#id_kategori").val(data.id_kategori).change();
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

                $("#id_produk_delete").val(did);

                var jdl = $("#tr"+did+" .toggle_data").html();
                $("#div_judul_delete").html("<strong>"+jdl+"</strong>");
            }
       
            function showPreview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#targetLayer").html(\'<img src="\'+e.target.result+\'" class="upload-preview" />\');
                        $("#targetLayer").css(\'opacity\',\'0.7\');
                        $(".icon-choose-image").css(\'opacity\',\'0.5\');
                    }
                    reader.readAsDataURL(input.files[0]);
            
                    uploadImg(input);
                }
            }
            
            function uploadImg(input) {
            
                $("#baseencodedimg").html("");
                $("#div_err_upload").addClass("hidden").html("");
            
                var fd = new FormData();
                var files = input.files[0];
                fd.append("file",files);
            
                $.ajax({
                    url: "'.$url.'/uploadimg",
                    type: "POST",
                    data:  fd,
                    contentType: false,
                    processData:false,
                    success: function(data) {
                        //alert(data);
            
                        hideLoading();
            
                        var res = data.substr(0, 4);
                        if (res == "data") {
                            //OKE
                            $("#div_err_upload").addClass("hidden").html("");
            
                            $("#baseencodedimg").html(data);
                        } else {
                            $("#div_err_upload").removeClass("hidden").html(data);
                        }
            
                        //alert(res);
                        //alert($("#baseencodedimg").html());
            
                        //$("#targetLayer").css(\'opacity\',\'1\');
                    },
                    beforeSend: function(){
                        showLoading();
                    },
                    error: function() {
                        hideLoading();
                        alert("Gagal saat upload gambar, silahkan ulangi kembali.");
                    }           
               });
            }
';
//    $("#id_kategori").select2();
$js_onready .='
    $(".select2_prop").select2();
    
    $("#id_kategori_cari").select2({
        minimumInputLength: 1,
        allowClear: true,
        placeholder: "Cari Kategori",
        ajax: {
            dataType: "json",
            url: "'.WEB_URL.'produk/get-kategori",
            delay: 100,
            data: function(params) {
                return {
                    search: params.term
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            }
        }
    });
        
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
    
    $(\'input[type="file"]\').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#image_produk").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
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
    
    .items {
    width: 90%;
    margin: 0px auto;
    margin-top: 10px
}

.hidden{
    display : none;
}
.bgColor {
    max-width: 350px;
    background-color: #c3e8cb;
    padding: 20px;
    border-radius: 4px;
    text-align: center;
}
#targetOuter{
    position:relative;
    text-align: center;
    background-color: #F0E8E0;
    margin: 20px auto;
    width: 200px;
    height: 200px;
    border-radius: 4px;
}
.btnSubmit {
    background-color: #565656;
    border-radius: 4px;
    padding: 10px;
    border: #333 1px solid;
    color: #FFFFFF;
    width: 200px;
    cursor:pointer;
}
.inputFile {
    padding: 5px 0px;
    margin-top:8px;
    background-color: #FFFFFF;
    width: 48px;
    overflow: hidden;
    opacity: 0;
    cursor:pointer;
}
.icon-choose-image {
    position: absolute;
    opacity: 0.1;
    top: 50%;
    left: 50%;
    margin-top: -24px;
    margin-left: -24px;
    width: 48px;
    height: 48px;
}
.upload-preview {border-radius:4px;width:200px;height:200px;}
#body-overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left: 0;top: 0;width: 100%;height: 100%;display: none;}
#body-overlay div {position:absolute;left:50%;top:50%;margin-top:-32px;margin-left:-32px;}
';

include THEME_DIR.'header.php';
include THEME_DIR.'menu.php';

?>
    <main role="main" class="container">
        <h3>List Products : </h3>
        <?php
        showError();
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary mb-1" style="float: right" data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="Tambah Produk"><i class="la la-plus"></i> Tambah Produk</button>
                    </div>
                    <div class="card-body card-dashboard">
                        <div class="collapse" id="collapseForm">
                            <div class="card card-body">
                                <form action="<?php echo $url.'/action';?>" method="post" enctype="multipart/form-data" ">
                                    <input type="hidden" name="act" value="add">
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="input-group mb-3">
                                                <input type="text" name="nama_produk" required class="form-control" placeholder="Nama Produk"/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><span class="la la-tag"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="form-group">
                                                <textarea name="deskripsi_produk" class="ckeditor">Deskripsi Produk</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <small class="text-muted"><i>Upload Image</i></small>

                                            <div id="demo-content">
                                                <div id="body-overlay"><div><img src="loading.gif" width="64px" height="64px"></div></div>
                                                <div class="bgColor">
                                                    <div id="uploadForm">
                                                        <div id="targetOuter">
                                                            <div id="targetLayer"></div>
                                                            <img src="<?php echo WEB_URL; ?>libs/photo.png" class="icon-choose-image">
                                                            <div class="icon-choose-image">
                                                                <input name="image_produk" type="file" class="inputFile" onchange="showPreview(this);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row" style="margin-top: 10px;">
                                                <div class="col-lg">
                                                    <div class="form-group">
                                                        <select name="id_kategori" id="id_kategori_cari" class="form-control" style="width: 100%">
                                                            <option value="">Kategori</option>
                                                            <option value="">Kategori</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="harga_produk" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><span><strong>IDR</strong></span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 10px;"><span class="la la-save"></span> Simpan</button>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive" style="margin-top: 20px;">
                            <table id="table_data" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Produk</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Entry By</th>
                                    <th class="text-center">::</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = ($page-1)*$dataPerPage;
                                foreach ($datas as $arr) {
                                    $no++;
                                    $id_produk = $arr['id_produk'];
                                    $image_name = $arr['image_name'];

                                    echo '
                                         <tr id="tr'.$id_produk.'" class="tr_data">
                                             <td class="text-center">'.$no.'</td>
                                             <td class="text-center"><img src="'.API_URL.'/fls/'.$image_name.'" class="img img-thumbnail"><p class="toggle_data">'.$arr['nama_produk'].'</p></td>
                                             <td class="text-center"><strong>Rp. '.number_format($arr['harga_produk']).'</strong></td>
                                             <td class="text-center"><strong>'.strtoupper($arr['nama_kategori']).'</strong></td>
                                             <td class="text-center"><strong>'.$arr['nama_user'].'</strong></td>
                                             <td class="text-center">
                                                <div class="btn-group">
                                                     <button onclick="editData(\''.$id_produk.'\')" class="btn btn-sm btn-warning"><span class="la la-edit"></span></button>
                                                     <button onclick="deleteData(\''.$id_produk.'\')" class="btn btn-sm btn-danger"><span class="la la-trash"></span></button>
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
        <form action="<?php echo WEB_URL; ?>produk/action" enctype="multipart/form-data" method="post">

            <input type="hidden" name="act" id="act" value="none">
            <input type="hidden" name="id_produk" id="id_produk" value="">
            <?php
            $tables_kategori = apiGet(API_URL.'kategori/get-kategori.php', 'json_to_array');
            $datas_kategori  = isset($tables_kategori['results']['data']) ? $tables_kategori['results']['data'] : array();
            ?>

            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="titleLabel">Tambah/Edit Produk</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Nama Produk</label>
                                    <input type="text" name="nama_produk" id="nama_produk" required class="form-control" placeholder="Nama Produk"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Deskripsi Produk</label>
                                    <textarea name="deskripsi_produk" id="deskripsi_produk" class="ckeditor"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Kategori Produk</label>
                                    <select name="id_kategori" id="id_kategori" class="form-control select2_prop" style="width: 100%">
                                        <?php
                                        foreach($datas_kategori as $dk => $data_kategori)
                                        {
                                            echo '<option value="'.$data_kategori['id_kategori'].'" >'.strtoupper($data_kategori['nama_kategori']).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Harga Produk</label>
                                    <input type="number" class="form-control" name="harga_produk" id="harga_produk" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image_produk" id="image_produk" class="form-control" placeholder="Image Produk"/>
                                    <em>*Input jika ingin merubah</em>
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
        <form action="<?php echo WEB_URL; ?>produk/action" method="post">

            <input type="hidden" name="act" value="delete">
            <input type="hidden" name="id_produk" id="id_produk_delete" value="">

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
