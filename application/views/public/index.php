
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
                    <input type="hidden" name="sid" id="register-form-sid" value="<?=$sid?>"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='register-submit-button'><i class='icon-edit'></i>Créer mon compte</button>
            </div>
        </div>
    </div>
</div>