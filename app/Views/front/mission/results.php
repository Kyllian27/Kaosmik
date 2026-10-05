<?php if(isset($credits) && isset($energy) && isset($xp) && isset($heroes)) : ?>
<div class="row mb-3 align-items-center">
    <div class="col">
        <div>
            <h1 class="shadow text-white">Résultat de votre mission</h1>
            <span class="text-white">On applaudit le retour des mercenaires.</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="card bg-kaosmik">
                            <div class="card-body">
                                <div class="row row-cols-3 fs-2">
                                    <div class="col text-center">
                                        <i class="fa-solid fa-x fa-sm"></i><i class="fa-solid fa-p fa-sm"></i>
                                        <span class="ms-1"><?= $xp; ?></span>
                                    </div>
                                    <div class="col text-center">
                                        <i class="fa-solid fa-cent-sign"></i>
                                        <span class="ms-1"><?= $credits; ?></span>
                                    </div>
                                    <div class="col text-center">
                                        <i class="fa-solid fa-atom"></i>
                                        <span class="ms-1"><?= $energy; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p>Voici vos héros après la mission</p>
                <div class="row row-cols-2 row-cols-md-4 row-cols-xl-6 g-3">
                    <?php foreach($heroes as $hero) : ?>
                        <div class="col">
                            <?= view_cell('HeroCell', ['character' => $hero]); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php else : ?>
<div class="row">
    <div class="col">
        <div class="alert alert-warning" role="alert">
            Aucun résultat pour une mission qui n'a pas été faites.
        </div>
    </div>
</div>
<?php endif; ?>