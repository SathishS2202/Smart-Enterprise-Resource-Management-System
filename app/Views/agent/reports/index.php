<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">
    <h4 class="mb-4">My Reports</h4>

    <div class="row">
        <!-- TASK PIE CHART -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="mb-3">Task Status</h6>
                <canvas id="taskChart"></canvas>
            </div>
        </div>

        <!-- ATTENDANCE BAR CHART -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="mb-3">Attendance Overview</h6>
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// TASK PIE CHART
new Chart(document.getElementById('taskChart'), {
    type: 'pie',
    data: {
        labels: ['Pending', 'Completed'],
        datasets: [{
            data: [<?= $pendingTasks ?>, <?= $completedTasks ?>],
            backgroundColor: ['#fbbf24', '#22c55e']
        }]
    }
});

// ATTENDANCE BAR CHART
new Chart(document.getElementById('attendanceChart'), {
    type: 'bar',
    data: {
        labels: ['Present', 'Absent', 'Late', 'Leave'],
        datasets: [{
            label: 'Days',
            data: [
                <?= $attendanceData['Present'] ?>,
                <?= $attendanceData['Absent'] ?>,
                <?= $attendanceData['Late'] ?>,
                <?= $attendanceData['Leave'] ?>
            ],
            backgroundColor: '#3b82f6'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
