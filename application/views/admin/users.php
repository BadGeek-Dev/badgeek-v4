<table class="table table-striped  text-center table_admin">
    <thead class="bg-danger text-light">
    <tr>
        <th scope="col">Pseudo (si défini) - Email</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><a href="<?= base_url("admin/users/edit/" . $user->id); ?>"><?= getLibelleFromUser($user) ?></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>