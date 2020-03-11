function deleteArticle(id)
{
    if(confirm("Êtes vous sûr de vouloir supprimer cet article ?"))
    {

        $.ajax({
            type: "POST",
            url: ajaxUrl + "/admin_articles/removeArticle/" + id.toString(),
            data: {},
            dataType: "JSON",
            success: function (response) 
            {
                document.location.reload(true);
            }
        });
    }
}