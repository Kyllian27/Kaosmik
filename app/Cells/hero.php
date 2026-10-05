<div class="card h-100 border border-3 js-hero-card shadow"
     style="border-color: <?= $character->getRarity()->color; ?>!important"
     data-id="<?= $character->id; ?>"
     data-sell-price="<?= (int) $character->cost_credit / 2; ?>"
     data-power="<?= $character->power; ?>"
     data-stamina="<?= $character->stamina_current; ?>"
     data-specialization="<?= $character->getHeroModel()->getSpecialization()['id']; ?>"
>
    <div class="position-absolute top-0 start-0 m-3 d-none js-bulk-checkbox-container" style="z-index: 10;">
        <input type="checkbox" class="form-check-input js-hero-select" style="transform: scale(1.5); cursor: pointer;">
    </div>
    <img class="card-img-top"
         src="<?= (isset($character) && $character->getHeroModel()->getImage()) ? $character->getHeroModel()->getImage()->getUrl() : base_url('/assets/img/no-img.png'); ?>"
         >
    <div class="card-body d-flex flex-column">
        <span class="card-title mb-2"><?= $character->name ?></span>
        <span class="card-subtitle text-body-secondary"><?= $character->getHeroModel()->name ?></span>

        <div class="card-text mt-auto">
            <div class="text-center fs-1">
                <i class="fa-solid fa-hand-fist"></i> <?= $character->power ?>
            </div>
        </div>
        <?php
            if($context == 'cantina') :
                $min = $character->getHeroModel()->power_min * $character->getRarity()->power_multiplier;
                $current = $character->power;
                $max = $character->getHeroModel()->power_max * $character->getRarity()->power_multiplier;

                $total = $max - $min;
                $vert = ( ($current -$min) / $total ) * 100;
                $rouge = 100 - $vert;
            ?>
            <div class="d-flex mt-3">
                <span><?= (int) $min; ?></span>
                <div class="progress mx-2" style="height: 20px;">
                    <div class="progress-bar bg-success fw-semibold" style="width:<?= $vert; ?>%"></div>
                    <div class="progress-bar bg-danger bg-opacity-75" style="width:<?= $rouge;?>%;"></div>
                </div>
                <span><?= (int) $max; ?></span>
            </div>
        <?php endif; ?>
    </div>
    <?php if($character instanceof \App\Entities\Hero) : ?>
        <div class="progress" style="height: 20px;">
            <div class="progress-bar bg-kaosmik"
                 style="width:<?= ($character->stamina_current / $character->stamina_max) * 100; ?>%;"
            >
                <?= $character->stamina_current; ?>
            </div>
        </div>

    <?php endif; ?>
    <?php if($context == 'cantina') : ?>
        <?php if (auth()->user()->getPlayer()->isFleetFull()) : ?>
            <span class="mb-1 badge text-bg-danger">Equipage complet</span>
        <?php endif; ?>
        <?= form_open('cantina/recruit/' . $character->id); ?>
            <div class="d-grid">
                    <button type="submit" class="btn btn-kaosmik"
                        <?= ($character->cost_credit > auth()->user()->getPlayer()->credits) || (auth()->user()->getPlayer()->isFleetFull()) ? 'disabled' : ''; ?>
                    >
                        Recruter ( <i class="fa-solid fa-cent-sign"></i><?= $character->cost_credit; ?> )
                    </button>
            </div>
        <?= form_close(); ?>
    <?php elseif ($context == 'crew') : ?>
        <?= form_open('equipage/sell/' . $character->id, ['class' => 'js-form-sell js-single-sell-form']); ?>
            <div class="d-grid">
                <button type="submit" class="btn btn-danger" data-hero-name="<?= $character->name; ?>">
                    Licencier pour ( <i class="fa-solid fa-cent-sign"></i><?= (int) ($character->cost_credit / 2); ?> )
                </button>
            </div>
        <?= form_close(); ?>
    <?php endif; ?>
    <div class="ribbon">
        <?= $character->getHeroModel()->getSpecialization()['name']; ?>
    </div>
</div>