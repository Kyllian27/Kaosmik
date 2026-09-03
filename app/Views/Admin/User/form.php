<div class="row mb-3 align-items-center">
    <div class="col">
        <div class="page-title">
            <?= isset($user) ? "Modification" : "Création"; ?> d'un utilisateur
        </div>
    </div>
</div>

<?php
$form_action = isset($user) ? 'admin/user/update' : 'admin/user/create';

// Récupération du rôle Shield pour la sélection
$currentRole = 'player';
if (isset($userRole)) {
    $currentRole = $userRole;
} elseif (isset($user) && method_exists($user, 'getGroups')) {
    $groups = $user->getGroups();
    $currentRole = !empty($groups) ? $groups[0] : 'player';
}
?>

<?= form_open($form_action); ?>

<div class="row g-3">
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-header">Informations utilisateur</div>
            <div class="card-body">

                <!-- Nom d'utilisateur -->
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text"
                           value="<?= old('username', isset($user) ? esc($user->username) : ""); ?>"
                           name="username"
                           class="form-control"
                           placeholder="Nom d'utilisateur"
                           required>
                </div>

                <!-- Mot de passe -->
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Mot de passe <?= isset($user) ? '(laisser vide pour ne pas modifier)' : ''; ?>"
                            <?= isset($user) ? '' : 'required'; ?>>
                </div>

                <!-- Adresse E-mail -->
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email"
                           value="<?= old('email', isset($user) ? esc(method_exists($user, 'getEmail') ? $user->getEmail() : $user->email) : ""); ?>"
                           name="email"
                           class="form-control"
                           placeholder="Email"
                           required>
                </div>

                <!-- Choix du groupe / rôle Shield -->
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user-shield"></i>
                    </span>
                    <select name="role" class="form-select" style="padding-left: 2.5rem">
                        <option value="player" <?= ($currentRole === 'player') ? 'selected' : ''; ?>>Player</option>
                        <option value="moderator" <?= ($currentRole === 'moderator') ? 'selected' : ''; ?>>Moderator</option>
                        <option value="admin" <?= ($currentRole === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

                <!-- Statut Actif -->
                <div class="mt-3">
                    <label class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" <?= (old('active') || (isset($user) && $user->active)) ? "checked" : ""; ?>>
                        <span class="form-check-label">Actif</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Informations joueur</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center justify-content-center border-end">
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-user-ninja fa-3x mb-2"></i>
                            <div>AVATAR</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center h-100">
                                    Niveau : <span class="badge rounded-pill text-bg-info ms-2"><?= (isset($user) && $user->getPlayer()) ? esc($user->getPlayer()->level) : "1"; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-star"></i>
                                    </span>
                                    <input type="number"
                                           value="<?= old('experience', (isset($user) && $user->getPlayer()) ? esc($user->getPlayer()->experience) : "0"); ?>"
                                           name="experience" class="form-control" placeholder="Expérience" title="Expérience">
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-coins"></i>
                                    </span>
                                    <input type="number"
                                           value="<?= old('credits', (isset($user) && $user->getPlayer()) ? esc($user->getPlayer()->credits) : "0"); ?>"
                                           name="credits" class="form-control" placeholder="Crédits" title="Crédits">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-atom"></i>
                                    </span>
                                    <input type="number"
                                           value="<?= old('fusion_energy', (isset($user) && $user->getPlayer()) ? esc($user->getPlayer()->fusion_energy) : "0"); ?>"
                                           name="fusion_energy" class="form-control" placeholder="Énergie de fusion" title="Énergie de fusion">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panneau d'actions et métadonnées -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted">Créé le :</small>
                        <small>
                            <i class="fa-solid fa-clock me-1"></i> <?= (isset($user) && isset($user->created_at)) ? format_date_fr($user->created_at) : "-"; ?>
                        </small>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <small class="text-muted">Mise à jour :</small>
                        <small>
                            <i class="fa-solid fa-clock me-1"></i> <?= (isset($user) && isset($user->updated_at)) ? format_date_fr($user->updated_at) : "-"; ?>
                        </small>
                    </div>
                </div>

                <div class="d-grid mt-3">
                    <?php if (isset($user) && !empty($user->id)): ?>
                        <?= form_hidden("id", (string) $user->id); ?>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-sm text-white" style="background-color: #40e0d0; border-color: #40e0d0;">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Sauvegarder
                    </button>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= form_close(); ?>