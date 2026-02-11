<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>



    <body>

<div class="header d-flex justify-content-between align-items-center p-2 shadow-sm bg-white">

    <!-- LEFT SIDE -->
    <div>
        <h4 class="mb-0">Admin Panel</h4>
    </div>

    <!-- RIGHT SIDE -->
    <div class="d-flex align-items-center gap-4">

         <span class="fw-semibold">
        <?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?>
    </span>
        
        <!-- Profile Dropdown -->
         <div class="dropdown">
    <a href="javascript:void(0);"
   id="profileDropdown"
   role="button"
   data-bs-toggle="dropdown"
   aria-expanded="false"
   class="text-dark fs-4">
    <i class="bi bi-person-circle"></i>
</a>


    <ul class="dropdown-menu dropdown-menu-end"
        aria-labelledby="profileDropdown">
        <li>
            <a class="dropdown-item"
               href="<?= BASE_URL ?>/admin/profile">
                My Profile
            </a>
        </li>
        <li>
            <a class="dropdown-item text-danger"
               href="<?= BASE_URL ?>/admin/logout">
                Logout
            </a>
        </li>
    </ul>
</div>

        

    </div>

</div>
