<!-- MODAL FORGOTTEN PASSWORD -->
<script>
//Cloture de la modal = redirection vers l'accueil
$(document).ready(function () {
    $('#rememberPasswordModal').on('hidden.bs.modal', function(){
        window.location.replace("/");
    });
    
});
</script>
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
                        <label for="password" class="col-md-5 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Nouveau mot de passe :</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="remember-password-form-password" name="new" placeholder="Votre nouveau mot de passe">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-5 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Confirmer le nouveau mot de passe :</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="remember-password-form-password" name="new_confirm" placeholder="Votre nouveau mot de passe">
                        </div>
                    </div>
                    <input type="hidden" name="user_id" id="remember-password-form-user-id" value="<?php echo $user_id ?>" />
                    <input type="hidden" name="code" id="remember-password-form-code" value="<?php echo $code ?>" />
                    <input type="hidden" name="<?php echo $this->session->csrfkey?>" id="remember-password-form-csrf" value="<?php echo $this->session->csrfvalue ?>" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id='remember-password-submit-button'><i class='icon-edit'></i>Changer mot de passe</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function () {
            $('#rememberPasswordModal').modal('show');
            $("#remember-password-submit-button").click(function () { 
                //Serialization du formulaire
                var form_values = $("#remember-password-form").serializeArray();
                $.ajax({
                    type: "POST",
                    url: ajaxUrl + "/auth/reset_password/" + $("#remember-password-form-code").val(),
                    data: form_values,
                    dataType: "JSON",
                    success: function (response) 
                    {
                        if(response.result == 'KO')
                        {
                            showKOMessage("remember-password-ko-message", response.message);
                            $("#remember-password-form-csrf").attr("name", response.csrfkey).val(response.csrfvalue);
                        }
                        else
                        {
                            //Le PHP gère le message en session, on recharge pour l'afficher
                            document.location = "/";
                        }
                    }
                });
            });
            
        });

</script>