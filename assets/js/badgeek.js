window.ajaxUrl = window.location.origin + "/index.php";
$(document).ready(function () {
    $("#profilModal").on('show.bs.modal', function (e) {
        resetModalProfil();
    });
    $("#search-button").on("click", function(){
        $("#search-form").submit();
    });
});