<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 3));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SERMS' ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/serms/public/assets/css/style.css">
</head>
<body>

<!-- HEADER -->
<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="container-fluid">
    <?php require $viewFile; ?>
</div>

<!-- FOOTER -->
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
