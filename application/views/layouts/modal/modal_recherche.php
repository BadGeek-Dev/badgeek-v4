<div class="modal fade modal-black" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recherche avancée</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="critere">
                    <select class="form-control form-control-sm">
                        <option value="titre">Titre</option>
                        <option value="description">Description</option>
                        <option value="tag">Tag</option>
                        <option value="auteur">Auteur</option>
                    </select>
                    <input type="text" name="query">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id='search-submit-button'><i class='icon-search'></i>Rechercher</button>
            </div>
        </div>
    </div>
</div>