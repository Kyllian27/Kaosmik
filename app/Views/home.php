<?php
    if ($user != null) {
        echo $user->getPlayer()->credits;
    } else {
        echo "Va te connecter";
    }