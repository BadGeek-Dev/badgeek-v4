

let previousNews = 0;

$('.next_news').on('click', () => {
    getNews(nextNews);
});

$('.previous_news').on('click', () => {
    getNews(previousNews);
});


function getNews(indexNews) {
    let urlTarget = window.location.origin+"/badgeek/getnews/"+indexNews;-
        jQuery.ajax({
            url: urlTarget,
            type: "POST",
            dataType: "json",
            success: function (data) {
                $('#ajax-results').html(data.html);
                previousNews = data.previousID;
                nextNews = data.nextID;

                if (data.previousID > 0) {
                    console.log("sup0");
                    $('.previous_news').prop("disabled", false);
                    $('.previous_news_item').removeClass("disabled");
                } else {
                    console.log("equal0");
                    $('.previous_news').prop("disabled", true);
                    $('.previous_news_item').addClass("disabled");
                }

                if (data.nextID > 0) {
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