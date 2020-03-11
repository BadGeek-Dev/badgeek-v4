            <div class='margin-bottom-10 text-right'>
                <a href="<?=base_url("admin/articles/add")?>" class="btn btn-success"> 
                    <i class="fas fa-edit"></i>&nbsp;Ajouter un article
                </a>
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