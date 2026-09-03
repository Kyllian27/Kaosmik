<div class="row align-items-center mb-3">
    <div class="col">
        <div class="page-title">Gestion des niveaux de rareté</div>
    </div>
</div>

<div class="row mb-3">
    <!-- Formulaire d'ajout -->
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title">Ajouter une rareté</div>
                <?= form_open('admin/rarity-level/create') ?>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-tag fa-xs"></i>
                    </span>
                    <input type="text" name="name" class="form-control" placeholder="Nom (ex: Commune, Rare...)" required title="Nom de la rareté">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-bolt fa-xs"></i>
                    </span>
                    <input type="number" step="0.01" name="power_multiplier" class="form-control" placeholder="Multiplicateur de puissance" required title="Power Multiplier">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-coins fa-xs"></i>
                    </span>
                    <input type="number" step="0.01" name="cost_multiplier" class="form-control" placeholder="Multiplicateur de coût" required title="Cost Multiplier">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-chart-pie fa-xs"></i>
                    </span>
                    <input type="number" step="0.01" name="appearance_rate" class="form-control" placeholder="Taux d'apparition (%)" required title="Appearance Rate">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-palette fa-xs"></i>
                    </span>
                    <input type="color" name="color" class="form-control form-control-color w-100" value="#6c757d" title="Couleur associée">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-regular fa-floppy-disk me-2"></i>Ajouter
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Tableau d'affichage -->
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-sm" data-toggle="table" data-pagination="true" data-page-size="15" data-sortable="true">
                    <thead>
                    <tr>
                        <th data-sortable="true">Nom</th>
                        <th data-sortable="false">Couleur</th>
                        <th data-sortable="true">Puissance (x)</th>
                        <th data-sortable="true">Coût (x)</th>
                        <th data-sortable="true">Taux d'apparition</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($rarityLevels)) : ?>
                        <?php foreach ($rarityLevels as $rarity) : ?>
                            <tr>
                                <td><strong><?= esc($rarity->name); ?></strong></td>
                                <td>
                                    <span class="badge" style="background-color: <?= esc($rarity->color ?? '#6c757d'); ?>; color: #fff;">
                                        <?= esc($rarity->color ?? '#6c757d'); ?>
                                    </span>
                                </td>
                                <td><?= esc($rarity->power_multiplier ?? 1); ?></td>
                                <td><?= esc($rarity->cost_multiplier ?? 1); ?></td>
                                <td><?= esc($rarity->appearance_rate ?? 0); ?>%</td>
                                <td class="d-flex">
                                    <?= form_open('admin/rarity-level/delete'); ?>
                                    <?= form_hidden('id', (string) $rarity->id); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette rareté ?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <?= form_close(); ?>

                                    <span class="ms-2 btn btn-sm btn-warning openEditModal"
                                          data-id="<?= esc($rarity->id); ?>"
                                          data-name="<?= esc($rarity->name); ?>"
                                          data-color="<?= esc($rarity->color ?? '#6c757d'); ?>"
                                          data-power="<?= esc($rarity->power_multiplier ?? 1); ?>"
                                          data-cost="<?= esc($rarity->cost_multiplier ?? 1); ?>"
                                          data-rate="<?= esc($rarity->appearance_rate ?? 0); ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modale d'édition -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modifier la rareté</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('admin/rarity-level/update'); ?>
            <input type="hidden" id="updateId" name="id" value="">

            <div class="modal-body">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-tag fa-xs"></i>
                    </span>
                    <input id="updateName" type="text" name="name" class="form-control" placeholder="Nom de la rareté" required>
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-bolt fa-xs"></i>
                    </span>
                    <input id="updatePower" type="number" step="0.01" name="power_multiplier" class="form-control" placeholder="Multiplicateur de puissance" required>
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-coins fa-xs"></i>
                    </span>
                    <input id="updateCost" type="number" step="0.01" name="cost_multiplier" class="form-control" placeholder="Multiplicateur de coût" required>
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-chart-pie fa-xs"></i>
                    </span>
                    <input id="updateRate" type="number" step="0.01" name="appearance_rate" class="form-control" placeholder="Taux d'apparition (%)" required>
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-palette fa-xs"></i>
                    </span>
                    <input id="updateColor" type="color" name="color" class="form-control form-control-color w-100" value="#6c757d">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<style>
    .bootstrap-table .pagination .page-item.page-next,
    .bootstrap-table .pagination .page-item.page-prev {
        flex: none !important;
        text-align: inherit !important;
    }
</style>

<script>
    $(document).ready(function(){
        const modalEdit = new bootstrap.Modal('#editModal');

        $(document).on('click', '.openEditModal', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let color = $(this).data('color');
            let power = $(this).data('power');
            let cost = $(this).data('cost');
            let rate = $(this).data('rate');

            $('#updateId').val(id);
            $('#updateName').val(name);
            $('#updateColor').val(color);
            $('#updatePower').val(power);
            $('#updateCost').val(cost);
            $('#updateRate').val(rate);

            modalEdit.show();
        });
    });
</script>