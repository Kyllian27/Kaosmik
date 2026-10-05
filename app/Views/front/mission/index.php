<div class="row mb-3 align-items-center">
    <div class="col">
        <div>
            <h1 class="shadow text-white">Choix de la mission</h1>
            <span class="text-white">Ici, on envoie nos mercenaires au casse-pipe.</span>
        </div>
    </div>
    <div class="col-auto ms-auto">
        <a href="<?= base_url('mon-profil/mes-anciennes-missions') ?>" class="btn btn-sm btn-outline-kaosmik">Historique</a>
    </div>
</div>
<div class="row">
    <div class="col-md-9 mb-3">
        <div class="card">
            <div class="card-body">
                <div id="mission-container">
                    <?= view_cell('MissionCell', ['mission' => $missions[0]]) ?>
                </div>
                <?= form_open('mission/envoyer-l-equipage', ['id' => 'select-mission']); ?>
                    <input id="form-mission-id" type="hidden" name="mission_id" value="<?= $missions[0]->id; ?>">
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Choisir cette mission</button>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body" id="mission-list">
                <?php foreach($missions as $mission) : ?>
                    <div class="card js-mission mb-3 shadow <?= $mission->level_required > $logged_user->getPlayer()->level ? 'not-available' : ''; ?> <?= $mission->id == $missions[0]->id ? 'mission-selected' : ''; ?>" data-id="<?= $mission->id; ?>">
                        <div class="row g-0">
                            <div class="col-4">
                                <img class="img-fluid rounded-start"
                                     src="<?= base_url('assets/img/no-img.png'); ?>">
                            </div>
                            <div class="col-8">
                                <div class="card-body p-2 h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fa-solid fa-users"></i>
                                            <span class="ms-1"><?= $mission->team_size_max ;?></span>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-x fa-sm"></i><i class="fa-solid fa-p fa-sm"></i>
                                            <span class="ms-1"><?= $mission->experience_reward_min ;?>-<?= $mission->experience_reward_max ;?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fa-solid fa-bolt"></i>
                                            <span class="ms-1"><?= $mission->getStaminaRequired() ;?></span>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-hand-fist"></i>
                                            <span class="ms-1"><?= $mission->getPowerRequired() ;?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fa-solid fa-cent-sign"></i>
                                            <span class="ms-1"><?= $mission->credits_reward_min ;?>-<?= $mission->credits_reward_max ;?></span>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-atom"></i>
                                            <span class="ms-1"><?= $mission->energy_reward_min ;?> - <?= $mission->energy_reward_max ;?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<style>
    .js-mission {
        cursor: pointer;
    }
    .js-mission:hover, .js-mission:focus {
        transform: scale(1.02);
    }
    .not-available {
        filter: brightness(0.6);
        opacity: 0.6;
        cursor: not-allowed;
    }
    .mission-selected {
        border: 2px solid #007bff;
    }

    #mission-container {
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        opacity: 1;
        transform: translateY(0);
    }
    #mission-container.is-loading {
        opacity: 0;
        transform: translateY(8px);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mission_container = document.getElementById('mission-container');
        const mission_list = document.getElementById('mission-list');
        const input_mission_id = document.getElementById('form-mission-id');

        mission_list.addEventListener('click', async (e) => {
            //remonte à partir du click à la div .js-mission la plus proche
            const mission = e.target.closest('.js-mission');
            if(!mission || mission.classList.contains('not-available')) return;

            const id = mission.dataset.id;
            if(!id) return;
            mission_list.querySelectorAll('.mission-selected').forEach(card => card.classList.remove('mission-selected'));
            mission.classList.add('mission-selected');

            input_mission_id.value = id;

            mission_container.classList.add('is-loading');

            try {
                const response = await fetch(`<?= base_url('mission/details/') ?>${id}`, {
                    headers: {'X-Requested-With': 'XMLHttpRequest'}
                });
                if(!response.ok) throw new Error('HTTP error! status: ' + response.status);

                const html = await response.text();
                setTimeout(() => {
                    mission_container.innerHTML = html;
                    mission_container.classList.remove('is-loading');
                }, 250);


            } catch(error) {
                console.error(error);
                mission_container.innerHTML = `
                    <div class="alert alert-danger">
                        Impossible de charger les détails de cette mission.
                    </div>
                `;
            }
        })
    });
</script>