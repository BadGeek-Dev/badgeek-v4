<table class="table table-striped  text-center table_admin">
    <thead class="bg-danger text-light">
    <tr>
        <th scope="col">Titre</th>
        <th scope="col">Description</th>
        <th scope="col">Créateur</th>
        <th scope="col">Lien</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($podcasts as $podcast) : ?>
        <tr>
            <td><?php echo $podcast->titre; ?></td>
            <td><?php echo $podcast->description; ?></td>
            <td><?php echo $podcast->username; ?> (<?php echo $podcast->email; ?>)</td>
            <td><a href="<?php echo $podcast->lien; ?>"><?php echo $podcast->lien; ?></a></td>
            <td>
                <a 
                    href="<?= base_url("admin/podcasts/validate/" . $podcast->id); ?>" 
                    class="btn btn-success"
                    onclick="return confirm('Valider <?php echo $podcast->titre ?> ?')"
                >
                    <i class="fas fa-check"></i>
                </a>
                <a 
                    href="<?= base_url("admin/podcasts/delete/" . $podcast->id); ?>" 
                    class="btn btn-danger"
                    onclick="return confirm('Supprimer <?php echo $podcast->titre ?> ? cette action est définitive.')"
                    >
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>