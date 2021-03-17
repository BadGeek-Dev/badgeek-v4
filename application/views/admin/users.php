<table class="table table-striped  text-center table_admin">
    <thead class="bg-danger text-light">
    <tr>
        <th scope="col">Pseudo</th>
        <th scope="col">Email</th>
        <th scope="col">Statut</th>
        <th scope="col" class="nosort"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?php echo getLibelleFromUser($user, "user_only"); ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo getBadgeFromUser($user); ?></td>
            <td>
                <?php if(empty($user->isAdmin())):?>
                    <a href="<?= base_url("admin/users/edit/" . $user->id); ?>"><i class="fas fa-edit"></i></a>
                <?php endif;?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>