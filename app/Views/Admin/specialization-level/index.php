<div class="row align-items-center">
    <div class="col">
        <div class="page-title mb-3">Liste des niveaux de spécialisation</div>
        <div class="col-auto d-print-none">
            <div class="btn-list">
                <a href="<?= base_url('/admin/specialization-level/new') ?>" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus me-2"></i> Créer un nouveau niveau
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-responsive table-hover table-striped table-sm" data-toggle="table"
                       data-height="460" data-pagination="true" data-page-list="[10, 25, 50, 100, 200, All]">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($specializationLevels as $level) : ?>
                        <?php

                        $id = is_array($level) ? ($level['id'] ?? '') : ($level->id ?? '');
                        $name = is_array($level) ? ($level['name'] ?? '') : ($level->name ?? '');
                        $description = is_array($level) ? ($level['description'] ?? '') : ($level->description ?? '');
                        ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td><?= $name ?></td>
                            <td><?= $description ?></td>
                            <td>
                                <?= form_open('/admin/specialization-level/delete') ?>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                <a href="<?= base_url('/admin/specialization-level/edit/' . $id) ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                                <?= form_hidden('id', $id) ?>
                                <?= form_close() ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>