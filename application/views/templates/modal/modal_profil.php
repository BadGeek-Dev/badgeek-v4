<div class="modal fade modal-black" id="profilModal" tabindex="-1" role="dialog" aria-labelledby="profilModal" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Votre profil sur Badgeek</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="profil-ko-message">
                </div>
                <div class="alert alert-success d-none" role="alert" id="profil-ok-message">
                </div>
                    <div class="kv-avatar">
                        <div class="file-loading">
                            <input id="profilAvatarInput" type="file">
                        </div>
                    </div>
                    <div class="kv-avatar-hint">
                        <small>Select file < 500 KB</small>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id='profil-submit-button'><i class='icon-edit'></i>Mettre à jour mon profil</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#profilAvatarInput").fileinput({
            overwriteInitial: true,
            maxFileSize: 500,
            language:'fr',
            allowedFileExtensions: ["jpg", "png", "gif"],
            browseOnZoneClick: true,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            defaultPreviewContent: '<img src="<?=base_url('assets/pictures/avatar.png')?>" alt="Your Avatar">',

        });
    });
</script>