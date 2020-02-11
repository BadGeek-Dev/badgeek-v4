window.ajaxUrl = window.location.origin + "/index.php";
$(document).ready(function () {
    $("#profilModal").on('show.bs.modal', function (e) {
        resetModalProfil();
    });
});