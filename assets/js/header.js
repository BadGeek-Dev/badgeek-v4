function showKOMessage(id_message, message)
{
    $("#" + id_message).html("<i class='icon-emo-displeased'></i>&nbsp;" + message).removeClass("d-none");
}

$(document).ready(function () {
    if($("#toast-message").length > 0) 
    {
        $("#toast-message").toast("show");
    }
    $("#register-submit-button").click(function()
    {
        //Vérification du password
        if($("#register-form-password").val() != $("#register-form-password-confirmation").val())
        {
            showKOMessage("register-ko-message", "Les 2 mots de passe ne sont pas identiques.");
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
                $("input[class='sid']").val(response.sid);
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
                    showKOMessage("register-ko-message", response.message);
                    $("#register-submit-button").html($("#register-submit-button").data("save"));
                    $("#register-form input").removeAttr("disabled");
                }
            }
        });
    });
    $("#login-submit-button").click(function () {
        //Serialization du formulaire
        var form_values = $("#login-form").serializeArray();
        //Blocage du formulaire
        $("#login-form input").attr("disabled", true);
        $("#login-submit-button").data("save", $("#login-submit-button").html()).html("<i class='icon-spin6'></i> Login en cours...");
        //Appel au controller
        $.ajax({
            type: "POST",
            url: ajaxUrl + "/auth/login",
            data: form_values,
            dataType: "JSON",
            success: function (response) {
                $("input[class='sid']").val(response.sid);
                if (response.result == 'KO') 
                {
                    showKOMessage("login-ko-message", response.message);
                    $("#login-submit-button").html($("#login-submit-button").data("save"));
                    $("#login-form input").removeAttr("disabled");
                }
                else
                {
                    //Tout est OK, on est refresh.
                    document.location.reload(true);
                }
            }
        });
    });
    $("#login-form-remember-password").click(function () {
        //Serialization du formulaire
        var form_values = $("#login-form").serializeArray();
        //Blocage du formulaire
        $("#login-form input").attr("disabled", true);
        $("#login-form-remember-password").data("save", $("#login-form-remember-password").html()).html("<i class='icon-spin6'></i> Renvoi du pass en cours...");
        //Appel au controller
        $.ajax({
            type: "POST",
            url: ajaxUrl + "/auth/forgot_password",
            data: form_values,
            dataType: "JSON",
            success: function (response) {
                $("input[class='sid']").val(response.sid);
                if (response.result == 'KO') 
                {
                    showKOMessage("login-ko-message", response.message);
                    $("#login-form-remember-password").html($("#login-form-remember-password").data("save"));
                    $("#login-form input").removeAttr("disabled");
                }
                else
                {
                    //Tout est OK, on est refresh.
                    document.location.reload(true);
                }
            }
        });
    });
});
