<table class="table table-striped  text-center table_admin">
    <thead class="bg-danger text-light">
    <tr>
        <th scope="col">Requete</th>
        <th scope="col">Total</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $item) : ?>
        <tr>
            <td><?= $item->query; ?></td>
            <td><?= $item->count; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>