<div class="row align-items-center mb-3">
    <div class="col">
        <h2 class="mb-0"><?= esc($mission->title); ?></h2>
    </div>
    <div class="ms-auto col-auto">
        <div class="d-flex">
            <div class="me-2">
                <i class="fa-solid fa-users"></i> <?= $mission->team_size_max; ?>
            </div>
            <div>
                <i class="fa-solid fa-star"></i> <?= $mission->level_required; ?>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col d-flex justify-content-center">
        <img style="max-height:250px" class="img-fluid" src="<?= base_url('assets/img/no-img.png'); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-body p-3 py-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                        <i class="fa-solid fa-mask fs-2 text-primary"></i> <?php
                        if(count($mission->getSpecializations()) > 0) :
                            foreach($mission->getSpecializations() as $specialization) : ?>
                                <span class="badge text-bg-primary ms-1 js-mission-spec" data-spec-id="<?= $specialization['id']; ?>">
                                    <?= $specialization['name']; ?>
                                </span>
                            <?php endforeach; ?>
                        <?php else : ?>
                            Aucune.
                        <?php endif; ?>
                    </li>
                    <li class="list-group-item p-3">
                        <i class="fa-solid fa-bolt fs-2 text-warning"></i>
                        <span class="ms-1 fs-2"><?= $mission->getStaminaRequired();?></span>
                    </li>
                    <li class="list-group-item p-3 fs-2" data-power-required="<?= $mission->getPowerRequired() ;?>">
                        <i class="fa-solid fa-hand-fist text-danger"></i>
                        <?php if($context == 'send'): ?>
                            <span class="ms-1 text-danger" id="total-power">0</span>
                            <span class="ms-1">/</span>
                        <?php endif; ?>
                        <span class="ms-1"><?= $mission->getPowerRequired() ;?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <?= esc($mission->description); ?>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card text-bg-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 col-md">
                        <div class="text-center fs-2">
                            <i class="fa-solid fa-x fa-sm"></i><i class="fa-solid fa-p fa-sm"></i>
                            <span class="ms-1"><?= $mission->experience_reward_min ;?>-<?= $mission->experience_reward_max ;?></span>
                        </div>
                    </div>
                    <div class="col-4 col-md">
                        <div class="text-center fs-2">
                            <i class="fa-solid fa-cent-sign"></i>
                            <span class="ms-1"><?= $mission->credits_reward_min ;?>-<?= $mission->credits_reward_max ;?></span>
                        </div>
                    </div>
                    <div class="col-4 col-md">
                        <div class="text-center fs-2">
                            <i class="fa-solid fa-atom"></i>
                            <span class="ms-1"><?= $mission->energy_reward_min ;?> - <?= $mission->energy_reward_max ;?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>