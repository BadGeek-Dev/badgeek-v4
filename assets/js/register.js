$(document).ready(function () {
    
    $("#register-submit-button").click(function()
    {
        $.ajax({
            type: "POST",
            url: ajaxUrl + "/auth/register_validation",
            data: $( "#register_form" ).serializeArray(),
            dataType: "JSON",
            success: function (response) 
            {
                
            }
        });
    });
});
