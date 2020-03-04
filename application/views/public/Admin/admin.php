            <table class="table table-striped  text-center table_admin">
                <thead class="bg-danger text-light">
                <tr>
                    <th></th>
                    <th scope="col">Titre</th>
                    <th scope="col">Extrait</th>
                    <th scope="col">Auteur</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $item) {
                    ?>
                    <tr>
                        <td><?php $val = ($item->status==1) ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>'; echo $val;?></td>
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo substr($item->content, 0, 50); ?></td>
                        <td><?php echo $item->username; ?></td>
                        <td><?php echo $item->created_at; ?></td>
                        <td>
                            <a href="<?= base_url("admin_articles/editArticle/" . $item->id); ?>" class="btn btn-success"><i
                                        class="fas fa-edit"></i></a>
                            <a href="<?= base_url("admin_articles/removeArticle/" . $item->id); ?>" class="btn btn-danger btnDeleteArticle"><i
                                        class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>




            <script>
                function deleteArticle(event){
                    event.preventDefault();
                    console.log("deleteArticle");
                    const url = this.href;
                    const articleRow = $(this).parent().parent();
                    $.ajax({
                        url: url,
                        type: "POST",
                        dataType: "json",
                        // async: true,
                        success: function () {
                            articleRow.css('display', 'none');
                            displayToastDeletedArticle();

                        }
                    });
                }

                document.querySelectorAll('.btnDeleteArticle').forEach(function (link){
                    console.log("ajout deleteArticle");
                  link.addEventListener('click', deleteArticle);
                })


                function displayToastDeletedArticle(){
                    let target = $(".page-header");
                    console.log(target);
                    let value  ='<div class="toast" role="alert" aria-live="polite" aria-atomic="true" id="toast-message" data-autohide="true" data-delay="2000" style="position:absolute;top:55;right:20;opacity:1;">\n' +
                        '                        <div class="toast-header">\n' +
                        '                        <i class="icon-info-circled"></i>\n' +
                        '                        <strong class="mr-auto">Message de BadGeek</strong>\n' +
                        '                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n' +
                        '                        <span aria-hidden="true">&times;</span>\n' +
                        '                    </button>\n' +
                        '                    </div>\n' +
                        '                    <div class="toast-body">\n' +
                        '                        article supprimé                </div>';
                    $(value).insertAfter(target);
                    setTimeout(hideToastDeletedArticle, 3000);

                }

                function hideToastDeletedArticle(){
                    $('#toast-message').remove();
                }
            </script>