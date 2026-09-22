<header class="navbar navbar-expand-md navbar-light d-print-none mb-3">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark pe-0 pe-md-3">
            <a href="<?= base_url(); ?>" class="link-underline link-underline-opacity-0">
                <img src="<?= base_url('/assets/img/favicon/favicon.svg'); ?>" alt="" style="height: auto; width: 32px;"
                     class="navbar-brand-img">Kaosmiꓘ
            </a>
        </h1>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav">
                <?php foreach ($menus as $key => $menu): ?>
                    <?php if (isset($menu['subs']) && !empty($menu['subs'])): ?>
                        <!-- Lien parent avec sous-menu -->
                        <?php
                        $isChildActive = false;
                        foreach ($menu['subs'] as $subKey => $sub) {
                            if ($current_menu === $subKey) {
                                $isChildActive = true;
                                break;
                            }
                        }
                        ?>
                        <li class="nav-item dropdown <?= ($current_menu === $key || $isChildActive) ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle <?= $menu['class'] ?? '' ?>" href="#navbar-extra"
                               data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                               aria-expanded="false">
                                <span class="nav-link-icon me-2"><?= $menu['icon']; ?></span>
                                <span class="nav-link-title"><?= $menu['title']; ?></span>
                            </a>
                            <div class="dropdown-menu">
                                <?php foreach ($menu['subs'] as $subKey => $sub): ?>
                                    <a class="dropdown-item <?= $current_menu === $subKey ? 'active' : '' ?>"
                                       href="<?= base_url($sub['url']); ?>">
                                        <span class="nav-link-icon me-2"><?= $sub['icon']; ?></span>
                                        <span class="nav-link-title"><?= $sub['title']; ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php else: ?>
                        <!-- Lien simple -->
                        <li class="nav-item <?= $current_menu === $key ? 'active' : '' ?>">
                            <a class="nav-link <?= $menu['class'] ?? '' ?>" href="<?= base_url($menu['url']); ?>">
                                <span class="nav-link-icon me-2"><?= $menu['icon']; ?></span>
                                <span class="nav-link-title"><?= $menu['title']; ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="navbar-nav flex-row order-md-last ms-auto">
            <div class="nav-item dropdown">
                <?php if (isset($logged_user)) : ?>
                    <a href="#" class="nav-link d-flex lh-1 text-reset" data-bs-toggle="dropdown"
                       aria-label="Ouvrir le menu utilisateur">
                    <span class="avatar avatar-sm"
                          style="background-image: url(<?= (isset($logged_user) && $logged_user->getImage()) ? $logged_user->getImage()->getUrl() : base_url('/assets/img/no-img.png') ?>"></span>
                        <div class="d-none d-md-block ps-2">
                            <div class="small fw-bold"
                            <div><?= $logged_user->username; ?></div>
                            <div class="mt-1 small text-muted">Niveau : <?= $logged_user->getPlayer()->getTotalPower(); ?>
                            <i class="fa-solid fa-hand-fist"></i>
                            </div>
                        </div>
                        <div class="d-none d-md-block ps-2">
                            <div class="small text-muted">
                                <i class="fa-solid fa-cent-sign"></i><?= $logged_user->getPlayer()->credits; ?>
                            </div>
                            <div class="mt-1 small text-muted">
                                <i class="fa-solid fa-atom"></i><?= $logged_user->getPlayer()->fusion_energy; ?>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <?php if ($logged_user->isAdmin()) : ?>
                            <a href="<?= 'admin' ?>" class="dropdown-item">Administration</a>
                            <div class="dropdown-divider"></div>
                        <?php endif; ?>
                        <a href="#" class="dropdown-item">Mon Compte</a>
                        <a href="<?= base_url('logout') ?>" class="dropdown-item">Déconnexion</a>
                    </div>
                <?php else : ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-ghost-kaosmik">Se connecter</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>