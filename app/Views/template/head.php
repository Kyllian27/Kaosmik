<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <base href="<?= base_url(); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?= $title ?? "Zoologik" ?></title>
    <meta name="description" content="<?= $description ?? "" ?>" >
    <meta name="author" content="<?= $author ?? "" ?>" >
    <meta name="keyword" content="<?= $keyword ?? "" ?>" >

    <!-- TODO: FAVICON -->
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('/css/style.css'); ?>">
    <!-- JQUEYR -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@4.0.0/dist/jquery.min.js"></script>
    <!-- JS -->
    <script src="<?= base_url('/js/script.js'); ?>"></script>
    <!-- THEME TABLER -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- SWAL2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- TOASTR -->
    <script src="<?= base_url('/js/toastr.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('/css/toastr.min.css'); ?>" />

    <!-- BOOTSTRAP TABLE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>

    <!-- BOOTSTRAP PASSWORD -->
    <script src="https://unpkg.com/bootstrap-show-password@1.3.0/dist/bootstrap-show-password.min.js"></script>
</head>
<body>
<div class="page">
<?php if (isset($menus)): ?>
    <?= view("template/{$layout}/menu"); ?>
<?php endif; ?>
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container">