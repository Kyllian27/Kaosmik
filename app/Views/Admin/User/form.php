<div class="row mb-3 align-items-center">
    <div class="col">
        <div class="page-title">
            <?= isset($user) ? "Modification" : "Création"; ?> d'un utilisateur
        </div>
    </div>
</div>
<?php
    $form_action = 'admin/user/';
    if (isset($user)) {
        $form_action .= 'update';
    } else {
        $form_action .= 'create';
    }
?>
<?= form_open_multipart($form_action); ?>
<div class="row g-3">
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-header">Informations utilisateur</div>
            <div class="card-body">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($user) ? esc($user->username) : ""; ?>" name="username" class="form-control" placeholder="Nom d'utilisateur">
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
                    <input type="text" value="<?= isset($user) ? esc($user->email) : ""; ?>" name="mail" class="form-control" placeholder="Email" <?= isset($user) ? "disabled" : "" ?>>
                </div>
                <div>
                    <label class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" <?= isset($user) && !$user->active ? "" : "checked"; ?>>
                        <span class="form-check-label">Actif</span>
                    </label>
                </div>
            </div>
        </div>
        <?php if (isset($user) && $user->getPlayer() !== null)  : ?>
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
                                Niveau : <span class="badge rounded-pill text-bg-info ms-3"><?= $user->getPlayer()->level; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-x fa-xs"></i>
                                        <i class="fa-solid fa-p fa-xs"></i>
                                    </span>
                                    <input type="number" value="<?= isset($user) ? $user->getPlayer()->experience : ""; ?>" name="experience" class="form-control" placeholder="Experience" title="Experience">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-cent-sign"></i>
                                    </span>
                                    <input type="number" value="<?= isset($user) ? $user->getPlayer()->credits : ""; ?>" name="credits" class="form-control" placeholder="Crédits" title="crédits">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-atom"></i>
                                    </span>
                                    <input type="number" value="<?= isset($user) ? $user->getPlayer()->fusion_energy : ""; ?>" name="fusion_energy" class="form-control" placeholder="Energie de fusion" title="Energie de fusion">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <?php if(isset($user)) : ?>
                <div class="d-flex justify-content-between">
                    <div>Crée le :</div>
                    <div>
                        <i class="fa-regular fa-clock me-1"></i><?= format_date_fr($user->created_at); ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Mise à jour le : </div>
                    <div>
                        <i class="fa-regular fa-clock me-1"></i><?= format_date_fr($user->updated_at); ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="d-grid">
                    <?php if(isset($user)) :
                        echo form_hidden('id', (string) $user->id);
                    endif; ?>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk me-2"></i> Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>