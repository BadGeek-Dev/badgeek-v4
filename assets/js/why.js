$(document).ready(function () {
    $("#inscription-poditeur-start").click(function (e) { 
        $("#inscription-poditeur-form").collapse('show');
        $("#inscription-poditeur-start").removeClass("btn-secondary").addClass("btn-primary");
        $("#inscription-podcasteur-start").removeClass("btn-primary").addClass("btn-secondary");
        $("#inscription-podcasteur-form").collapse('hide');
    });
    $("#inscription-podcasteur-start").click(function (e) { 
        $("#inscription-podcasteur-form").collapse('show');
        $("#inscription-podcasteur-start").removeClass("btn-secondary").addClass("btn-primary");
        $("#inscription-poditeur-start").removeClass("btn-primary").addClass("btn-secondary");
        $("#inscription-poditeur-form").collapse('hide');
    });
    $('[data-toggle="tooltip"]').tooltip();
    $("#inscription-poditeur-start").click();
});