<div class="row mb-3 align-items-center">
    <div class="col">
        <div>
            <h1 class="shadow text-white">Mon équipage</h1>
            <span class="text-white">Ici, on gère nos mercenaires</span>
        </div>
    </div>
    <div class="col-auto d-flex g-3">
        <button type="button" class="btn btn-outline-danger" id="toggle-bulk-mode">
            Licencier en masse
        </button>

        <?= form_open('equipage/sell-bulk', ['id'=> 'form-sell-bulk', 'class' => 'd-none']) ?>
            <div id="bulk-inputs"></div>
            <button type="submit" id="btn-sell-bulk" class="btn btn-danger ms-3" disabled>
                Licencer la selection ( <i class="fa-solid fa-cent-sign"></i> <span id="bulk-price">0</span> )
            </button>
        <?= form_close() ?>
    </div>
</div>
<div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
    <?php
    foreach($logged_user->getPlayer()->getHeroes() as $hero) : ?>
        <div class="col">
            <?= view_cell('HeroCell', ['character' => $hero, 'context' => 'crew']); ?>
        </div>
    <?php endforeach; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        //Gestion de la confirmation pour la vente INDIVIDUELLE
        document.querySelectorAll('.js-single-sell-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = this.querySelector('button[type="submit"]');
                const heroName = btn.dataset.heroName || 'ce mercenaire';
                Swal.fire({
                    title : 'Résilier le contrat ?',
                    text: `Êtes-vous sûr de vouloir licencier ${heroName} ?`,
                    showCancelButton: true,
                    confirmButtonText: 'Oui !',
                    cancelButtonText: 'Annuler',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-kaosmik',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
        });

        //Déclaration des variables pour la vente en lot
        const toggleBtn = document.getElementById('toggle-bulk-mode');
        const bulkForm = document.getElementById('form-sell-bulk');
        const bulkInputs = document.getElementById('bulk-inputs');
        const bulkPrice = document.getElementById('bulk-price');
        const btnSellBulk = document.getElementById('btn-sell-bulk');

        //Bouton de bascule pour la vente en lot
        toggleBtn.addEventListener('click', () => {
            const isBulkInactive = bulkForm.classList.contains('d-none');

            if(isBulkInactive) {
                //Activation de la vente en lot
                bulkForm.classList.remove('d-none');
                toggleBtn.classList.replace('btn-outline-danger', 'btn-warning');
                toggleBtn.textContent = 'Annuler';
            } else {
                //Désactivation de la vente en lot
                bulkForm.classList.add('d-none');
                toggleBtn.classList.replace('btn-warning', 'btn-outline-danger');
                toggleBtn.textContent = 'Licencier en masse';

                //Décocher toute les cases
                document.querySelectorAll('.js-hero-select').forEach(el => {
                    el.checked = false;
                });
                updateBulkTotal();
            }

            //Masquer / afficher le formulaire de vente en lot
            document.querySelectorAll('.js-bulk-checkbox-container').forEach(el => {
               el.classList.toggle('d-none', !isBulkInactive);
            });
            document.querySelectorAll('.js-single-sell-form').forEach(el => {
                el.classList.toggle('d-none', isBulkInactive);
            })
        });

        //Gestion du clic sur la carte pour cocher / decocher
        document.querySelectorAll('.js-hero-card').forEach(card => {
            card.addEventListener('click', (e) => {
                //Si la vente en lot est ACTIVE et que l'on ne clique pas DIRECTEMENT sur la checkbox
                if(!bulkForm.classList.contains('d-none') && !e.target.classList.contains('js-hero-select')) {
                    const checkbox = card.querySelector('.js-hero-select');
                    if(checkbox) {
                        checkbox.click();
                    }
                }
            })
        })

        //Ecoute du changement sur chaque checkbox
        document.querySelectorAll('.js-hero-select').forEach(checkbox => {
           checkbox.addEventListener('change', updateBulkTotal);
        });

        //Confirmation Swal2 pour la vente en lot
        bulkForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const total = parseInt(bulkPrice.textContent) || 0;

            Swal.fire({
                title: 'Voulez-vous vraiment licencier ces mercenaires ?',
                text: `Vous allez licencier pour ${total} crédits`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui !',
                cancelButtonText: 'Annuler',
                customClass: {
                    confirmButton: 'btn btn-kaosmik',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
        //Recalcul du total
        function updateBulkTotal() {
            let total = 0;
            let count = 0;

            bulkInputs.innerHTML = '';
            document.querySelectorAll('.js-hero-select').forEach(checkbox => {
               const card = checkbox.closest('.js-hero-card');

               if(checkbox.checked) {

                   card.classList.add('is-selected');
                   const price = parseInt(card.dataset.sellPrice) || 0;
                   const heroId = card.dataset.id;
                   total += price;
                   count++;

                   //Ajouter mon input caché
                   const hiddenInput = document.createElement('input');
                   hiddenInput.type = 'hidden';
                   hiddenInput.name = 'ids[]';
                   hiddenInput.value = heroId;
                   bulkInputs.appendChild(hiddenInput);
               } else {
                   card.classList.remove('is-selected');
               }
            });

            bulkPrice.textContent = total;
            btnSellBulk.disabled = (count === 1 || count === 0);
        }
    });
</script>
<style>
    .js-hero-card.is-selected {
        filter: brightness(0.6);
        opacity: 0.8;
    }
</style>