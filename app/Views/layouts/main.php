<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SERMS' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/serms/public/assets/css/style.css">
</head>

<body>

<?php if ($role === 'Admin'): ?>
    <?php require BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>
<?php endif; ?>

<div class="main">
    <?php if ($role === 'Admin'): ?>
        <?php require BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
    <?php endif; ?>

    <div class="main-content">
        <?php require $viewFile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
