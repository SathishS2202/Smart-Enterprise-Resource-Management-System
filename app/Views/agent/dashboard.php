
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>

<div class="container-fluid px-4 pt-4">

    <h3>Welcome <?= htmlspecialchars($_SESSION['name'] ?? 'Agent') ?></h3>

    <!-- Dashboard Cards -->
    <div class="cards mt-3">
        <div class="card">
            <h5>Total Tasks</h5>
            <span><?= $totalTasks ?? 0 ?></span>
        </div>
        <div class="card">
            <h5>Pending Tasks</h5>
            <span><?= $pendingTasks ?? 0 ?></span>
        </div>
        <div class="card">
            <h5>Completed Tasks</h5>
            <span><?= $completed ?? 0 ?></span>
        </div>
        <div class="card">
            <h5>Today's Attendance</h5>
            <span><?= htmlspecialchars($todayAttendance ?? 'Not Marked') ?></span>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="dashboard-icons mt-4">
        <a href="<?= BASE_URL ?>/agent/tasks" class="icon-box">
            <i class="bi bi-list-task"></i><span>My Tasks</span>
        </a>

        <a href="<?= BASE_URL ?>/agent/projects" class="icon-box">
            <i class="bi bi-folder"></i><span>Projects</span>
        </a>

        <a href="<?= BASE_URL ?>/agent/attendance" class="icon-box">
            <i class="bi bi-calendar-check"></i><span>Attendance</span>
        </a>

        <a href="<?= BASE_URL ?>/agent/reports" class="icon-box">
            <i class="bi bi-bar-chart"></i><span>Reports</span>
        </a>
    </div>

    <!-- Task Status Pie Chart -->
    <div class="table-box mt-4">
        <h5>Task Status Overview</h5>
        <canvas id="taskPieChart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('taskPieChart'), {
    type: 'pie',
    data: {
        labels: ['Pending', 'Completed'],
        datasets: [{
            label: 'Tasks',
            data: [<?= $pendingTasks ?? 0 ?>, <?= $completed ?? 0 ?>],
            backgroundColor: ['#f6c23e', '#1cc88a']
        }]
    },
    options: {
        responsive: true
    }
});
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
