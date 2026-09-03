<div class="row justify-content-center align-items-center my-5">
    <div class="col-12 col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3">
                <div class="text-center mb-3">
                    <img src="<?= base_url('/assets/img/logo-300.png'); ?>" alt="" class="img-fluid mb-3">
                    <h3 class="fw-bold">Inscription</h3>
                    <p class="text-muted small">Rejoignez l'aventure Kaosmik</p>
                </div>

                <!-- Gestion des erreurs natives de Shield -->
                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session('error') ?>
                    </div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?><br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <form action="<?= url_to('register') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Champ Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" id="email" inputmode="email" autocomplete="email" placeholder="votre@email.com" value="<?= old('email') ?>" required>
                        </div>
                    </div>

                    <!-- Champ Nom d'utilisateur -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="form-control" name="username" id="username" inputmode="text" autocomplete="username" placeholder="Pseudo" value="<?= old('username') ?>" required>
                        </div>
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" id="password" inputmode="text" autocomplete="new-password" placeholder="Mot de passe" required>
                        </div>
                    </div>

                    <!-- Confirmation Mot de passe -->
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmation du mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-shield-halved"></i></span>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm" inputmode="text" autocomplete="new-password" placeholder="Confirmez le mot de passe" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">S'inscrire</button>
                    </div>

                    <p class="text-center mt-3 mb-0 text-muted small">
                        Déjà un compte ? <a href="<?= url_to('login') ?>">Se connecter</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>