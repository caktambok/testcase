<?php
function warningSubmit() {
    return '
    <div class="mb-0 px-1 py-1 bg-warning text-white font-small-3">
        <strong>Warning!</strong><br />Sebelum submit, pastikan data di atas sudah benar. Aksi ini tidak dapat diundo, diedit, dihapus, atau dikembalikan.
        <br /><br />
        Saat pemrosesan data, tunggu proses loading sampai selesai.
    </div>
    ';
}

function getId() {
    return str_replace('.', '', uniqid(rand(100,999),true));
}
function segments() {
    if (IS_LOCALHOST) {
        $full_url = WEB_PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    } else {
        $full_url = WEB_URL.$_SERVER['REQUEST_URI'];
        if (stripos($full_url, $_SERVER['HTTP_HOST'].'/testcase//')!==false) {
            $full_url = str_ireplace($_SERVER['HTTP_HOST'].'/testcase//', $_SERVER['HTTP_HOST'].'/', $full_url);
        }
    }
    
    //echo $full_url;

    $posget = strpos($full_url, '?');
    if ($posget !== false) $full_url = substr($full_url, 0,$posget);

    $str_path = str_ireplace(WEB_URL, '', $full_url);

    return explode('/', $str_path);
}


function printr($array=array()) {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
function dateTimeNow() {
    return date('Y-m-d H:i:s');
}

function qFilter($q) {    
    $q = str_replace(array('&','#','"', "'",'?'), '', $q);
    $q = strip_tags($q);
    return trim($q);
}

function paging($url,$totData,$dataPerPage,$pg,$ul_class='') {
    $last='';
    //if (empty($ul_class)) $ul_class = 'justify-content-center';

    $sep = (strpos($url,'?')!==false) ? '&' : '?';
    if(empty($totData)) { $totData = 1; }
    if(empty($dataPerPage)) { $dataPerPage = 10; }
    if($pg < 1) $pg = 1;

    if ($totData <= $dataPerPage) return '';

    $totPage = ceil($totData/$dataPerPage);

    if ($totPage <= 1) return '';

    if ($pg > $totPage) return '';//$pg = $totPage;

    if($pg > 1) {
        $pageprev = $pg - 1;
        $prev = '<li class="page-item"><a href="'.$url.$sep.'page='.$pageprev.'" class="page-link" aria-label="Previous">
            <span aria-hidden="true">&laquo; Prev</span>
            <span class="sr-only">Previous</span>
        </a></li>';
    }else{
        $prev = '<li class="page-item disabled"><a href="javascript:void(0);" class="page-link" aria-label="Previous">
            <span aria-hidden="true">&laquo; Prev</span>
            <span class="sr-only">Previous</span>
        </a></li>';
    }

    if($pg < $totPage) {
        $pagenext = $pg + 1;
        $next = '<li class="page-item"><a href="'.$url.$sep.'page='.$pagenext.'" class="page-link" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
            <span class="sr-only">Next</span>
        </a></li>';
    }else{
        $next = '<li class="page-item disabled"><a href="javascript:void(0);" class="page-link" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
            <span class="sr-only">Next</span>
        </a></li>';
    }
    //tambah first
    if($pg != 1)
    {
        $pagefirst = 1;
        $first = '<li class="page-item"><a href="'.$url.$sep.'page='.$pagefirst.'" class="page-link" aria-label="First">
            <span aria-hidden="true">&laquo; First</span>
            <span class="sr-only">First</span>
        </a></li>';
    }
    else
    {
        $first ='';
    }

    //tambah last
    if($pg != $totPage)
    {
        $pagelast = $totPage;
        $last   = '<li class="page-item"><a href="'.$url.$sep.'page='.$pagelast.'" class="page-link" aria-label="Last">
            <span aria-hidden="true">Last &raquo;</span>
            <span class="sr-only">Last</span>
        </a></li>';
    }
    // pagination-sm no-margin pull-right  pagination-lg /  pagination-sm
    $txt = '<ul class="pagination flex-wrap '.$ul_class.'" id="halaman">'.$first.''.$prev;


    $showPage = 0;
    for ($i=1;$i<=$totPage;$i++){
        if($i == 1)
        {
            if ($i == $pg) {
                $sesudah = $i+1;
                $sesudahlagi = $i+2;
                $txt .= '<li class="page-item active"><a href="javascript:void(0);" class="page-link">'.$i.'</a></li>';
                if($sesudah <= $totPage)
                {
                    $txt .= '<li class="page-item"><a href="'.$url.$sep.'page='.$sesudah.'" class="page-link">'.$sesudah.'</a></li>';
                }
                elseif ($sesudahlagi <= $totPage)
                {
                    $txt .= '<li class="page-item"><a href="'.$url.$sep.'page='.$sesudahlagi.'" class="page-link">'.$sesudahlagi.'</a></li>';
                }
            }
        }
        else
        {
            if ($i == $pg) {
                $sesudah = $i+1;
                $sebelum = $i-1;
                if($sebelum != 0)
                {
                    $txt .= '<li class="page-item"><a href="'.$url.$sep.'page='.$sebelum.'" class="page-link">'.$sebelum.'</a></li>';

                }
                $txt .= '<li class="page-item active"><a href="javascript:void(0);" class="page-link">'.$i.'</a></li>';
                if($sesudah <= $totPage)
                {
                    $txt .= '<li class="page-item"><a href="'.$url.$sep.'page='.$sesudah.'" class="page-link">'.$sesudah.'</a></li>';
                }
            }
        }
        /*if ($i == $pg) {
            $sebelum = $i-1;
            $sesudah = $i+1;
            $txt .= '<li class="page-item"><a href="'.$url.$sep.'page='.$sebelum.'" class="page-link">'.$sebelum.'</a></li>';
            $txt .= '<li class="page-item active"><a href="javascript:void(0);" class="page-link">'.$i.'</a></li>';
            $txt .= '<li class="page-item"><a href="'.$url.$sep.'page='.$sesudah.'" class="page-link">'.$sesudah.'</a></li>';
        }*/ /*else {
            $txt .= '<li class="page-item"><a href="'.$url.$sep.'page='.$i.'" class="page-link">'.$i.'</a></li>';
        }*/
        $showPage = $i;

    }
    $txt .= $next.''.$last.'</ul>';


    return $txt;

}

function Sessionset($session_name,$session_value) {
    $_SESSION[$session_name] = $session_value;
}
function Sessionget($session_name,$session_value_default='') {
    return (isset($_SESSION[$session_name])) ? $_SESSION[$session_name] : $session_value_default;
}
function Urlredirect($path='') {
    header('location:'.WEB_URL.$path);
    exit();
}
function showError() {
    $err_msg = Sessionget('err_msg');
    if (!empty($err_msg)) {
    
        $err = Sessionget('err');
        $err_class = ($err==1) ? 'alert-danger' : 'alert-success';
        unset($_SESSION['err']);
        unset($_SESSION['err_msg']);

        echo '
        <div class="alert '.$err_class.' alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div>'.$err_msg.'</div>
        </div>
        ';
    }
}

function cekLogin() {
    $is_login = Sessionget('is_login');
    $id_user = Sessionget('id_user');

    if (empty($is_login) OR empty($id_user)) {
        Sessionset('err',0);
        Sessionset('err_msg','Anda belum login atau session sudah kadaluarsa<br />Silahkan melakukan login kembali.');
        Urlredirect('login');
    }
}

function apiGet($url, $return_mode='', $opts = array()) {

    $cached = isset($opts['cached']) ? $opts['cached'] : false;

    if ($cached) {
        $urlenc = md5($url);
        $file_cached = PATH_ROOT.'/cached/'.$urlenc.'.txt';
        $file_cached_meta = PATH_ROOT.'/cached/'.$urlenc.'_meta.txt';

        if (is_file($file_cached)) {
            $results = @file_get_contents($file_cached);

            if ($return_mode==='json_to_array') {
                $array = json_decode($results, true);
                if (json_last_error() !== JSON_ERROR_NONE) {

                    $arr = array();
                    $arr['results'] = array(
                        'error'=>'Invalid JSON, '.$http_status.' '.$curl_error.' '.$results,
                    );
                    return $arr;
                }
                return $array;
            }

            return $results;
        }
    }

    $headers = array();
    $headers[] = 'WWW-Authenticate: '.Sessionget("auth_token");
    $headers[] = 'Connection: keep-alive';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

    $results = curl_exec ($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close ($ch);

    if ($cached AND empty($curl_error) AND $http_status==200) {
        $meta = array('url'=>$url,'dt'=>date('Y-m-d H:i:s'));
        @file_put_contents($file_cached, $results);
        @file_put_contents($file_cached_meta, json_encode($meta));
    }

    if ($return_mode==='json_to_array') {
        $array = json_decode($results, true);
        if (json_last_error() !== JSON_ERROR_NONE) {

            $arr = array();
            $arr['results'] = array(
                'error'=>'Invalid JSON, '.$http_status.' '.$curl_error.' '.$results,
            );
            return $arr;
        }
        return $array;
    }

    return $results;
}

function apiPost($url, $postdata, $return_mode='') {

    $headers = array();
    $headers[] = 'WWW-Authenticate: '.Sessionget("auth_token");
    $headers[] = 'Connection: keep-alive';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($postdata,'','&'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

    $results = curl_exec ($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close ($ch);

    if ($return_mode==='json_to_array') {
        $array = json_decode($results, true);
        if (json_last_error() !== JSON_ERROR_NONE) {

            $arr = array();
            $arr['results'] = array(
                'error'=>'Invalid JSON, '.$http_status.' '.$curl_error.' '.$results,
            );
            return $arr;
        }
        return $array;
    }

    return $results;
}
function apiPost2($url, $fk, $lk, $files, $postdata, $return_mode='') {
    $boundary = getId();
    $delimiter = '-------------' . $boundary;

    $post_data = build_data_files($boundary, $postdata, $files);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, $boundary.'.txt');
    $headers = array();
    $headers[] = 'WWW-Authenticate: '.Sessionget("auth_token");
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Content-Type:multipart/form-data; boundary='.$delimiter;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($ch, CURLOPT_UPLOAD, 1);
    curl_setopt($ch, CURLOPT_INFILE, $fk);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
    curl_setopt($ch, CURLOPT_NOPROGRESS, false);
    curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'CURL_callback');
    curl_setopt($ch, CURLOPT_BUFFERSIZE, 128);
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($lk));

    $results = curl_exec ($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close ($ch);

    if ($return_mode==='json_to_array') {
        $array = json_decode($results, true);
        if (json_last_error() !== JSON_ERROR_NONE) {

            $arr = array();
            $arr['results'] = array(
                'error'=>'Invalid JSON, '.$http_status.' '.$curl_error.' '.$results,
            );
            return $arr;
        }
        return $array;
    }

    return $results;
}