<?php
$included_files = get_included_files();

$datas_log = array();
$datas_log['id_log'] = getId();
$datas_log['id_user'] = $log_user_id;
$datas_log['module_log'] = basename(dirname($included_files[0]));
$datas_log['id_module_log'] = $log_module_id;
$datas_log['action_log'] = basename($included_files[0], '.php');
$datas_log['json_log'] = $log_json;
$datas_log['meta_log'] = isset($log_meta) ? $log_meta : '';
$datas_log['date_log'] = dateTimeNow();
$db->insert('t_log', $datas_log);

//$included_files = get_included_files();
//file_put_contents(dirname(__FILE__).'/savelog.txt', json_encode($included_files));
