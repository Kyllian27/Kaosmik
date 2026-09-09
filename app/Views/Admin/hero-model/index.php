<div class="row align-items-center">
    <div class="col">
        <div class="page-title">Liste des modèles pour les héros</div>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="<?= base_url('/admin/hero-model/new'); ?>" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-2"></i> Créer un nouveau modèle
            </a>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped"
                       data-toggle="table"
                       data-pagination="true"
                       data-page-size="15"
                       data-sortable="true">
                    <thead>
                    <tr>
                        <th data-sortable="true">#</th>
                        <th data-sortable="true">Nom</th>
                        <th data-sortable="true">Spécialisation</th>
                        <th data-sortable="false">Puissance (min/max)</th>
                        <th data-sortable="false">Coût (min/max)</th>
                        <th data-sortable="true">Niveau Min</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($heromodels as $hm) : ?>
                        <tr>
                            <td><?= $hm->id; ?></td>
                            <td><?= $hm->name; ?></td>
                            <td><?= $hm->getSpecialization()['name']; ?></td>
                            <td><?= $hm->power_min; ?> / <?= $hm->power_max; ?></td>
                            <td><?= $hm->cost_credits_min; ?> / <?= $hm->cost_credits_max; ?></td>
                            <td><?= $hm->level_required; ?></td>
                            <td>
                                <a href="<?= base_url('/admin/hero-model/edit/' . $hm->id); ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                                <?php if($hm->id != 1) : ?>
                                    <a href="<?= base_url('/admin/hero-model/delete/' . $hm->id); ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>