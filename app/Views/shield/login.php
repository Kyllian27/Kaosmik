<div class="row justify-content-center align-items-center my-5">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3">
                <div class="text-center mb-3">
                    <img src="<?= base_url('/assets/img/logo-300.png'); ?>" alt="" class="img-fluid mb-3">
                    <h3 class="fw-bold">Connexion</h3>
                    <p class="text-muted small">Retourner voir votre équipage</p>
                </div>

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

                <form action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Champ Email -->
                    <div class="mb-3">
                        <label for="floatingEmailInput" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" id="floatingEmailInput" inputmode="email" autocomplete="email" placeholder="Email" value="<?= old('email') ?>" required>
                        </div>
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="mb-3">
                        <label for="floatingPasswordInput" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" id="floatingPasswordInput" inputmode="text" autocomplete="current-password" placeholder="Mot de passe" required>
                        </div>
                    </div>

                    <!-- Option Se souvenir de moi -->
                    <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')): ?> checked<?php endif ?>>
                                Se souvenir de moi
                            </label>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
                    </div>

                    <?php if (setting('Auth.allowRegistration')): ?>
                        <p class="text-center mt-3 mb-0 text-muted small">
                            Pas de compte ? <a href="<?= url_to('register') ?>">S'enregistrer</a>
                        </p>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
</div>