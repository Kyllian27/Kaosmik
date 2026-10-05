<div class="row align-items-center">
    <div class="col">
        <div class="page-title">Liste des missions</div>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="<?= base_url('/admin/mission/new'); ?>" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-2"></i> Créer une nouvelle mission
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
                        <th data-sortable="true">Titre</th>
                        <th data-sortable="true">Niveau</th>
                        <th data-sortable="false">Puissance</th>
                        <th data-sortable="false">Endurance</th>
                        <th data-sortable="true">Équipe</th>
                        <th data-sortable="false">Crédits</th>
                        <th data-sortable="false">Énergie</th>
                        <th data-sortable="false">Expérience</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($missions as $mission) : ?>
                            <tr>
                                <td><?= $mission->id; ?></td>
                                <td><?= esc($mission->title); ?></td>
                                <td><?= $mission->level_required; ?></td>
                                <td><?= $mission->power_required_min; ?> / <?= $mission->power_required_max; ?></td>
                                <td><?= $mission->stamina_cost_min; ?> / <?= $mission->stamina_cost_max; ?></td>
                                <td><?= $mission->team_size_max; ?></td>
                                <td><?= $mission->credits_reward_min; ?> / <?= $mission->credits_reward_max; ?></td>
                                <td><?= $mission->energy_reward_min; ?> / <?= $mission->energy_reward_max; ?></td>
                                <td><?= $mission->experience_reward_min; ?> / <?= $mission->experience_reward_max; ?></td>
                                <td>
                                    <a href="<?= base_url('/admin/mission/edit/' . $mission->id); ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                                    <a href="<?= base_url('/admin/mission/delete/' . $mission->id); ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
