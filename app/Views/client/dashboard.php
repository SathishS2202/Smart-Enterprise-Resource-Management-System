<?php require_once BASE_PATH . '/app/Views/layouts/client_sidebar.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/client_header.php'; ?>

<div class="container-fluid px-4 pt-3">

    <h3><?= __('Welcome') ?> <?= htmlspecialchars($_SESSION['name'] ?? 'Client') ?></h3>

    <!-- ===== DASHBOARD CARDS ===== -->
    <div class="row g-4 mt-3">

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6><?= __('Total Projects') ?></h6>
                <h3><?= $totalProjects ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6><?= __('Active Projects') ?></h6>
                <h3 class="text-primary"><?= $activeProjects ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6><?= __('Completed Projects') ?></h6>
                <h3 class="text-success"><?= $completedProjects ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6><?= __('Pending Tasks') ?></h6>
                <h3><?= $pendingTasks ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6><?= __('In Progress Tasks') ?></h6>
                <h3><?= $inProgressTasks ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6><?= __('Completed Tasks') ?></h6>
                <h3><?= $completedTasks ?? 0 ?></h3>
            </div>
        </div>

    </div>

    <!-- ===== QUICK LINKS ===== -->
    <div class="row g-3 mt-4">
        <div class="col-md-3 col-sm-6">
            <a href="<?= BASE_URL ?>/client/projects" class="icon-box text-center shadow-sm p-3 d-block rounded">
                <i class="bi bi-folder fs-2 text-success"></i>
                <span class="d-block mt-2"><?= __('My Projects') ?></span>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="<?= BASE_URL ?>/client/tasks" class="icon-box text-center shadow-sm p-3 d-block rounded">
                <i class="bi bi-list-task fs-2 text-warning"></i>
                <span class="d-block mt-2"><?= __('My Tasks') ?></span>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="<?= BASE_URL ?>/client/profile" class="icon-box text-center shadow-sm p-3 d-block rounded">
                <i class="bi bi-person fs-2 text-primary"></i>
                <span class="d-block mt-2"><?= __('My Profile') ?></span>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="<?= BASE_URL ?>/client/reports" class="icon-box text-center shadow-sm p-3 d-block rounded">
                <i class="bi bi-bar-chart fs-2 text-danger"></i>
                <span class="d-block mt-2"><?= __('Reports') ?></span>
            </a>
        </div>
    </div>

    

   

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/* ===== TASK STATUS PIE CHART ===== */
new Chart(document.getElementById('taskPieChart'), {
    type: 'pie',
    data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
            label: 'Tasks',
            data: [
                <?= $pendingTasks ?? 0 ?>,
                <?= $inProgressTasks ?? 0 ?>,
                <?= $completedTasks ?? 0 ?>
            ],
            backgroundColor: ['#f6c23e', '#36A2EB', '#1cc88a']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

/* ===== PROJECT STATUS BAR CHART ===== */
new Chart(document.getElementById('projectStatusChart'), {
    type: 'bar',
    data: {
        labels: ['Active', 'Completed', 'Pending'],
        datasets: [{
            label: 'Projects',
            data: [
                <?= $activeProjects ?? 0 ?>,
                <?= $completedProjects ?? 0 ?>,
                <?= $totalProjects ?? 0 - ($activeProjects ?? 0) - ($completedProjects ?? 0) ?>
            ],
            backgroundColor: ['#36A2EB', '#1cc88a', '#f6c23e']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
