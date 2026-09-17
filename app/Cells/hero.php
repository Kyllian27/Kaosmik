<?php helper('form'); ?>

<div class="card h-100 border border-3" style="border-color: <?= esc($character->getRarity()->color); ?> !important">
    <img class="card-img-top"
         src="<?= (isset($character) && $character->getHeroModel()->getImage()) ? $character->getHeroModel()->getImage()->getUrl() : base_url('/assets/img/no-img.png'); ?>"
         alt="<?= esc($character->name); ?>"
    >
    <div class="card-body">
        <span class="card-title mb-0"><?= esc($character->name); ?></span>
        <span class="card-subtitle text-body-secondary"><?= esc($character->getHeroModel()->name); ?></span>

        <div class="card-text mb-3">
            <div class="text-center fs-1">
                <i class="fa-solid fa-hand-fist"></i> <?= esc($character->power); ?>
            </div>
        </div>
        <?php
        if (isset($context) && $context === 'cantina') :
            $min = $character->getHeroModel()->power_min * $character->getRarity()->power_multiplier;
            $current = $character->power;
            $max = $character->getHeroModel()->power_max * $character->getRarity()->power_multiplier;

            $total = max(($max - $min), 1);
            $vert = max(0, min(100, (($current - $min) / $total) * 100));
            $rouge = 100 - $vert;
            ?>
            <div class="d-flex align-items-center">
                <span><?= (int) $min; ?></span>
                <div class="progress mx-2 flex-grow-1" style="height: 20px;">
                    <div class="progress-bar bg-success fw-semibold" style="width: <?= $vert; ?>%"></div>
                    <div class="progress-bar bg-danger bg-opacity-75" style="width: <?= $rouge; ?>%"></div>
                </div>
                <span><?= (int) $max; ?></span>
            </div>
        <?php endif; ?>
    </div>

    <?php if (isset($context) && $context === 'cantina') : ?>
        <?= form_open('cantina/recruit/' . $character->id); ?>
        <div class="d-grid">
            <button type="submit" class="btn btn-kaosmik"
                    <?= ($character->cost_credit > auth()->user()->getPlayer()->credits) ? 'disabled' : ''; ?>
            >
                Recruter ( <i class="fa-solid fa-cent-sign"></i><?= esc($character->cost_credit); ?> )
            </button>
        </div>
        <?= form_close(); ?>
    <?php elseif (isset($context) && $context === 'equipage') : ?>
        <?= form_open('equipage/sell/' . $character->id, ['class'=> 'js-form-sell']); ?>
        <div class="d-grid">
            <button type="submit" class="btn btn-danger" data-hero-name="<?=$character->name; ?>">
                Vendre ( <i class="fa-solid fa-cent-sign"></i><?= esc($character->cost_credit); ?> )
            </button>
        </div>
        <?= form_close(); ?>
    <?php endif; ?>

    <div class="ribbon" style="background-color: <?= esc($character->getRarity()->color); ?>">
        <?= esc($character->getRarity()->name); ?>
    </div>
</div>