<div class="row row-cold-1 g-3">

    <?php
    foreach ($cantinaHeroes as $hero) : ?>
    <div class="col">
        <?= view_cell('heroCell', ['character' => $hero]); ?>
    </div>
    <?php endforeach; ?>
</div>
