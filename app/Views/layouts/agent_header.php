<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Default values
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Agent';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$impersonate_role = isset($_SESSION['impersonate_role']) ? $_SESSION['impersonate_role'] : '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agent Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$username = $_SESSION['username'] ?? 'Agent';
$role = $_SESSION['role'] ?? '';
$impersonate_role = $_SESSION['impersonate_role'] ?? '';
?>


<div class="container-fluid px-4 pt-3">

<div class="header d-flex justify-content-between align-items-center p-2 shadow-sm bg-white">
    <!-- LEFT: Title + Role Switch -->
    <div class="d-flex align-items-center gap-3">
        <h4 class="mb-0">
            <?= $impersonate_role === 'agent' ? 'Agent Panel (Impersonated)' : 'Agent Panel' ?>
        </h4>

        <?php if ($role === 'admin'): ?>
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-lines-fill fs-5"></i>
            <select class="form-select form-select-sm" onchange="if(this.value) location.href=this.value;">
                <option selected disabled value="">Switch Role</option>
                <option value="<?= BASE_URL ?>/admin/dashboard">Admin View</option>
                <option value="<?= BASE_URL ?>/agent/dashboard">Agent View</option>
                <option value="<?= BASE_URL ?>/client/dashboard">Client View</option>
            </select>
        </div>
        <span class="badge bg-warning text-dark ms-2">Admin Viewing</span>
        <?php endif; ?>
    </div>

    <!-- RIGHT: Notifications + Username + Profile -->
    <div class="d-flex align-items-center gap-3">
        <div class="position-relative">
    

        </div>

        <span class="fw-semibold"><?= htmlspecialchars($username) ?></span>

       <!-- Profile Dropdown -->
<div class="dropdown">
    <a href="#" 
       class="text-dark fs-4"   
       id="agentProfileDropdown" 
       data-bs-toggle="dropdown" 
       aria-expanded="false">
       <i class="bi bi-person-circle"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="agentProfileDropdown">
        <li><a class="dropdown-item" href="<?= BASE_URL ?>/agent/profile">My Profile</a></li>
        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/agent/logout">Logout</a></li>
    </ul>
</div>

    </div>
</div>
