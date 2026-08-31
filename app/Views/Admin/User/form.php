<div class="row mb-3 align-items-center">
    <div class="col">
        <div class="page-title">
            <?= isset($user) ? "Modification" : "Création"; ?> d'un utilisateur
        </div>
    </div>
</div>
<?php if(isset($user)) {
    $form_action = 'admin/user/update';
} else {
    $form_action = 'admin/user/create';
}
?>
<div class="row g-3">
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-header">Informations utilisateur</div>
            <div class="card-body">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($user) ? esc($user->username) : ""; ?>" name="username"
                           class="form-control" placeholder="Nom d'utilisateur">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="text" value="" name="password" class="form-control" placeholder="Mot de passe">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="text" value="<?= isset($user) ? esc($user->email) : ""; ?>" name="mail"
                           class="form-control" placeholder="Email" <?= isset($user) ? "disabled" : "" ?>>
                </div>
                <div>
                    <label class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active">
                        <span class="form-check-label">Actif</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Informations joueur(s)</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        AVATAR
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center h-100">
                                    Niveau : <span
                                            class="badge rounded-pill text-bg-info ms-3"><?= isset($user) ? $user->getPlayer()->level : ""; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-x"></i>
                                        <i class="fa-solid fa-p"></i>
                                    </span>
                                    <input type="number"
                                           value="<?= isset($user) ? $user->getPlayer()->experience : ""; ?>"
                                           name="experience" class="form-control" placeholder="Experience"
                                           title="Experience">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-cent-sign"></i>
                                    </span>
                                    <input type="number" value="<?= isset($user) ? $user->getPlayer()->credits : ""; ?>"
                                           name="credits" class="form-control" placeholder="Crédits" title="crédits">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-atom"></i>
                                    </span>
                                    <input type="number"
                                           value="<?= isset($user) ? $user->getPlayer()->fusion_energy : ""; ?>"
                                           name="fusion_energy" class="form-control" placeholder="Energie de fusion"
                                           title="Energie de fusion">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100" style="height:200px">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        Créer le :
                    </div>
                    <div>
                        <i class="fa-solid fa-clock me-1"></i> <?= isset($user) ? format_date_fr($user->created_at) : ""; ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        Mise à jours le :
                    </div>
                    <div>
                        <i class="fa-solid fa-clock me-1"></i> <?= isset($user) ? format_date_fr($user->updated_at) : ""; ?>
                    </div>
                </div>
                <div class="d-grid">
                    <?php if(isset($user)): ?>
                        <?= form_hidden("id",(string) $user->id); ?>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-sm text-white" style="background-color: #40e0d0; border-color: #40e0d0;">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>