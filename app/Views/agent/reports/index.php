<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">

    <h4 class="mb-4">My Reports</h4>

    <!-- ===== TASKS DISTRIBUTION ===== -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Task Status (Pie)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="taskPieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Task Status (Doughnut)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="taskDoughnutChart"></canvas>
                </div>
                
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Task Status (Bar)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="taskBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ATTENDANCE DISTRIBUTION ===== -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Attendance (Pie)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="attendancePieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Attendance (Doughnut)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="attendanceDoughnutChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Attendance (Bar)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="attendanceBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== PROJECTS DISTRIBUTION ===== -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Project Status (Pie)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="projectPieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Project Status (Doughnut)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="projectDoughnutChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header fw-semibold text-center">
                    Project Status (Bar)
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="projectBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ===== CHART.JS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/* ===== TASK CHARTS ===== */
const taskData = [<?= $pendingTasks ?? 0 ?>, <?= $inProgressTasks ?? 0 ?>, <?= $completedTasks ?? 0 ?>];
const taskLabels = ['Pending', 'In Progress', 'Completed'];
const taskColors = ['#fbbf24', '#3b82f6', '#22c55e'];

// Pie
new Chart(document.getElementById('taskPieChart'), {
    type: 'pie',
    data: { labels: taskLabels, datasets: [{ data: taskData, backgroundColor: taskColors }] },
    options: { responsive: true, maintainAspectRatio: false }
});

// Doughnut
new Chart(document.getElementById('taskDoughnutChart'), {
    type: 'doughnut',
    data: { labels: taskLabels, datasets: [{ data: taskData, backgroundColor: taskColors }] },
    options: { responsive: true, maintainAspectRatio: false }
});

// Bar
new Chart(document.getElementById('taskBarChart'), {
    type: 'bar',
    data: { labels: taskLabels, datasets: [{ label: 'Tasks', data: taskData, backgroundColor: taskColors }] },
    options: { responsive: true, maintainAspectRatio: false }
});

/* ===== ATTENDANCE CHARTS ===== */
const attendanceData = [
    <?= $attendanceData['Present'] ?? 0 ?>,
    <?= $attendanceData['Absent'] ?? 0 ?>,
    <?= $attendanceData['Late'] ?? 0 ?>,
    <?= $attendanceData['Leave'] ?? 0 ?>
];
const attendanceLabels = ['Present', 'Absent', 'Late', 'Leave'];
const attendanceColors = ['#22c55e','#ef4444','#fbbf24','#3b82f6'];

// Pie
new Chart(document.getElementById('attendancePieChart'), {
    type: 'pie',
    data: { labels: attendanceLabels, datasets: [{ data: attendanceData, backgroundColor: attendanceColors }] },
    options: { responsive: true, maintainAspectRatio: false }
});

// Doughnut
new Chart(document.getElementById('attendanceDoughnutChart'), {
    type: 'doughnut',
    data: { labels: attendanceLabels, datasets: [{ data: attendanceData, backgroundColor: attendanceColors }] },
    options: { responsive: true, maintainAspectRatio: false }
});

// Bar
new Chart(document.getElementById('attendanceBarChart'), {
    type: 'bar',
    data: { labels: attendanceLabels, datasets: [{ label: 'Days', data: attendanceData, backgroundColor: attendanceColors }] },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
    }
});

/* ===== PROJECT CHARTS ===== */
const projectData = [<?= $activeProjects ?? 0 ?>, <?= $completedProjects ?? 0 ?>, <?= ($totalProjects ?? 0) - ($activeProjects ?? 0) - ($completedProjects ?? 0) ?>];
const projectLabels = ['Active', 'Completed', 'Pending'];
const projectColors = ['#3b82f6', '#22c55e', '#fbbf24'];

// Pie
new Chart(document.getElementById('projectPieChart'), {
    type: 'pie',
    data: { labels: projectLabels, datasets: [{ data: projectData, backgroundColor: projectColors }] },
    options: { responsive: true, maintainAspectRatio: false }
});

// Doughnut
new Chart(document.getElementById('projectDoughnutChart'), {
    type: 'doughnut',
    data: { labels: projectLabels, datasets: [{ data: projectData, backgroundColor: projectColors }] },
    options: { responsive: true, maintainAspectRatio: false }
});

// Bar
new Chart(document.getElementById('projectBarChart'), {
    type: 'bar',
    data: { labels: projectLabels, datasets: [{ label: 'Projects', data: projectData, backgroundColor: projectColors }] },
    options: { responsive: true, maintainAspectRatio: false }
});
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
