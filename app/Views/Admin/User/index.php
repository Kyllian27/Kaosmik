<div class="row align-items-center">
    <div class="col">
        <div class="page-title">Liste des utilisateurs</div>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="<?= base_url('/admin/user/new');?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i> Ajouter un utilisateur
            </a>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-hover table-striped" data-toggle="table" data-search="true" data-show-columns="true">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Actif</th>
                        <th>Groupe</th>
                        <th>Niveau</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($users as $user) : ?>
                        <tr>
                            <td><?= $user->id; ?></td>
                            <td><?= $user->username; ?></td>
                            <td><?= $user->active ? "<i class='text-success fa-solid fa-check'>" : "<i class='text-danger fa-solid fa-x'>"; ?></td>
                            <td><?= implode(', ', $user->getGroups()) ?></td>
                            <td><?= $user->getPlayer()->level; ?></td>
                            <td>
                                <a href="<?= base_url('admin/user/edit/' . $user->id) ?>" class="btn btn-primary btn-icon">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>