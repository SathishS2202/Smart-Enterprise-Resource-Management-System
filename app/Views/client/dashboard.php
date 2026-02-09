<?php require_once BASE_PATH . '/app/Views/layouts/client_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/client_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">

    <h4 class="mb-4">Client Dashboard</h4>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6>Total Projects</h6>
                <h3><?= $totalProjects ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6>Active Projects</h6>
                <h3 class="text-primary"><?= $activeProjects ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6>Completed Projects</h6>
                <h3 class="text-success"><?= $completed ?></h3>
            </div>
        </div>

    </div>

    <div class="dashboard-icons mt-4">
        <a href="<?= BASE_URL ?>/client/projects" class="icon-box">
            <i class="bi bi-folder"></i>
            <span>My Projects</span>
        </a>

        <a href="<?= BASE_URL ?>/client/profile" class="icon-box">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
        </a>
    </div>

</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
