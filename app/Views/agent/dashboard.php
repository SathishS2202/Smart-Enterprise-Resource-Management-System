<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>

<div class="container-fluid px-4 pt-3">

    <h3>Welcome <?= htmlspecialchars($_SESSION['name'] ?? 'Agent') ?></h3>

    <!-- ===== DASHBOARD CARDS ===== -->
    <div class="row g-4 mt-3">

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6>Total Tasks</h6>
                <h3><?= $totalTasks ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6>Pending Tasks</h6>
                <h3><?= $pendingTasks ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6>In Progress</h6>
                <h3><?= $inProgressTasks ?? 0 ?></h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6>Pending Leaves</h6>
                <h3><?= $pendingLeaves ?? 0 ?></span></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6>Completed Tasks</h6>
                <h3><?= $completed ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6>Overdue Tasks</h6>
                <h3><?= $overdueTasks ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6>Total Projects</h6>
                <h3><?= $totalProjects ?? 0 ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm p-3 text-center">
                <h6>Today's Attendance</h6>
                <h3><?= htmlspecialchars($todayAttendance ?? '-') ?></h3>
            </div>
        </div>

    </div>

    <!-- ===== QUICK LINKS ===== -->
    <div class="row g-3 mt-4">

        <div class="col-md-3 col-sm-6">
            <a href="<?= BASE_URL ?>/agent/tasks" class="icon-box text-center shadow-sm p-3 d-block rounded">
                <i class="bi bi-list-task fs-2 text-primary"></i>
                <span class="d-block mt-2">My Tasks</span>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="<?= BASE_URL ?>/agent/projects" class="icon-box text-center shadow-sm p-3 d-block rounded">
                <i class="bi bi-folder fs-2 text-success"></i>
                <span class="d-block mt-2">Projects</span>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="<?= BASE_URL ?>/agent/attendance" class="icon-box text-center shadow-sm p-3 d-block rounded">
                <i class="bi bi-calendar-check fs-2 text-warning"></i>
                <span class="d-block mt-2">Attendance</span>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="<?= BASE_URL ?>/agent/reports" class="icon-box text-center shadow-sm p-3 d-block rounded">
                <i class="bi bi-bar-chart fs-2 text-danger"></i>
                <span class="d-block mt-2">Reports</span>
            </a>
        </div>
        

       
    </div>



</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('taskPieChart'), {
    type: 'pie',
    data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
            label: 'Tasks',
            data: [
                <?= $pendingTasks ?? 0 ?>,
                <?= $inProgressTasks ?? 0 ?>,
                <?= $completed ?? 0 ?>
            ],
            backgroundColor: ['#f6c23e', '#36A2EB', '#1cc88a']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
