            <div class="container margin-bottom-10">
                <div class="row">
                    <div class="col-sm-8">
                        <label for="nb_articles">Nombre d'articles en page d'accueil : </label>
                        <input type="number" name="nb_articles" id="nb_articles" style='width:100px' value="<?php echo getConfig("nb_articles_homepage"); ?>">
                        <button onclick='setNbArticlesHomePage()' class="btn btn-success">Valider</button>
                    </div>
                    <div class="col-sm text-right">
                        <a href="<?=base_url("admin/articles/add")?>" class="btn btn-success"> 
                            <i class="fas fa-edit"></i>&nbsp;Ajouter un article
                        </a>
                    </div>
                </div>
            </div>
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
                            <a href="<?= base_url("admin/articles/edit/" . $item->id); ?>" class="btn btn-success"><i
                                        class="fas fa-edit"></i></a>
                            <a href="#" onclick="deleteArticle(<?=$item->id?>);" class="btn btn-danger btnDeleteArticle"><i
                                        class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>


            <script src="<?php echo base_url('assets/js/admin_index.js') ?>"></script>