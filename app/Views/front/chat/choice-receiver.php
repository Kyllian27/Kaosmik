<div class="row mb-4 align-items-center">
    <div class="col">
        <h1 class="page-title text-white mb-1">Le Chat</h1>
        <p class="text-white-50 mb-0">Choisissez un membre de l'équipage pour démarrer ou reprendre une discussion.</p>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card card-md shadow-sm">
            <div class="card-header border-bottom">
                <h3 class="card-title">Conversations récentes</h3>
            </div>

            <div class="list-group list-group-flush list-group-hoverable">
                <?php foreach ($users as $user) : ?>
                    <?php
                    $avatarUrl = (isset($user['user']) && $user['user']->getImage())
                            ? $user['user']->getImage()->getUrl()
                            : base_url('assets/img/no-img.png');
                    ?>
                    <a href="<?= base_url('chat/' . $user['user']->username); ?>" class="list-group-item list-group-item-action py-3">
                        <div class="row align-items-center g-3">
                            <!-- Avatar -->
                            <div class="col-auto">
                                <span class="avatar avatar-md rounded-circle shadow-sm" style="background-image: url('<?= $avatarUrl; ?>')"></span>
                            </div>

                            <!-- Infos Utilisateur & Dernier Message -->
                            <div class="col">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-reset fw-bold h4 mb-0 me-2"><?= esc($user['user']->username); ?></span>
                                    <?php if (isset($user['last_message'])) : ?>
                                        <small class="text-muted fs-6 ms-auto flex-shrink-0">
                                            <?= date_human_fr($user['last_message']->created_at); ?>
                                        </small>
                                    <?php endif; ?>
                                </div>

                                <div class="text-muted fs-5">
                                    <?php if (isset($user['last_message'])) : ?>
                                        <?= esc(mb_strimwidth($user['last_message']->message, 0, 50, ' [...]')); ?>
                                    <?php else : ?>
                                        <span class="fst-italic text-muted-opacity">Aucun message échangé</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Flèche d'action -->
                            <div class="col-auto">
                                <span class="text-muted">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>