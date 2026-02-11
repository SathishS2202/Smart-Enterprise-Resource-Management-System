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

<div class="header d-flex justify-content-between align-items-center p-2 shadow-sm bg-white">

    <div class="d-flex align-items-center gap-3">
        <!-- Panel Title -->
        <h4 class="mb-0">
            <?php
            if(isset($_SESSION['impersonate_role']) && $_SESSION['impersonate_role'] === 'agent') {
                echo "Agent Panel (Impersonated)";
            } else {
                echo "Agent Panel";
            }
            ?>
        </h4>

        <!-- Role Switch Dropdown -->
        <?php if($_SESSION['role'] === 'admin'): ?>
            <div class="role-switch">
                <i class="bi bi-person-lines-fill"></i>
                <select onchange="location.href=this.value" class="form-select form-select-sm">
                    <option selected disabled>Switch Role</option>
                    <option value="<?= BASE_URL ?>/admin/dashboard">Admin View</option>
                    <option value="<?= BASE_URL ?>/agent/dashboard">Agent View</option>
                    <option value="<?= BASE_URL ?>/client/dashboard">Client View</option>
                </select>
            </div>
            <span class="badge bg-warning text-dark ms-2">Admin Viewing</span>
        <?php endif; ?>
    </div>

    <!-- Header Right: Notifications + Username -->
    <div class="header-right d-flex align-items-center gap-2">
        <i class="bi bi-bell fs-5"></i>
        <span><?= htmlspecialchars($_SESSION['username'] ?? 'Agent') ?></span>
    </div>

</div>
