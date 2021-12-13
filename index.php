<?php

include dirname(__FILE__).'/cms_config.php';
include dirname(__FILE__).'/cms_function.php';

$segments = segments();

$mods = isset($segments[0]) ? $segments[0] : '';
$mods = strtolower($mods);

if (empty($mods)) {
    $mods = 'login';
}

$p = isset($segments[1]) ? $segments[1] : $mods;
$p = trim($p);
if (empty($p)) {
    $p = $mods;
}

$file = PATH_ROOT.'/mods/'.$mods.'/'.$p.'.php';
if (!is_file($file)) {
	$mods = $p = 'login';
	$file = PATH_ROOT.'/mods/'.$mods.'/'.$p.'.php';
}

include ($file);