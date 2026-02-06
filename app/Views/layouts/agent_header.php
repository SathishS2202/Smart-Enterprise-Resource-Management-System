<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agent Dashboard</title>

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <h4 class="mb-0">Agent Panel</h4>

        <!-- Optional: Switch Role (if needed) -->
        <div class="role-switch">
            <i class="bi bi-person-lines-fill"></i>
            <select onchange="location.href=this.value" class="form-select form-select-sm">
                <option selected disabled>Switch Role</option>
                <option value="<?= BASE_URL ?>/admin/dashboard">Admin View</option>
                <option value="<?= BASE_URL ?>/client/dashboard">Client View</option>
            </select>
        </div>
    </div>

    <div class="header-right">
        <i class="bi bi-bell"></i>
        <?= htmlspecialchars($_SESSION['username'] ?? 'Agent') ?>
    </div>
</div>
