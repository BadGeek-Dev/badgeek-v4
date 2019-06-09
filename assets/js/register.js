$(document).ready(function () {
    $("#inscription-poditeur-start").click(function (e) { 
        $("#inscription-poditeur-form").show(800);
        $("#inscription-poditeur-start").removeClass("btn-secondary").addClass("btn-primary");
        $("#inscription-podcasteur-start").removeClass("btn-primary").addClass("btn-secondary");
        $("#inscription-podcasteur-form").hide();
    });
    $("#inscription-podcasteur-start").click(function (e) { 
        $("#inscription-podcasteur-form").show(800);
        $("#inscription-podcasteur-start").removeClass("btn-secondary").addClass("btn-primary");
        $("#inscription-poditeur-start").removeClass("btn-primary").addClass("btn-secondary");
        $("#inscription-poditeur-form").hide();
    });
});