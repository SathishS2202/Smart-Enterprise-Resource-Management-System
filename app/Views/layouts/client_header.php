<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Panel</title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="header d-flex justify-content-between align-items-center px-4">
    <div class="d-flex align-items-center gap-3">
        <h4 class="mb-0">Client Panel</h4>
    </div>

    <div class="header-right d-flex align-items-center gap-3">
        <i class="bi bi-bell"></i>
        <span><?= $_SESSION['username'] ?? 'Client' ?></span>
    </div>
</div>
