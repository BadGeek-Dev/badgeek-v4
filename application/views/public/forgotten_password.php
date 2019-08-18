<!-- MODAL FORGOTTEN PASSWORD -->
<div class="modal show modal-black" id="rememberPasswordModal" tabindex="-1" role="dialog" aria-labelledby="rememberPasswordModal" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Réinitialiser mon mot de passe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="remember-password-ko-message">
                </div>
                <form id="remember-password-form">
                    <div class="form-group row">
                        <label for="identity" class="col-md-5 col-form-label text-right"><i class='icon-mail' data-toggle="tooltip"></i>&nbsp;Email : </label>
                        <div class="col-md-6">
                            <input class='form-control' value="<?php echo $email; ?>" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-5 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Votre nouveau mot de passe :</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="remember-password-form-password" name="password" placeholder="Votre nouveau mot de passe">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-5 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Répeter nouveau mot de passe :</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="remember-password-form-password" name="password" placeholder="Votre nouveau mot de passe">
                        </div>
                    </div>
                    <input type="hidden" name="csrfkey" id="remember-password-form-sid" value="<?php echo $flashdata['csrfkey'] ?>" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id=' remember-password-submit-button'><i class='icon-edit'></i>Changer mot de passe</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $('#rememberPasswordModal').modal('show');
</script>