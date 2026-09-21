<div class="row">
    <div class="col d-flex align-items-center">
        <!-- 1. IMAGE DE L'UTILISATEUR CORRIGÉE -->
        <div class="me-3">
            <?php
            $avatar = auth()->user()->getPlayer()->avatar ?? null;
            $avatarPath = $avatar ? 'uploads/avatars/' . $avatar : 'assets/img/favicon/logo-150.png';
            ?>
            <img src="<?= base_url($avatarPath); ?>"
                 alt="Avatar"
                 class="rounded-circle border border-2 border-light shadow"
                 style="width: 60px; height: 60px; object-fit: cover;">
        </div>

        <div>
            <h1 class="shadow text-white mb-0">La Cantina</h1>
            <span class="text-white">Ici, on recrute nos mercenaires</span>
        </div>
        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 fs-1 text-white" id="timer" data-seconds="<?= $remaining_seconds; ?>">
                <?= $remaining_time; ?>
            </span>
            <?= form_open('cantina/refresh', ['id' => 'form-refresh']); ?>
            <button type="submit" class="btn btn-kaosmik">
                Rafraichir (<i class="fa-solid fa-cent-sign"></i><span id="refresh-cost"></span>)
            </button>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <!-- ESPACE CORRIGÉ DANS LE FOREACH -->
    <?php foreach($cantinaHeroes as$hero) : ?>
        <div class="col-md-4">
            <?= view_cell('HeroCell', ['character' => $hero, 'context' => 'cantina']); ?>
        </div>
    <?php endforeach; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. GESTION DU TIMER ET DU COÛT ---
        const timerElement = document.getElementById('timer');
        const refreshCostElement = document.getElementById('refresh-cost');
        if(!timerElement) return;

        let remainingSeconds = parseInt(timerElement.dataset.seconds, 10);

        if(isNaN(remainingSeconds) || remainingSeconds <= 0) {
            window.location.reload();
            return;
        }

        const formatTime = (seconds) => {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = seconds % 60;
            const pad = (num) => String(num).padStart(2, '0');
            return `${pad(h)}:${pad(m)}:${pad(s)}`;
        }

        const updateRefreshCost = (seconds) => {
            if(!refreshCostElement) return;
            const h = Math.floor(seconds / 3600);
            const cost = (h + 1) * 10;
            refreshCostElement.textContent = cost;
        }

        timerElement.textContent = formatTime(remainingSeconds);
        updateRefreshCost(remainingSeconds);

        const countdown = setInterval(() => {
            remainingSeconds--;
            if(remainingSeconds <= 0) {
                clearInterval(countdown);
                timerElement.textContent = '00:00:00';
                window.location.reload();
                return;
            }
            timerElement.textContent = formatTime(remainingSeconds);

            if(remainingSeconds % 3600 === 3599) {
                updateRefreshCost(remainingSeconds);
            }
        }, 1000);


        // --- 2. CONFIRMATIONS EN JAVASCRIPT ---

        // A. Confirmation pour le rafraîchissement
        const refreshForm = document.getElementById('form-refresh');
        if (refreshForm) {
            refreshForm.addEventListener('submit', (event) => {
                const cost = refreshCostElement ? refreshCostElement.textContent : '';
                const confirmRefresh = confirm(`Veux-tu vraiment rafraîchir la sélection pour ${cost} crédits ?`);

                if (!confirmRefresh) {
                    event.preventDefault(); // Annule l'envoi du formulaire
                }
            });
        }

        // B. Confirmation pour le recrutement d'un héros
        const recruitButtons = document.querySelectorAll('.btn-recruit');
        recruitButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                const name = button.getAttribute('data-name') || 'ce mercenaire';
                const cost = button.getAttribute('data-cost') || '';

                const message = `Veux-tu vraiment recruter ${name} pour ${cost} crédits ?`;
                const confirmRecruit = confirm(message);

                if (!confirmRecruit) {
                    event.preventDefault(); // Annule la redirection/le clic
                }
            });
        });
    });
</script>