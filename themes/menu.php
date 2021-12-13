<?php
$userlevel_user = Sessionget('user_level');

$menus = array();
$menus['dashboard'] = array(
    'link'=>WEB_URL.'dashboard',
    'text'=>'Home',
);

if($userlevel_user == 'admin')
{
    $menus_produk = array();
    $menus_produk['produk'] = array(
        'link'=>WEB_URL.'produk',
        'text'=>'Produk',
    );

    $menus_kategori = array();
    $menus_kategori['kategori'] = array(
        'link'=>WEB_URL.'kategori',
        'text'=>'Kategori',
    );

    $menus_user = array();
    $menus_user['users'] = array(
        'link'=>WEB_URL.'users',
        'text'=>'Users',
    );
}

$menus_logout = array();
$menus_logout['logout'] = array(
    'link'=>WEB_URL.'logout',
    'text'=>'Logout',
    'icon'=>'<i class="la la-sign-out"></i>',
);
?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="<?php echo WEB_URL;?>dashboard">Majoo Teknologi Indonesia</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <?php
            foreach ($menus as $k => $arrmenu) {
                $active_menu = ($mods === $k) ? 'active' : '';
                $span_menu = ($mods === $k) ? '<span class="sr-only">(current)</span>' : '';

                echo '
                    <li class="nav-item '. $active_menu.'" style="padding-left: 10px;">
                      <a class="nav-link" href="'.$arrmenu['link'].'">'. $arrmenu['text'].' '.$span_menu.'</a>
                    </li>
                    ';
            }

            if($userlevel_user=='admin')
            {
                foreach ($menus_produk as $mp => $arrmenu)
                {
                    $active_menuproduk = ($mods === $mp) ? 'active' : '';
                    $span_menupro = ($mods === $mp) ? '<span class="sr-only">(current)</span>' : '';
                    echo '
                        <li class="nav-item '. $active_menuproduk.'" style="padding-left: 10px;">
                          <a class="nav-link" href="' . $arrmenu['link'] . '">'.$arrmenu['text'].' '.$span_menupro.'</a>
                        </li>
                        ';
                }

                foreach ($menus_kategori as $mk => $arrmenu)
                {
                    $active_menukategori = ($mods === $mk) ? 'active' : '';
                    $span_menukat = ($mods === $mk) ? '<span class="sr-only">(current)</span>' : '';
                    echo '
                        <li class="nav-item '. $active_menukategori.'" style="padding-left: 10px;">
                          <a class="nav-link" href="' . $arrmenu['link'] . '">'.$arrmenu['text'].' '.$span_menukat.'</a>
                        </li>
                        ';
                }

                foreach ($menus_user as $mu => $arrmenu)
                {
                    $active_menukauser = ($mods === $mu) ? 'active' : '';
                    $span_menuusr = ($mods === $mu) ? '<span class="sr-only">(current)</span>' : '';
                    echo '
                        <li class="nav-item '. $active_menukauser.'" style="padding-left: 10px;">
                          <a class="nav-link" href="' . $arrmenu['link'] . '">'.$arrmenu['text'].' '.$span_menuusr.'</a>
                        </li>
                        ';
                }
            }
            ?>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
            <a href="<?php echo WEB_URL;?>logout" class="btn btn-outline-warning my-2 my-sm-0">Logout <span class="la la-sign-out"></span></a>
        </form>
    </div>
</nav>