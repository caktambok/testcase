<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_name('testcase');
session_start();

$session_id = session_id();

ini_set('date.timezone','Asia/Jakarta');
date_default_timezone_set("Asia/Jakarta");


define('IS_LOCALHOST', false);

/*if (!isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = (IS_LOCALHOST) ? 'localhost' : 'testcase/';
}*/

/*$_SERVER['HTTP_HOST'] = 'klc.ongkir.id';

define('WEB_PROTOCOL', (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off') || $_SERVER['SERVER_PORT']==443) ? 'https://':'http://' ));

if (IS_LOCALHOST) {
    define('WEB_URL','http://localhost/');
} else {
    define('WEB_URL',WEB_PROTOCOL.'klc.ongkir.id/');
}*/

define('API_URL', 'http://localhost/testcase/api/');
define('WEB_URL','http://localhost/testcase/');
define('WEB_NAME','POS MINI');

define('PATH_ROOT', dirname(__FILE__));
define('THEME_DIR', PATH_ROOT.'/themes/');
define('THEME_DIR_URL', WEB_URL.'themes/');

$css_link = '';
$css_embed = '';
$js_link = '';
$js_embed = '';
$js_onready = '';

