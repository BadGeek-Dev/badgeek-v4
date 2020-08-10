<table class="table table-striped  text-center table_admin">
    <thead class="bg-danger text-light">
    <tr>
        <th scope="col">Titre</th>
        <th scope="col">Description</th>
        <th scope="col">Créateur</th>
        <th scope="col">Lien</th>
        <th scope="col">Etat</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($podcasts as $podcast) : ?>
        <tr>
            <td><?= $podcast->titre; ?></td>
            <td><?= $podcast->description; ?></td>
            <td><?= $podcast->username; ?> (<a href="mailto:<?= $podcast->email; ?>"><?= $podcast->email; ?></a>)</td>
            <td><a href="<?= $podcast->lien; ?>"><?= $podcast->lien; ?></a></td>
            <td><?php 
                switch($podcast->valid) {
                    case 0:
                        echo "En attente de validation";
                        break;
                    case 1:
                        echo "Validé";
                        break;
                    case 2:
                        echo "Refusé";
                        break;
                }
            ?></td>
            <td>
                <?php if($podcast->valid == 0) : ?>
                    <a 
                        href="<?= base_url("admin/podcasts/validate/" . $podcast->id); ?>" 
                        class="btn btn-success"
                        onclick="return confirm('Valider <?= $podcast->titre ?> ?')"
                    >
                        <i class="fas fa-check"></i>
                    </a>
                <?php endif ; ?>
                <a class="btn btn-info" href="<?= base_url("admin/podcasts/view/" . $podcast->id); ?>">
                    <i class="fas fa-edit"></i>
                </a>
                <a 
                    href="<?= base_url("admin/podcasts/delete/" . $podcast->id); ?>" 
                    class="btn btn-danger"
                    onclick="return confirm('Supprimer <?= $podcast->titre ?> ? cette action est définitive.')"
                    >
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>