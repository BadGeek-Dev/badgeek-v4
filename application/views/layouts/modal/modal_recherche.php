<script>
function modalRecherche_addCritere()
{
    $("#searchModal .modal-body .critere").last().append("<div class='critere'>" + $("#searchModal .critere").last().html()+"</div>");
    $("#search-remove-criteria").show();
}
function modalRecherche_removeCritere()
{
    if($("#searchModal .modal-body .critere").length > 1)
    {
        $("#searchModal .modal-body .critere").last().remove();
    }
    if($("#searchModal .modal-body .critere").length == 1)
    {
        $("#search-remove-criteria").hide();
    }
}
function modalRecherche_search()
{
    let liste_raw = $.map($("#searchModal .critere .json_input"), function(e) { return e.value;});
    let liste_criteres = {};
    for (let index = 0; index < liste_raw.length; index++) {
        const key = liste_raw[index];
        index++;
        const value = liste_raw[index];
        if(liste_criteres[key] == undefined)
        {
            liste_criteres[key] = [value];

        }
        else
        {
            liste_criteres[key].push(value);
        }
    }
    $("#modalRecherche_json_query").val(JSON.stringify(liste_criteres));
    $("#modalRecherche_json_query_form").submit();
}
</script>
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
                    <select class="form-control form-control-sm json_input" style="width:150px;display:inline-block;">
                        <option value="titre">Titre</option>
                        <option value="description">Description</option>
                        <option value="tags">Tags</option>
                        <option value="auteur">Auteur</option>
                    </select>
                    <input type="text" name="query" class="json_input input-bottom-only input-70 margin-left-10">
                </div>
                <button class="btn btn-success icon-list-add margin-top-10" id="search-add-criteria" onclick="modalRecherche_addCritere()"> Ajouter un critère </button>
                <button class="btn btn-danger icon-undo margin-top-10 cache" id="search-remove-criteria" onclick="modalRecherche_removeCritere()"> Supprimer le dernier critère </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id='search-submit-button' onclick="modalRecherche_search()" ><i class='icon-search'></i>Rechercher</button>
            </div>
            <form action="rechercheAvancee" method="POST" id="modalRecherche_json_query_form">
                <input type="hidden" name="json_query" id="modalRecherche_json_query">
            </form>
        </div>
    </div>
</div>