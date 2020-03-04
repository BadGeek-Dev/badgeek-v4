Bienvenue <?= $this->ion_auth->logged_in() ? $this->user->username : "" ?>

<?php
if (isset($result) AND sizeof($result) > 0) {
    var_dump($result);
    ?>

<div class="container-fluid">
    <div class="card text-white bg-dark">
        <div class="card-header bg-danger">
            <h2> News</h2>
        </div>
    </div>
    <div class="card-body ajax-results">
        <h3> <?= $result->title ?></h3>
        <p class="font-italic text-secondary"> par <?= $result->username ?>
            le <?= $result->created_at ?></p>
        <p><?= $result->content ?></p>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="btn page-item previous_news disabled p-0"><a class="page-link" href="#">Previous</a></li>
            <li class="btn page-item next_news <?php if($nextAvailable){ echo "disabled";}?> p-0"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</div>
<?php } ?>

<script>
    let indexNews = 0;
    getNews(indexNews);
    $('.next_news').on('click', () => {
        indexNews = indexNews + 1;
        getNews(indexNews);
    });

    $('.previous_comments').on('click', () => {
        indexNews = indexNews - 1;
        getNews(indexNews);
    });

    function getNews(indexNews) {
        let urlTarget = url;
        urlTarget = urlTarget.replace("12354", indexNews);
        $.ajax({
            url: urlTarget,
            type: "POST",
            dataType: "json",
            success: function (data) {
                $('#ajax-results').html(data[0]);
                $('#pagenum').html(indexNews + 1);
                if (data[1] === true) {
                    $('.navigation_comments').show();
                } else {
                    $('.navigation_comments').hide();
                }

                if (data[2] === true) {
                    $('.previous_comments').prop("disabled", false);
                    $('.previous_comments_item').removeClass("disabled");
                } else {
                    $('.previous_comments').prop("disabled", true);
                    $('.previous_comments_item').addClass("disabled");
                }

                if (data[3] === true) {
                    $('.next_comments').prop("disabled", false);
                    $('.next_comments_item').removeClass("disabled");
                } else {
                    $('.next_comments').prop("disabled", true);
                    $('.next_comments_item').addClass("disabled");
                }
            },
            error: function () {
                $('#ajax-results').html("Erreur d'affichage des commentaires");
            }
        });
    }
</script>