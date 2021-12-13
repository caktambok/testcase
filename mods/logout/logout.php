<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

$is_login = Sessionget('is_login');
$user_id = Sessionget('id_user');
if (empty($is_login) OR empty($user_id)) {
    Urlredirect('login');
}

session_unset();
session_destroy();
Urlredirect('login');
