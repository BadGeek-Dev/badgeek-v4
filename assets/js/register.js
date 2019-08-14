function showKOMessage(message)
{
    $("#register-ko-message").html("<i class='icon-emo-displeased'></i>&nbsp;" + message).removeClass("d-none");
}

$(document).ready(function () {
    
    $("#register-submit-button").click(function()
    {
        //Vérification du password
        if($("#register-form-password").val() != $("#register-form-password-confirmation").val())
        {
            showKOMessage("Les 2 mots de passe ne sont pas identiques.");
            return;
        }
        //Serialization du formulaire
        var form_values = $( "#register-form" ).serializeArray();
        //Blocage du formulaire
        $("#register-form input").attr("disabled", true);
        $("#register-submit-button").data("save", $("#register-submit-button").html()).html("<i class='icon-spin6'></i> Création en cours...");
        //Appel au controller
        $.ajax({
            type: "POST",
            url: ajaxUrl + "/auth/register_validation",
            data: form_values,
            dataType: "JSON",
            success: function (response) 
            {
                $("#register-form-sid").val(response.sid);
                if(response.result == 'OK')
                {
                    $("#register-form").hide();
                    $("#register-submit-button").hide();
                    $("#register-ko-message").addClass("d-none");
                    $("#register-successful").html("<h3><i class='icon-mail'></i> Il ne vous reste plus qu'à valider votre inscription dans <a href='http://"+ response.mailwebsite+"'>votre boîte mail</a>.</h3>").removeClass("d-none");
                    $("#register-ok-message").html("<i class='icon-ok'></i>" + response.message).removeClass("d-none");
                }
                else
                {
                    showKOMessage(response.message);
                    $("#register-submit-button").html($("#register-submit-button").data("save"));
                    $("#register-form input").removeAttr("disabled");
                }
            }
        });
    });
});
