<div class="row align-items-center mb-3">
    <div class="col">
        <div class="page-title">Gestion des raretés</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title">Nouvelle rareté</div>
                <?= form_open('admin/rarity-level/create') ?>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                    <input type="text" name="name" class="form-control" placeholder="Nom de la rareté" value="" title="Rareté" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 form-control ">
                    <label for="color" style="color: var(--tblr-icon-color); font-size: 1.2em">
                        <i class="fa-solid fa-palette me-2"></i> Couleur
                    </label>
                    <input type="color" id="color" name="color" class="form-control form-control-color" placeholder="Couleur de la rareté" value="" title="Couleur" required>
                </div>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-hand-fist"></i>
                        </span>
                    <input type="number" name="power_multiplier" class="form-control" step='0.1' min='1' placeholder="Multiplicateur de force" value="" title="Multiplicateur de force" required>
                </div>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-cent-sign"></i>
                        </span>
                    <input type="number" name="cost_multiplier" class="form-control" step='0.1' min='1' placeholder="Multiplicateur de coût" value="" title="Multiplicateur de coût" required>
                </div>
                <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <i class="fa-solid fa-percent"></i>
                            </span>
                    <input type="number" name="appearance_rate" class="form-control" step='1' min='0' placeholder="Taux d'apparition" value="" title="Taux d'apparition" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>Créer</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-sm" data-toggle="table" data-pagination="true" data-page-size="15" data-sortable="true">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Couleurs</th>
                        <th>Multi. Force</th>
                        <th>Multi. Coût</th>
                        <th>Taux de drop</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rarityLevels as $rarityLevel) : ?>
                        <tr>
                            <td><?= $rarityLevel->name; ?></td>
                            <td><span class="badge" style="background-color:<?= $rarityLevel->color; ?>"><?= $rarityLevel->color; ?></span></td>
                            <td><?= $rarityLevel->power_multiplier; ?></td>
                            <td><?= $rarityLevel->cost_multiplier; ?></td>
                            <td><?= $rarityLevel->appearance_rate; ?></td>
                            <td class="d-flex">
                                <button type="button" class="btn btn-sm btn-warning openEditModal me-2" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $rarityLevel->id; ?>" data-name="<?= $rarityLevel->name; ?>" data-color="<?= $rarityLevel->color; ?>" data-power="<?= $rarityLevel->power_multiplier; ?>" data-cost="<?= $rarityLevel->cost_multiplier; ?>" data-appearance="<?= $rarityLevel->appearance_rate; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                <?= form_open('admin/rarity-level/delete'); ?>
                                <?= form_hidden('id', $rarityLevel->id);?>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                <?= form_close(); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modification</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('admin/rarity-level/update'); ?>
            <input type="hidden" id="updateId" value="" name="id">
            <div class="modal-body">
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                    <input id="updateName" type="text" name="name" class="form-control" placeholder="Nom de la rareté" value="" title="Rareté" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 form-control ">
                    <label for="updateColor" style="color: var(--tblr-icon-color); font-size: 1.2em">
                        <i class="fa-solid fa-palette me-2"></i> Couleur
                    </label>
                    <input type="color" id="updateColor" name="color" class="form-control form-control-color" placeholder="Couleur de la rareté" value="" title="Couleur" required>
                </div>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-hand-fist"></i>
                        </span>
                    <input id="updatePower" type="number" name="power_multiplier" class="form-control" step='0.1' min='1' placeholder="Multiplicateur de force" value="" title="Multiplicateur de force" required>
                </div>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-cent-sign"></i>
                        </span>
                    <input id="updateCost" type="number" name="cost_multiplier" class="form-control" step='0.1' min='1' placeholder="Multiplicateur de coût" value="" title="Multiplicateur de coût" required>
                </div>
                <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <i class="fa-solid fa-percent"></i>
                            </span>
                    <input id="updateAppearance" type="number" name="appearance_rate" class="form-control" step='1' min='0' max="50" placeholder="Taux d'apparition" value="" title="Taux d'apparition" required>
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
    /* Annule le flex: 0 0 50% de Tabler sur les boutons de pagination */
    .bootstrap-table .pagination .page-item.page-next,
    .bootstrap-table .pagination .page-item.page-prev {
        flex: none !important;
        text-align: inherit !important;
    }
</style>
<script>
    $(document).ready(function(){
        // A n'écouter qu'en JS natif : tabler.min.js dispatche un évènement DOM
        // dont le "type" est littéralement "show.bs.modal". jQuery .on('show.bs.modal', ...)
        // interprète le point comme un namespace et n'écoute que "show", donc ne se déclenche jamais.
        document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-id');
            let name = button.getAttribute('data-name');
            let color = button.getAttribute('data-color');
            let power = button.getAttribute('data-power');
            let cost = button.getAttribute('data-cost');
            let appearance = button.getAttribute('data-appearance');
            $('#updateId').val(id);
            $('#updateName').val(name);
            $('#updateColor').val(color);
            $('#updatePower').val(power);
            $('#updateCost').val(cost);
            $('#updateAppearance').val(appearance);
        })

        $(document).on('submit', 'form[action*="delete"]', function(e) {
            e.preventDefault();
            let form = $(this);
            Swal.fire({
                title:'Êtes-vous sûr ?',
                text : 'Cette action est irréversible !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.get(0).submit();
                }
            })
        })
    });
</script>