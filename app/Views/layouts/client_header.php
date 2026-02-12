<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username'] ?? 'Client';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<div class="header d-flex justify-content-between align-items-center p-2 shadow-sm bg-white">

    <!-- LEFT SIDE -->
    <div>
        <h4 class="mb-0">Client Panel</h4>
    </div>

    <!-- RIGHT SIDE -->
    <div class="d-flex align-items-center gap-4">

        <!-- Optional Notification Icon -->
        <i class="bi bi-bell fs-5 text-dark"></i>

        <!-- Username -->
        <span class="fw-semibold">
            <?= htmlspecialchars($username) ?>
        </span>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <a href="javascript:void(0);"
               id="clientProfileDropdown"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false"
               class="text-dark fs-4">
               <i class="bi bi-person-circle"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end"
                aria-labelledby="clientProfileDropdown">
                <li>
                    <a class="dropdown-item"
                       href="<?= BASE_URL ?>/client/profile">
                        My Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-danger"
                       href="<?= BASE_URL ?>/client/logout">
                        Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>
