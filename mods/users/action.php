<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

cekLogin();

$act = isset($_POST['act']) ? $_POST['act'] : '';

$username = isset($_POST['username']) ? $_POST['username'] : '';
$user_telp = isset($_POST['telp_user']) ? $_POST['telp_user'] : '';

$user_id = isset($_POST['id_user']) ? $_POST['id_user'] : '';
$user_nama = isset($_POST['nama_user']) ? $_POST['nama_user'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';
$user_level = isset($_POST['level_user']) ? $_POST['level_user'] : '';
$user_alamat = isset($_POST['alamat_user']) ? $_POST['alamat_user'] : '';
$status_user = isset($_POST['status_user']) ? $_POST['status_user'] : '';

if($act =='add')
{
    $postdata = array(
        'nama_user'=>$user_nama,
        'username'=>$username,
        'password'=>$password,
        'repassword'=>$repassword,
        'telp_user'=>$user_telp,
        'level_user'=>$user_level,
        'alamat_user'=>$user_alamat,
        'status_user'=>$status_user
    );

    $tables = apiPost(API_URL.'user/insert-user.php', $postdata, 'json_to_array');

    //print_r($tables);
    $error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
    $message  = isset($tables['results']['message']) ? $tables['results']['message'] : '';

    if (!empty($error)) {
        Sessionset('err', 1);
        Sessionset('err_msg', $error);

        Urlredirect('users');
    }

    if (!empty($message)) {
        Sessionset('err', 0);
        Sessionset('err_msg', $message);

        Urlredirect('users');

    }

    Sessionset('err', 1);
    Sessionset('err_msg', 'Invalid response.');

    Urlredirect('users');

}
/*elseif($act =='edit')
{
    if(!empty($user_password) AND !empty($user_repassword))
    {
        if($user_password != $user_repassword)
        {
            Sessionset('err', 1);
            Sessionset('err_msg', "password dan repassword tidak sama");

            Urlredirect('user/edit?id='.$user_id);
        }
        else
        {
            $postdata = array(
                'user_id'=>$user_id,
                'user_nama'=>$user_nama,
                'user_username'=>$user_username,
                'user_email'=>$user_email,
                'user_password'=>$user_password,
                'user_repassword'=>$user_repassword,
                'user_telp'=>$user_telp,
                'user_jabatan'=>$user_jabatan,
                'user_alamat'=>$user_alamat,
                'user_keterangan'=>$user_keterangan,
                'user_aktif'=>$user_aktif
            );
        }
    }
    else
    {
        $postdata = array(
            'user_id'=>$user_id,
            'user_nama'=>$user_nama,
            'user_username'=>$user_username,
            'user_email'=>$user_email,
            'user_telp'=>$user_telp,
            'user_jabatan'=>$user_jabatan,
            'user_alamat'=>$user_alamat,
            'user_keterangan'=>$user_keterangan,
            'user_aktif'=>$user_aktif
        );
    }

    $tables = apiPost(API_URL.'user/update-user.php', $postdata, 'json_to_array');
    $error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
    $message  = isset($tables['results']['message']) ? $tables['results']['message'] : '';

    if (!empty($error)) {
        Sessionset('err', 1);
        Sessionset('err_msg', $error);

        Urlredirect('user/edit?id='.$user_id);
    }

    if (!empty($message)) {
        Sessionset('err', 0);
        Sessionset('err_msg', $message);

        Urlredirect('user?propinsi_id='.$propinsi_id.'&q='.$user_username);
    }

    Sessionset('err', 1);
    Sessionset('err_msg', 'Invalid response.');

    Urlredirect('user/edit?id='.$user_id);
}
elseif($act =='delete')
{
    $postdata = array(
        'user_id'=>$user_id
    );

    $tables = apiPost(API_URL.'user/delete-user.php', $postdata, 'json_to_array');
    $error  = isset($tables['results']['error']) ? $tables['results']['error'] : '';
    $message  = isset($tables['results']['message']) ? $tables['results']['message'] : '';

    if (!empty($error)) {
        Sessionset('err', 1);
        Sessionset('err_msg', $error);

        Urlredirect('user?propinsi_id='.$propinsi_id);
    }

    if (!empty($message)) {
        Sessionset('err', 0);
        Sessionset('err_msg', $message);

        Urlredirect('user?propinsi_id='.$propinsi_id);
    }

    Sessionset('err', 1);
    Sessionset('err_msg', 'Invalid response.');

    Urlredirect('user?propinsi_id='.$propinsi_id);

}*/
?>