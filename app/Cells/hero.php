<div class="card h-100 d-flex flex-column">
    <img class="card-img-top"
         src="<?= (isset($character) && $character->getImage()) ? base_url($character->getImage()->url) : base_url('/assets/img/no-img.png'); ?>"
         alt="<?= esc($character->name) ?>">

    <div class="card-header">
        <?= esc($character->name) ?>
    </div>

    <div class="card-body d-flex flex-column">
        <ul>
            <li>name : <?= esc($character->name) ?></li>
            <li>model : <?= esc($character->getHeroModel()->name) ?></li>
            <li>rarity : <?= esc($character->getRarity()->name) ?></li>
            <li>rarity couleur : <?= esc($character->getRarity()->color) ?></li>
            <li>power : <?= esc($character->power) ?></li>
            <li>cost : <?= esc($character->getCostCredit()) ?></li>
        </ul>

        <?php if (isset($context) && $context === 'cantina'): ?>
            <?php
            $min = $character->getHeroModel()->power_min * $character->getRarity()->power_multiplier;
            $current = $character->power;
            $max = $character->getHeroModel()->power_max * $character->getRarity()->power_multiplier;

            $total = max(($max - $min), 1);
            $vert = (($current - $min) / $total) * 100;
            $rouge = 100 - $vert;
            ?>
            <div class="progress" style="height:20px;">
                <div class="progress-bar bg-success fw-semibold" style="width:<?= $rouge ?>%;"></div>
                <div class="progress-bar bg-danger" style="width:<?= $vert ?>%;"></div>
            </div>
            <div class="ribbon" style="background-color: <?= esc($character->getRarity()->color) ?>;">
                <?= esc($character->getRarity()->name) ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (isset($context) && $context === 'cantina'): ?>
        <div class="card-footer p-2 mt-auto border-top-0 bg-transparent">
            <a href="<?= base_url('cantina/recruit/' . $character->id) ?>"
               class="btn w-100 d-flex justify-content-between align-items-center py-2 px-3 fw-bold text-white rounded"
               style="background-color: #6f42c1; border: 1px solid #8957e5;"
               onmouseover="this.style.backgroundColor='#b197fc'; this.style.color='#1a0933';"
               onmouseout="this.style.backgroundColor='#6f42c1'; this.style.color='#ffffff';">
                <span><i class="fa-solid fa-user-plus me-1"></i> Recruter</span>
                <span class="badge bg-dark text-warning border border-warning">
                    <i class="fa-solid fa-coins me-1"></i><?= esc($character->getCostCredit()) ?>
                </span>
            </a>
        </div>
    <?php endif; ?>
</div>