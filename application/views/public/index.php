<?php if($user): ?>
    <h1> Bienvenue <a href="<?=site_url("profile/edit")?>"><?=$user->username?></a></h1><a href="<?=site_url("auth/logout")?>">Se déconnecter</a>
<?php else: ?>
    <button name="" id="" class="btn btn-info" type="button" data-toggle="modal" data-target="#registerModal">
        <i class='icon-edit'></i>
        M'inscrire
    </button>
    <a href="<?=site_url("auth/login")?>"><button name="" id="" class="btn btn-dark" type="button"><i class='icon-login'></i>Se connecter</button> </a>
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
                <form id="register_form">
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-right"><i class='icon-mail' data-toggle="tooltip"></i>&nbsp;Email * : </label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Votre email" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Mot de passe * :</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Votre mot de passe">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Répeter mot de passe * :</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirm" id="password_confirmation" placeholder="Votre mot de passe">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='register-submit-button'><i class='icon-edit'></i>Créer mon compte</button>
            </div>
        </div>
    </div>
</div>