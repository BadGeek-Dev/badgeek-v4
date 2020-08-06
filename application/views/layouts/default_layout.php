<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" context="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="description" content="">

    <title>BadGeek</title>

    <link href="<?php echo base_url('assets/node_modules/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/node_modules/bootstrap-fileinput/css/fileinput.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/node_modules/@fortawesome/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/animation.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/fontello.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/badgeek.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/node_modules/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/node_modules/popper.js/dist/umd/popper.js') ?>"></script>
    <script src="<?php echo base_url('assets/node_modules/piexifjs/piexif.js') ?>"></script>
    <script src="<?php echo base_url('assets/node_modules/sortablejs/Sortable.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/node_modules/dompurify/dist/purify.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/node_modules/bootstrap-fileinput/js/fileinput.js') ?>"></script>
    <script src="<?php echo base_url('assets/node_modules/bootstrap-fileinput/themes/fas/theme.js') ?>"></script>
    <script src="<?php echo base_url('assets/node_modules/bootstrap-fileinput/js/locales/fr.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/badgeek.js') ?>"></script>
    <?php
        if (isset($extras) && is_array($extras) && is_array($extras["js"])) {
                foreach ($extras["js"] as $extra_js_file) {
                echo "<script src=\"" . base_url($extra_js_file) . "\"></script>";
                }
        }
    ?>
</head>

<body class="container-fluid">
    <div class="page-header row padding-10">
        <div class="col-md-4">
            <h1 style='font-family:BGFont;'>
                    <font style='color:red;'>&</font>BadGeek
            </h1>
        </div>
        <div class="col-md-8 text-right">
        <a href="<?= site_url("podcasts") ?>" class="btn btn-danger margin-right-10">
            <i class='icon-user'></i>
            Podcasts
        </a>
        <?php if ($this->ion_auth->logged_in()) : ?>
            <button name="" id="" class="btn btn-danger margin-right-10" type="button" data-toggle="modal" data-target="#profilModal">
                <i class='icon-user'></i>
                <?=$this->user->username ?: "Profil"?>
            </button>
            <?php if (isAdmin()) : ?>
                <a href="<?= site_url("admin") ?>" class="btn btn-danger margin-right-10">
                    <i class='icon-key'></i>
                    Administration
                </a>
                &nbsp;&nbsp;&nbsp;
            <?php endif; ?>
            <a href="<?= site_url("auth/logout") ?>">
                <button class="btn btn-dark margin-right-10">
                        <i class="icon-logout"></i>
                        Se déconnecter
                </button>
            </a>
            </button>
            <?php else : ?>
            <button name="" id="" class="btn btn-danger margin-right-10" type="button" data-toggle="modal" data-target="#registerModal">
                    <i class='icon-edit'></i>
                    M'inscrire
            </button>
            &nbsp;&nbsp;&nbsp;
            <button name="" id="" class="btn btn-dark" type="button" data-toggle="modal" data-target="#loginModal">
                    <i class='icon-login'></i>Se connecter
            </button>
            <?php endif; ?>
        </div>
    </div>
    <!-- TOAST -->
    <?php include(__DIR__."/toast/toast.php"); ?>
    <!-- MODAL REGISTER -->
    <?php include(__DIR__."/modal/modal_register.php"); ?>
    <!-- MODAL CONNEXION -->
    <?php include(__DIR__."/modal/modal_connexion.php"); ?>
    <!-- MODAL PROFIL -->
    <?php 
    if($this->ion_auth->logged_in()) 
    {
        include(APPPATH."/models/Usersgroups_model.php");
        include(__DIR__."/modal/modal_profil.php");
    } 
    ?>

    <!--FIL D'ARIANE-->
    <?php if(isset($breadcrumb)) echo $breadcrumb; ?>

    <?php echo $contents;?>

    <br/><br/>
        <div class='text-center'>
                <hr/>        
                <em>&copy; BadGeek <?=date("Y")?></em></div>
        </div>
    </body>
</html>