<div class="row align-items-center">
    <div class="col">
        <div class="page-title mb-3">Liste des modèle des héros</div>
        <div class="col-auto d-print-none">
            <div class="btn-list">
                <a href="<?= base_url('/admin/hero-model/new') ?>" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus me-2"></i> Créer un nouveau modèle
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-responsive table-hover table-striped table-sm " data-toggle="table"
                       data-height="460" data-pagination="true" data-page-list="[10, 25, 50, 100, 200, All]">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>specialisation</th>
                        <th>Puissance (min-max)</th>
                        <th>Coût (min-max)</th>
                        <th>Niveau Min</th>
                        <th >Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($hero_models as $hero_model) : ?>
                        <tr>
                            <td><?= $hero_model->id ?></td>
                            <td><?= $hero_model->name ?></td>
                            <td><?= $hero_model->getSpecialization()['name'];?></td>
                            <td><?= $hero_model->power_min.' - '.$hero_model->power_max ?></td>
                            <td><?= $hero_model->cost_credits_min.' - '.$hero_model->cost_credits_max ?></td>
                            <td><?= $hero_model->level_required ?></td>
                            <td><?= form_open('/admin/hero-model/delete')?> <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                            <a href="<?=base_url('/admin/hero-model/edit/'.$hero_model->id)?>"class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i>
                                <?= form_hidden('id', $hero_model->id)?>
                                <?= form_close() ?></a>
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