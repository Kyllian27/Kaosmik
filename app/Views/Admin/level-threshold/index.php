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
                <?= form_open('admin/level-thresholds/create') ?>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-n fa-xs"></i>
                        <i class="fa-solid fa-v fa-xs"></i>
                    </span>
                    <input class="form-control" type="number" name="level" placeholder="level">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-x fa-xs"></i>
                        <i class="fa-solid fa-p fa-xs"></i>
                    </span>
                    <input class="form-control" type="number" name="experience_required" placeholder="experience_required">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk me-2"></i>Ajouter</button>
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
                        <th data-sortable="true">Niveau</th>
                        <th data-sortable="true">Experiences Requise</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($levelThresholds as $ltc): ?>
                        <tr>
                            <td><?= $ltc['level'] ?></td>
                            <td><?= $ltc['experience_required'] ?></td>
                            <td class="d-flex gap-1">
                                <span class="btn btn-sm btn-warning openEditModal"
                                      data-id="<?= $ltc['id'] ?>"
                                      data-level="<?= $ltc['level'] ?>"
                                      data-exp="<?= $ltc['experience_required'] ?>">
                                    <i class="fa-solid fa-pen"></i>
                                </span>

                                <?= form_open('admin/level-thresholds/delete') ?>
                                <?= form_hidden('id', $ltc['id']) ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <?= form_close(); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modale de modification -->
            <div class="modal fade" id="editModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <?= form_open('admin/level-thresholds/update') ?>
                        <div class="modal-body">
                            <input type="hidden" id="updateId" name="id" value="">

                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="fa-solid fa-n fa-xs"></i>
                                    <i class="fa-solid fa-v fa-xs"></i>
                                </span>
                                <input class="form-control" type="number" id="updateLevel" name="level" placeholder="level">
                            </div>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="fa-solid fa-x fa-xs"></i>
                                    <i class="fa-solid fa-p fa-xs"></i>
                                </span>
                                <input class="form-control" type="number" id="updateExp" name="experience_required" placeholder="experience_required">
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

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const modalEdit = new bootstrap.Modal('#editModal');

        $(document).on('click','.openEditModal', function() {
            let id = $(this).data('id');
            let level = $(this).data('level');
            let exp = $(this).data('exp');
            $('#updateId').val(id);
            $('#updateLevel').val(level);
            $('#updateExp').val(exp);
            modalEdit.show();


        });
    });
</script>