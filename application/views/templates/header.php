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
        <script src="<?php echo base_url('assets/node_modules/jquery/dist/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/badgeek.js') ?>"></script>
        <?php
        if (isset($extras) && is_array($extras) && is_array($extras["js"])) {
                foreach ($extras["js"] as $extra_js_file) {
                        echo "<script src=\"" . base_url($extra_js_file) . "\"></script>";
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
                        <?php if ($this->ion_auth->logged_in()) : ?>
                        <button name="" id="" class="btn btn-danger margin-right-10" type="button" data-toggle="modal" data-target="#loginModal">
                                <i class='icon-user'></i>
                                Profil
                        </button>
                        &nbsp;&nbsp;&nbsp;
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
        <!-- MODAL MESSAGE -->
        <?php
        $flashdata = $this->session->flashdata();
        if (is_array($flashdata) && count($flashdata)) {
                if (key_exists("message-title", $flashdata)) $flashdata_message_title = $flashdata["message-title"];
                if (key_exists("message", $flashdata))       $flashdata_message = $flashdata["message"];
        }
        ?>
        <?php if (isset($flashdata_message)) : ?>
        <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                <div class="toast" role="alert" aria-live="polite" aria-atomic="true" id="toast-message" data-autohide="false">
                        <div class="toast-header">
                                <i class="icon-info-circled"></i>
                                <strong class="mr-auto"><?= isset($flashdata_message_title) ? $flashdata_message_title : "Message de BadGeek" ?></strong>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="toast-body">
                                <?= $flashdata_message ?>
                        </div>
                </div>
        </div>
        <?php endif; ?>
        <!-- MODAL REGISTER -->
        <div class="modal fade modal-black" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title">M'inscrire sur BadGeek</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                        <div class="alert alert-success d-none" role="alert" id="register-ok-message">
                                        </div>
                                        <div class="alert alert-danger d-none" role="alert" id="register-ko-message">
                                        </div>
                                        <div class="d-none" id="register-successful">
                                        </div>
                                        <form id="register-form">
                                                <div class="form-group row">
                                                        <label for="email" class="col-md-4 col-form-label text-right"><i class='icon-mail' data-toggle="tooltip"></i>&nbsp;Email : </label>
                                                        <div class="col-md-6">
                                                                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Votre email" value="">
                                                        </div>
                                                </div>
                                                <div class="form-group row">
                                                        <label for="password" class="col-md-4 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Mot de passe :</label>
                                                        <div class="col-md-6">
                                                                <input type="password" class="form-control" id="register-form-password" name="password" placeholder="Votre mot de passe">
                                                        </div>
                                                </div>
                                                <div class="form-group row">
                                                        <label for="password_confirmation" class="col-md-4 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Confirmation mot de passe :</label>
                                                        <div class="col-md-6">
                                                                <input type="password" class="form-control" name="password_confirm" id="register-form-password-confirmation" placeholder="Votre mot de passe">
                                                        </div>
                                                </div>
                                                <input type="hidden" name="sid" class='sid' id="register-form-sid" value="<?= $sid ?>" />
                                        </form>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" id='register-submit-button'><i class='icon-edit'></i>Créer mon compte</button>
                                </div>
                        </div>
                </div>
        </div>
        <!-- MODAL CONNEXION -->
        <div class="modal fade modal-black" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title">Se connecter sur BadGeek</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                        <div class="alert alert-danger d-none" role="alert" id="login-ko-message">
                                        </div>
                                        <form id="login-form">
                                                <div class="form-group row">
                                                        <label for="identity" class="col-md-4 col-form-label text-right"><i class='icon-mail' data-toggle="tooltip"></i>&nbsp;Email : </label>
                                                        <div class="col-md-6">
                                                                <input type="email" class="form-control" name="identity" id="login-form-email" aria-describedby="emailHelpId" placeholder="Votre email" value="">
                                                        </div>
                                                </div>
                                                <div class="form-group row">
                                                        <label for="password" class="col-md-4 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Mot de passe :</label>
                                                        <div class="col-md-6">
                                                                <input type="password" class="form-control" id="login-form-password" name="password" placeholder="Votre mot de passe">
                                                        </div>
                                                </div>
                                                <div class="form-group row">
                                                        <label for="remember" class="col-md-4 col-form-label text-right"><i class='icon-info-circled' data-toggle="tooltip"></i>&nbsp;Se rappeler de moi :</label>
                                                        <div class="col-md-6">
                                                                <input type="checkbox" class="margin-top-15" id="login-form-remember" name="remember">
                                                        </div>
                                                </div>
                                                <input type="hidden" name="sid" class='sid' id="login-form-sid" value="<?= $sid ?>" />
                                        </form>
                                </div>
                                <div class="modal-footer">
                                        <button id="login-form-remember-password" class="btn btn-info"><i class='icon-help-circled'></i> J'ai oublié mon mot de passe</button>
                                        <button type="button" class="btn btn-danger" id='login-submit-button'><i class='icon-login'></i>Me connecter</button>
                                </div>
                        </div>
                </div>
        </div>