<div class="row">
    <div class="col d-flex">
        <div>
            <h1 class="shadow text-white">Mon équipage</h1>
            <span class="text-white">Ici, on gère nos mercenaires</span>
        </div>
    </div>
</div>
<div class="row row-cols-6 g-3">
    <?php
    foreach($logged_user->getPlayer()->getHeroes() as $hero) : ?>
        <div class="col">
            <?= view_cell('HeroCell', ['character' => $hero, 'context' => 'equipage']); ?>
        </div>
    <?php endforeach; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.js-form-sell').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const btn = this.querySelector('button, button[type="submit"]');
                    const heroName = btn.dataset.heroName || 'ce mercenaire';
                    Swal.fire({
                        title: 'Resilier le contrat',
                        text: `Etes vous sur de vouloir vendre ce mercenaire ${heroName}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui!',
                        cancelButtonText: 'Annuler',

                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    })
                })
            })
        })
    </script>