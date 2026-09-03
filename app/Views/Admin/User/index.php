<div class="row align-items-center">
    <div class="col">
        <h2 class="page-title">Liste des utilisateurs</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="<?= base_url('admin/user/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Ajouter un utilisateur
            </a>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-hover table-striped align-middle" data-toggle="table" data-search="true" data-show-columns="true">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Actif</th>
                        <th>Groupe</th>
                        <th>Niveau</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($users as $user) : ?>
                        <tr>
                            <td><?= esc($user->id); ?></td>
                            <td><strong><?= esc($user->username); ?></strong></td>
                            <td>
                                <?= $user->isActivated() ? "<i class='text-success fa-solid fa-circle-check fs-5'></i>" : "<i class='text-danger fa-solid fa-circle-xmark fs-5'></i>"; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= ($user->role === 'admin') ? 'danger' : 'primary'; ?> text-white px-2 py-1">
                                    <?= esc(ucfirst($user->role)); ?>
                                </span>
                            </td>
                            <td><?= esc($user->level); ?></td>
                            <td>
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="<?= base_url('admin/user/edit/' . $user->id) ?>"
                                       class="btn btn-sm btn-outline-primary px-3"
                                       title="Éditer">
                                        <i class="fa-solid fa-pen me-1"></i> modifier
                                    </a>
                                    <a href="<?= base_url('admin/user/delete/' . $user->id) ?>"
                                       class="btn btn-sm btn-outline-danger px-3"
                                       title="Supprimer"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'utilisateur <?= esc($user->username) ?> ?');">
                                        <i class="fa-solid fa-trash me-1"></i> Supprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>