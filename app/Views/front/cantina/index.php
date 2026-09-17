<div class="row mb-4">
    <div class="col d-flex align-items-center">
        <div>
            <h1 class="shadow text-white">Cantina </h1>
            <span class="text-white">Ici, on recrute nos mercenaires</span>
        </div>
        <div class="ms-auto">
            <?= form_open('cantina/refresh') ?>
            <button type="submit" class="btn btn-kaosmik">Rafraichir la selection</button>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($cantinaHeroes as $hero) : ?>
        <div class="col">
            <?= view_cell('heroCell', ['character' => $hero, 'context' => 'cantina']); ?>
        </div>
    <?php endforeach; ?>
        </div>
    </div>
</div>