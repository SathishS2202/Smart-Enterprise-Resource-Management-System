<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html lang="<?= APP_LANG ?>" dir="<?= APP_RTL ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SERMS' ?></title>

    <!-- Bootstrap -->
    <?php if (APP_RTL): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/serms/public/assets/css/style.css">
</head>
<body>

<div class="layout-wrapper d-flex <?= APP_RTL ? 'flex-row' : 'flex-row-reverse' ?>">

    <!-- MAIN AREA -->
    <div class="main flex-fill">

        <?php if ($role === 'Admin'): ?>
            <?php require BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
        <?php endif; ?>

        <div class="main-content p-4">
            <?php require $viewFile; ?>
        </div>

    </div>

    <!-- SIDEBAR -->
    <?php if ($role === 'Admin'): ?>
        <?php require BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
