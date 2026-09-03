<?php if (isset($user) && $user !== null): ?>
    <?= $user->getPlayer()?->credits ?? 0; ?>
<?php else: ?>
    Va te connecter
<?php endif; ?>