<?php
$authenticate = isset($_SERVER['HTTP_WWW_AUTHENTICATE']) ? $_SERVER['HTTP_WWW_AUTHENTICATE'] : '';

if (empty($authenticate) OR strlen($authenticate) < 20) {
	$err_msg = 'Token tidak valid [0].';
	errorResponse('custom_msg', $queries, $err_msg);
}

$authenticate_dec = decodex($authenticate);
//$str_data = strrev($user_a).$user_b.'|separator|'.strrev($pass_a).$pass_b;
$exp_auth = explode('|separator|', $authenticate_dec);

$user_auth_id = $exp_auth[0];
$user_auth_password = $exp_auth[1];

$user_token_assoc = $db->row('select * from t_users
            where id_user=\''.$user_auth_id.'\'
            AND password=\''.$user_auth_password.'\' AND status_user=\'aktif\'
            ');

if (empty($user_token_assoc['id_user'])) {
    $err_msg = 'Who are you? [1].';
    $err_msg .= $authenticate.' => '.$authenticate_dec;
    errorResponse('custom_msg', $queries, $err_msg);
}

$user_auth_level = $user_token_assoc['level_user'];
