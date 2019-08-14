<html>

        <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" context="text/html; charset=utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

                <meta name="description" content="">

                <title>BadGeek</title>

                <link href="<?php echo base_url('assets/node_modules/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
                <link href="<?php echo base_url('assets/css/animation.css') ?>" rel="stylesheet">
                <link href="<?php echo base_url('assets/css/fontello.css') ?>" rel="stylesheet">
                <link href="<?php echo base_url('assets/css/badgeek.css') ?>" rel="stylesheet">
                <script src="<?php echo base_url('assets/node_modules/jquery/dist/jquery.min.js')?>"></script>
                <script src="<?php echo base_url('assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js')?>"></script>
                <script src="<?php echo base_url('assets/js/badgeek.js')?>"></script>
                <?php 
                if(isset($extras) && is_array($extras) && is_array($extras["js"]))
                {
                        foreach($extras["js"] as $extra_js_file)
                        {
                                echo "<script src=\"".base_url($extra_js_file)."\"></script>";
                        }
                }
                ?>
        </head>

        <body>
        <div class="page-header row padding-10">
                <div class="col-md-4">
                        <h1 style='font-family:BGFont;'>
                                <font style='color:red;'>&</font>BadGeek
                        </h1>
                </div>
                <div class="col-md-8 text-right">
                        <?php if($user): ?>
                        <h1> Bienvenue <a href="<?=site_url("profile/edit")?>"><?=$user->username?></a></h1><a href="<?=site_url("auth/logout")?>">Se déconnecter</a>
                        <?php else: ?>
                        <button name="" id="" class="btn btn-info" type="button" data-toggle="modal" data-target="#registerModal">
                                <i class='icon-edit'></i>
                                M'inscrire
                        </button>
                        <a href="<?=site_url("auth/login")?>"><button name="" id="" class="btn btn-dark" type="button"><i class='icon-login'></i>Se connecter</button> </a>
                        <?php endif; ?>

                </div>
        </div>