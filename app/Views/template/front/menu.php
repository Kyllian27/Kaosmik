<header class="navbar navbar-expand-md navbar-light d-print-none mb-3">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark pe-0 pe-md-3">
            <a href="<?= base_url('admin'); ?>">
                <img src="<?= base_url('/assets/img/favicon/favicon.svg'); ?>" alt="" style="height:auto; width: 32px;" class="navbar-brand-img"> KaosmiK
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
                            <a class="nav-link dropdown-toggle <?= $menu['class'] ?? '' ?>" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon me-2"><?= $menu['icon']; ?></span>
                                <span class="nav-link-title"><?= $menu['title']; ?></span>
                            </a>
                            <div class="dropdown-menu">
                                <?php foreach ($menu['subs'] as $subKey => $sub): ?>
                                    <a class="dropdown-item <?= $current_menu === $subKey ? 'active' : '' ?>" href="<?= base_url($sub['url']); ?>">
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
    </div>
</header>