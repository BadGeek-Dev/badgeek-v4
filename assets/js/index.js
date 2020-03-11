


$('.next_news').on('click', () => {
    getNews(currentID,'next');
});

$('.previous_news').on('click', () => {
    getNews(currentID,'previous');
});


function getNews(id,side) {
    let urlTarget = window.location.origin+"/badgeek/getnews/"+currentID+"/"+side;
        jQuery.ajax({
            url: urlTarget,
            type: "POST",
            dataType: "json",
            success: function (data) {
                $('#ajax-results').html(data.html);
                currentID = data.currentID;
                
                if (data.btnStatus['previous']) {
                    $('.previous_news').prop("disabled", false);
                    $('.previous_news_item').removeClass("disabled");
                } else {
                    $('.previous_news').prop("disabled", true);
                    $('.previous_news_item').addClass("disabled");
                }

                if (data.btnStatus['next']) {
                    $('.next_news').prop("disabled", false);
                    $('.next_news_item').removeClass("disabled");
                } else {
                    $('.next_news').prop("disabled", true);
                    $('.next_news_item').addClass("disabled");
                }
            },
            error: function (data) {
                $('#ajax-results').html("Erreur d'affichage des News");
            }
        });
}