            <table class="table table-striped  text-center table_admin">
                <thead class="bg-danger text-light">
                <tr>

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
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo substr($item->content, 0, 50); ?></td>
                        <td><?php echo $item->username; ?></td>
                        <td><?php echo $item->created_at; ?></td>
                        <td>
                            <a href="<?= base_url("admin/editArticle/" . $item->id); ?>" class="btn btn-success"><i
                                        class="fas fa-edit"></i></a>
                            <a href="<?= base_url("admin/removeArticle/" . $item->id); ?>" class="btn btn-danger"><i
                                        class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>

                    <?php
                }
                ?>
                </tbody>
            </table>