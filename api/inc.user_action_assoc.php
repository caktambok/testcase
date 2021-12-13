<?php
if (empty($user_id_action)) exit('invalid uid');

$user_action_assoc = $db->row('select * from t_users
            where id_user=\''.$user_id_action.'\'
            ');

if (empty($user_action_assoc['id_user']) OR $user_action_assoc['id_user'] !== $user_id_action) {
    $err_msg = 'Who are you? [0].';
    errorResponse('custom_msg', $queries, $err_msg);
}

$user_action_level = $user_action_assoc['level_user'];

