<aside class="navbar navbar-vertical navbar-expand-sm position-absolute" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="<?= base_url('admin'); ?>">
                <img src="<?= base_url('/assets/img/logo-150.png'); ?>" alt="" class="navbar-brand-img">
            </a>
        </h1>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <?php foreach ($menus as $key => $menu): ?>
                    <?php if (isset($menu['subs']) && is_array($menu['subs']) && !empty($menu['subs'])): ?>
                        <!-- Menu parent avec déroulant vertical -->
                        <?php
                        $isChildActive = false;
                        foreach ($menu['subs'] as $subKey => $sub) {
                            if ($current_menu === $subKey) {
                                $isChildActive = true;
                                break;
                            }
                        }
                        $isOpen = ($current_menu === $key || $isChildActive);
                        ?>
                        <li class="nav-item dropdown <?= $isOpen ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle <?= $menu['class'] ?? '' ?> <?= $isOpen ? 'show' : '' ?>" href="#sidebar-<?= $key ?>" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="<?= $isOpen ? 'true' : 'false' ?>">
                                <span class="nav-link-icon me-2"><?= $menu['icon'] ?? ''; ?></span>
                                <span class="nav-link-title"><?= esc($menu['title'] ?? $menu['name'] ?? $key); ?></span>
                            </a>
                            <div class="dropdown-menu <?= $isOpen ? 'show' : '' ?>">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <?php foreach ($menu['subs'] as $subKey => $sub): ?>
                                            <a class="dropdown-item <?= $current_menu === $subKey ? 'active' : '' ?>" href="<?= base_url($sub['url'] ?? ''); ?>">
                                                <span class="nav-link-icon me-2"><?= $sub['icon'] ?? ''; ?></span>
                                                <span class="nav-link-title"><?= esc($sub['title'] ?? $sub['name'] ?? $subKey); ?></span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <!-- Lien simple -->
                        <li class="nav-item <?= $current_menu === $key ? 'active' : '' ?>">
                            <a class="nav-link <?= $menu['class'] ?? '' ?>" href="<?= base_url($menu['url'] ?? ''); ?>">
                                <span class="nav-link-icon me-2"><?= $menu['icon'] ?? ''; ?></span>
                                <span class="nav-link-title"><?= esc($menu['title'] ?? $menu['name'] ?? $key); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</aside>