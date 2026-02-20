<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <h4 class="mb-4 fw-semibold"><?= __('My Reports Dashboard') ?></h4>

    <!-- ================= TASK REPORTS ================= -->
    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    <?= __('Task Status (Pie)') ?>
                </div>
                <div class="card-body">
                    <canvas id="taskPieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    <?= __('Task Status (Doughnut)') ?>
                </div>
                <div class="card-body">
                    <canvas id="taskDoughnutChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    <?= __('Task Status (Bar)') ?>
                </div>
                <div class="card-body">
                    <canvas id="taskBarChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= ATTENDANCE REPORTS ================= -->
    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    <?= __('Attendance (Pie)') ?>
                </div>
                <div class="card-body">
                    <canvas id="attendancePieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    <?= __('Attendance (Doughnut)') ?>
                </div>
                <div class="card-body">
                    <canvas id="attendanceDoughnutChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    __Attendance (Bar)
                </div>
                <div class="card-body">
                    <canvas id="attendanceBarChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= PROJECT REPORTS ================= -->
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    <?= __('Project Status (Pie)') ?>
                </div>
                <div class="card-body">
                    <canvas id="projectPieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    <?= __('Project Status (Doughnut)') ?>
                </div>
                <div class="card-body">
                    <canvas id="projectDoughnutChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">
                    <?= __('Project Status (Bar)') ?>
                </div>
                <div class="card-body">
                    <canvas id="projectBarChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- ================= CHART JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/* ================= TASK DATA ================= */

const taskLabels = ['Pending', 'Completed'];
const taskData = [
    <?= $pendingTasks ?? 0 ?>,
    <?= $completedTasks ?? 0 ?>
];

const taskColors = ['#fbbf24', '#22c55e'];

/* ================= ATTENDANCE DATA ================= */

const attendanceLabels = ['Present','Absent','Late','Leave'];
const attendanceData = [
    <?= $attendanceData['Present'] ?? 0 ?>,
    <?= $attendanceData['Absent'] ?? 0 ?>,
    <?= $attendanceData['Late'] ?? 0 ?>,
    <?= $attendanceData['Leave'] ?? 0 ?>
];

const attendanceColors = ['#22c55e','#ef4444','#fbbf24','#3b82f6'];

/* ================= PROJECT DATA ================= */

const projectLabels = ['Active','Completed','Pending'];
const projectData = [
    <?= $activeProjects ?? 0 ?>,
    <?= $completedProjects ?? 0 ?>,
    <?= ($totalProjects ?? 0) - ($activeProjects ?? 0) - ($completedProjects ?? 0) ?>
];

const projectColors = ['#3b82f6','#22c55e','#fbbf24'];

/* ================= GENERIC CHART FUNCTION ================= */

function createChart(id, type, labels, data, colors, detailUrl) {
    return new Chart(document.getElementById(id), {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            onClick: (evt, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const label = labels[index];
                    window.location.href = detailUrl + '?status=' + label;
                }
            }
        }
    });
}

/* ================= TASK CHARTS ================= */

createChart('taskPieChart','pie',taskLabels,taskData,taskColors,'<?= BASE_URL ?>/agent/taskDetails');
createChart('taskDoughnutChart','doughnut',taskLabels,taskData,taskColors,'<?= BASE_URL ?>/agent/taskDetails');
createChart('taskBarChart','bar',taskLabels,taskData,taskColors,'<?= BASE_URL ?>/agent/taskDetails');

/* ================= ATTENDANCE CHARTS ================= */

createChart('attendancePieChart','pie',attendanceLabels,attendanceData,attendanceColors,'<?= BASE_URL ?>/agent/attendanceDetails');
createChart('attendanceDoughnutChart','doughnut',attendanceLabels,attendanceData,attendanceColors,'<?= BASE_URL ?>/agent/attendanceDetails');
createChart('attendanceBarChart','bar',attendanceLabels,attendanceData,attendanceColors,'<?= BASE_URL ?>/agent/attendanceDetails');

/* ================= PROJECT CHARTS ================= */

createChart('projectPieChart','pie',projectLabels,projectData,projectColors,'<?= BASE_URL ?>/agent/projectDetails');
createChart('projectDoughnutChart','doughnut',projectLabels,projectData,projectColors,'<?= BASE_URL ?>/agent/projectDetails');
createChart('projectBarChart','bar',projectLabels,projectData,projectColors,'<?= BASE_URL ?>/agent/projectDetails');

</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
