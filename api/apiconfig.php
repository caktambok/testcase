<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('date.timezone','Asia/Jakarta');
date_default_timezone_set("Asia/Jakarta");

define('PATH_ROOT', dirname(__FILE__));

function strToDigit($str, $jumdigit) {
    $return = $str;

    $str_len = strlen($str);
    if ($str_len < $jumdigit) {
        $return = str_repeat('0', $jumdigit - $str_len).$return;
    }

    return $return;
}
function userLevels() {
    $levels = ['admin','user'];
    return $levels;
}
function getId() {
    return str_replace('.', '', uniqid(rand(1000,9999),true));
}
function azAngka($string) {
    return preg_replace("/[^a-zA-Z0-9]+/", "", trim($string));
}

function errorDesc($errorCode='-', $customMsg='') {
	$arr = array();
	$arr['update_success'] = 'Data berhasil diupdate';
	$arr['insert_success'] = 'Data berhasil disimpan';
	$arr['delete_success'] = 'Data berhasil dihapus';
	$arr['invalid_param'] = 'Parameter salah';
	$arr['not_found'] = 'Data tidak ditemukan';
	if ($errorCode==='custom_msg') $arr[$errorCode] = $customMsg;

	return isset($arr[$errorCode]) ? $arr[$errorCode] : 'error tidak diketahui';
}

function errorResponse($errorCode, $queries, $customMsg='') {
	$arr = array();
	$arr['results'] = array(
	    'error'=>errorDesc($errorCode, $customMsg),
	    'queries'=>$queries,
	);

	echo json_encode($arr);
	exit();
}

function validate_telp($user_telp,$prefix='0') {
    //masuk format +62 ato 082xx
    //return kosong atau format +62
    $user_telp_ori = $user_telp;

    $user_telp = preg_replace("/[^0-9\+]/","",$user_telp);

    if ($user_telp_ori !== $user_telp) return '';

    if (strlen($user_telp)<5 OR strlen($user_telp)>15) return '';
    if (preg_match("/^62./i", $user_telp)) {
        $user_telp = '+'.$user_telp;
    }

    $hp_pref = '';
    if (preg_match("/^\+62./i", $user_telp)) {
        $hp_pref = '62';
    }
    if (preg_match("/^0./i", $user_telp)) {
        $hp_pref = 'nol';
    }
    if (empty ($hp_pref)) {
        return '';
    } else {
        if ($prefix=='62' AND $hp_pref=='nol') {
            $user_telp = preg_replace("/^0/","+62",$user_telp);
        }
        if ($prefix=='0' AND $hp_pref=='62') {
            $user_telp = preg_replace("/^\+62/","0",$user_telp);
        }
    }
    return $user_telp;
}
function validate_email($email) {
    $return = '';
    $email = strtolower($email);
    if(preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email)){
        return $email;
    }else{
        return $return;
    }
}
function dateTimeNow() {
    return date('Y-m-d H:i:s');
}
function isDateValid($date, $format = 'Y-m-d H:i:s') {
    if (empty($date)) return false;
    
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function encodex($user,$pass) {
    //a-b+c-d
    //d-a+b-c

    $user_a = substr($user, 0,10);//a
    $user_b = substr($user, 10);//b
    $user_b_len = strlen($user_b);
    if ($user_b_len < 10) $user_b_len = '0'.$user_b_len;

    $pass_a = substr($pass, 0,10);//c
    $pass_b = substr($pass, 10);//d
    $pass_b_len = strlen($pass_b);
    if ($pass_b_len < 10) $pass_b_len = '0'.$pass_b_len;

    $str = $user_b_len.$pass_b.strrev($user_a).$user_b.strrev($pass_a).$pass_b_len;

    $str_encode = base64_encode($str);
    $str_encode_start = substr($str_encode, 0, 3);
    $str_encode_first = substr($str_encode, 3, 11);
    $str_encode_second = substr($str_encode, 3+11); 

    return strrev($str_encode_start).strrev($str_encode_first).strrev($str_encode_second);
}
function decodex($str_encode) {
    //d-a+b-c
    //a-b+c-d
    $str_encode_start = substr($str_encode, 0, 3);
    $str_encode_first = substr($str_encode, 3, 11);
    $str_encode_second = substr($str_encode, 3+11); 

    $str = strrev($str_encode_start).strrev($str_encode_first).strrev($str_encode_second);

    $str = base64_decode($str);
    $str_len = strlen($str);

    $user_b_len = (int) substr($str, 0,2);
    $pass_b_len = (int) substr($str, $str_len-2,2);

    $pass_b = substr($str, 2, $pass_b_len);
    $user_a = substr($str, $pass_b_len+2, 10);

    $user_b = substr($str, 2+$pass_b_len+10, $user_b_len);
    $pass_a = substr($str, 2+$pass_b_len+10+$user_b_len, 10);

    $str_data = strrev($user_a).$user_b.'|separator|'.strrev($pass_a).$pass_b;

    return $str_data;
}