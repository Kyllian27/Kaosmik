<nav class="navbar navbar-expand-lg bg-dark mb-3" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url(); ?>">ZooLogik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php foreach ($menus as $key => $menu): ?>
                    <li class="nav-item">
                        <a href="<?= base_url($menu['url']); ?>" class="nav-link <?= $current_menu == $key ? 'active' : '' ?>">
                            <span class="me-2"><?= $menu['icon']; ?></span><?= $menu['title']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>