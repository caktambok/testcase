<?php
if (!defined('PATH_ROOT')) exit('no direct access allowed!');

$is_login = Sessionget('is_login');
$user_id = Sessionget('id_user');

if (!empty($is_login) AND !empty($user_id)) {
    Urlredirect('dashboard');
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

$error = '';
if (!empty($username) AND !empty($password)) {
    $postdata = array('username'=>$username,'password'=>$password);
    $tables = apiPost(API_URL.'login/login-proses.php', $postdata, 'json_to_array');

    $error = isset($tables['results']['error']) ? $tables['results']['error'] : '';

    $auth_token = isset($tables['results']['auth_token']) ? $tables['results']['auth_token'] : '';

    if (empty($error) AND empty($auth_token)) $error = 'Invalid token [1]';

    if (!empty($error)) {
        Sessionset('err', 1);
        Sessionset('err_msg', $error);
    } else {
        //redirect to dashboard
        $user_assoc = isset($tables['results']['data']) ? $tables['results']['data'] : array();
        foreach ($user_assoc as $key => $value) {
            if ($key=='password') continue;

            Sessionset($key, $value);
        }

        Sessionset('is_login', true);
        Sessionset('auth_token', $auth_token);
        Sessionset('id_user',$user_assoc['id_user']);
        Sessionset('user_nama',$user_assoc['nama_user']);
        Sessionset('user_telp',$user_assoc['telp_user']);
        Sessionset('user_level',$user_assoc['level_user']);
        Sessionset('user_alamat',$user_assoc['alamat_user']);

        Sessionset('err',0);
        Sessionset('err_msg','Selamat datang '.$user_assoc['nama_user']);
        Urlredirect('dashboard');
    }
}

$title = 'Login - '.WEB_NAME;
$description = 'Page Login - '.WEB_NAME;
$keywords = 'Login, page, '.WEB_NAME;

?>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?php echo $description;?>">
    <meta name="keywords" content="<?php echo $keywords;?>">
    <title><?php echo $title;?></title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <link href="<?php echo THEME_DIR_URL;?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo THEME_DIR_URL;?>assets/css/line-awesome/css/line-awesome.css" rel="stylesheet">

    <style>
        .styleBody
        {
            padding-top: 40px; padding-bottom: 40px;
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            background-color: #f5f5f5;
        }
    </style>
</head>

<body class="styleBody">
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h3>SELAMAT DATANG di POS MINI</h3>
            <p>Test Case POS MINI lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit ametlorem ipsum dolor sit amet lorem ipsum dolor sit amet</p>
        </div>
        <div class="col-lg-4 mx-auto">
            <?php
            showError();
            ?>
            <div class="card">
                <div class="card-header" style="border-color: forestgreen"><h4 class="text-center">Silahkan Login</h4></div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Username" aria-label="Username" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><span class="la la-user"></span></span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><span class="la la-lock"></span></span>
                            </div>
                        </div>
                        <button class="btn btn-block btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo THEME_DIR_URL;?>assets/js/jquery.js"></script>
<script src="<?php echo THEME_DIR_URL;?>assets/js/bootstrap.min.js"></script>
</body>
</html>
