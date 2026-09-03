<div class="row align-items-center mb-3">
    <div class="col">
        <div class="page-title">Courbe des niveaux</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title">Ajouter un niveau</div>
                <?= form_open('admin/level-threshold/create') ?>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-n fa-xs"></i>
                        <i class="fa-solid fa-v fa-xs"></i>
                    </span>
                    <input type="number" name="level" class="form-control" placeholder="Niveau" value="<?= !empty($levelThresholds) ? end($levelThresholds)['level'] + 1 : 1; ?>" min="1" title="Niveau">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-x fa-xs"></i>
                        <i class="fa-solid fa-p fa-xs"></i>
                    </span>
                    <input type="number" name="experience_required" class="form-control" placeholder="Experience requise" value="<?= !empty($levelThresholds) ? round(end($levelThresholds)['experience_required'] * 1.3): 1; ?>" min="1" title="Experience requise">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk me-2"></i>Ajouter</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-sm" data-toggle="table" data-pagination="true" data-page-size="15" data-sortable="true">
                    <thead>
                    <tr>
                        <th data-sortable="true">Niveau</th>
                        <th data-sortable="true">Experiences Requise</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($levelThresholds as $lt) : ?>
                        <tr>
                            <td><?= $lt['level'];?></td>
                            <td><?= $lt['experience_required'];?></td>
                            <td class="d-flex">
                                <?= form_open('admin/level-threshold/delete'); ?>
                                <?= form_hidden('id', $lt['id']);?>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                <?= form_close(); ?>
                                <span
                                    class="ms-2 btn btn-sm btn-warning openEditModal"
                                    data-level="<?= $lt['level'];?>"
                                    data-exp="<?= $lt['experience_required'];?>"
                                    data-id="<?= $lt['id'];?>">
                                    <i class="fa-solid fa-pen"></i>
                                </span>
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
            <?= form_open('admin/level-threshold/update'); ?>
            <input type="hidden" id="updateId" value="" name="id">
            <div class="modal-body">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-n fa-xs"></i>
                        <i class="fa-solid fa-v fa-xs"></i>
                    </span>
                    <input id="updateLevel" type="number" name="level" class="form-control" placeholder="Niveau" value="" min="1" title="Niveau">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-x fa-xs"></i>
                        <i class="fa-solid fa-p fa-xs"></i>
                    </span>
                    <input id="updateExperience" type="number" name="experience_required" class="form-control" placeholder="Experience requise" value="" min="1" title="Experience requise">
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
        const modalEdit = new bootstrap.Modal('#editModal');
        $(document).on('click','.openEditModal', function() {
            let id = $(this).data('id');
            let level = $(this).data('level');
            let exp = $(this).data('exp');
            $('#updateId').val(id);
            $('#updateLevel').val(level);
            $('#updateExperience').val