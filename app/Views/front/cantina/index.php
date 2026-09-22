<div class="row">
    <div class="col d-flex">
        <div>
            <h1 class="shadow text-white">La Cantina</h1>
            <span class="text-white">Ici, on recrute nos mercenaires</span>
        </div>
        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 fs-1" id="timer" data-seconds="<?= $remaining_seconds; ?>">
                <?= $remaining_time; ?>
            </span>
            <?= form_open('cantina/refresh'); ?>
            <button type="submit" class="btn btn-kaosmik">
                Rafraichir (<span id="refresh_cost"></span>)
            </button>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<div class="row g-3">
    <?php
    foreach($cantinaHeroes as $hero) : ?>
        <div class="col">
            <?= view_cell('HeroCell', ['character' => $hero, 'context' => 'cantina']); ?>
        </div>
    <?php endforeach; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Selection des élements
        const timerElement = document.getElementById('timer');
        const refreshCostElement = document.getElementById('refresh_cost');
        if(!timerElement) return;
        //Récupération des secondes
        let remainingSeconds = parseInt(timerElement.dataset.seconds, 10);
        //Sécurité : si pas valide ou 0 on rafraichit
        if(isNaN(remainingSeconds) || remainingSeconds <= 0) {
            window.location.reload();
            return;
        }
        //Conversion des secondes en dates
        const formatTime = (seconds) => {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = seconds % 60;
            const pad = (num) => String(num).padStart(2, '0');
            return `${pad(h)}:${pad(m)}:${pad(s)}`;
            //calcul du coute de rafraichisement
            const updateRefreshCost = (seconds) => {
                if(!refreshCostElement) return;
                const h = Math.floor(seconds / 3600);
                const cost = (h+1)*10 ;
                refreshCostElement.textContent = cost;
            }
        }
        //Affichage initial
        timerElement.textContent = formatTime(remainingSeconds);
        //Création du décompte
        const countdown = setInterval( () => {
            remainingSeconds--;
            if(remainingSeconds <= 0) {
                clearInterval(countdown);
                timerElement.textContent = '00:00:00';
                window.location.reload();
                return;
            }
            timerElement.textContent = formatTime(remainingSeconds);
            //mettrer a jour le cout si on change d'heure (quand minutes et seconde passe a 59)
            if(remainingSeconds & 3600 === 3599) {
                updateRefreshCost(remainingSeconds);
            }
        },1000);

    });
</script>