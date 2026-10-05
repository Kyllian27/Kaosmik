<?php
// [préfixe du champ, libellé min, libellé max, icône]
$rangeFields = [
    ['power_required', 'Puissance requise minimale', 'Puissance requise maximale', 'fa-hand-fist'],
    ['stamina_cost', 'Coût en endurance minimum', 'Coût en endurance maximum', 'fa-bolt'],
    ['credits_reward', 'Récompense en crédits minimum', 'Récompense en crédits maximum', 'fa-cent-sign'],
    ['energy_reward', 'Récompense en énergie minimum', 'Récompense en énergie maximum', 'fa-atom'],
    ['experience_reward', 'Récompense en expérience minimum', 'Récompense en expérience maximum', 'fa-star'],
];
?>
<div class="row align-items-center mb-3">
    <div class="col">
        <div class="page-title">
            <?= isset($mission) ? "Modification de la mission " . esc($mission->title) : "Création d'une nouvelle mission"; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <?php
                echo form_open('admin/mission/create-update');
                if (isset($mission)) :
                echo form_hidden('id', (string) $mission->id);
                endif; ?>
                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                        <input type="text" name="title" class="form-control" placeholder="Titre" title="Titre" maxlength="150" value="<?= isset($mission) ? esc($mission->title) : ''?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" placeholder="Description"><?= isset($mission) ? esc($mission->description) : '';?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Spécialisations</label>
                    <select name="specialization_ids[]" class="form-select" multiple>
                        <?php foreach( $specializations as $spe): ?>
                        <option
                                value="<?= $spe['id']; ?>"
                                <?= in_array($spe['id'], $selectedSpecializations) ? 'selected' : ''; ?>
                        >
                            <?= esc($spe['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Niveau requis</label>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-n fa-xs"></i>
                            <i class="fa-solid fa-v fa-xs"></i>
                        </span>
                        <input type="number" name="level_required" class="form-control" placeholder="Niveau requis" title="Niveau requis" min="1" value="<?= isset($mission) ? $mission->level_required : '1'?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Taille maximale de l'équipe</label>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-people-group"></i>
                        </span>
                        <input type="number" name="team_size_max" class="form-control" placeholder="Taille maximale de l'équipe" title="Taille maximale de l'équipe" min="1" value="<?= isset($mission) ? $mission->team_size_max : ''?>">
                    </div>
                </div>
                <?php foreach ($rangeFields as [$prefix, $labelMin, $labelMax, $icon]) : ?>
                <div class="row">
                    <?php foreach (['min' => $labelMin, 'max' => $labelMax] as $suffix => $label) :
                        $name = $prefix . '_' . $suffix; ?>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><?= $label; ?></label>
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <i class="fa-solid <?= $icon; ?>"></i>
                            </span>
                            <input type="number" name="<?= $name; ?>" class="form-control" placeholder="<?= $label; ?>" title="<?= $label; ?>" min="0" value="<?= isset($mission) ? $mission->$name : ''?>" required>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <?= (isset($mission) ? "Modifier" : "Créer"); ?>
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
