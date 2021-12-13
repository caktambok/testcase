<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    echo '
    <link rel="stylesheet" type="text/css" href="'.THEME_DIR_URL.'assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="'.THEME_DIR_URL.'assets/css/line-awesome/css/line-awesome.css">
    <link rel="stylesheet" type="text/css" href="'.THEME_DIR_URL.'assets/css/footer.css">
    ';

    if (!empty($css_link)) echo $css_link;

    if (!empty($css_embed)) {
        echo '<style type="text/css">';
        echo '
        .dataTables_wrapper .col-sm-12, .dataTables_wrapper table {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        ';
        echo $css_embed;
        echo '</style>';
    }
    ?>

</head>

<body style="min-height: 75rem;
  padding-top: 4.5rem;">
