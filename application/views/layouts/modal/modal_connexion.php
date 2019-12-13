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
                    <div class="form-group row" style='margin-bottom:.2em'>
                        <label for="password" class="col-md-4 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Mot de passe :</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="login-form-password" name="password" placeholder="Votre mot de passe">
                            <a id="login-form-remember-password" href='#'><i class='icon-help-circled'></i> J'ai oublié mon mot de passe</a>
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
                <button type="button" class="btn btn-danger" id='login-submit-button'><i class='icon-login'></i>Me connecter</button>
            </div>
        </div>
    </div>
</div>