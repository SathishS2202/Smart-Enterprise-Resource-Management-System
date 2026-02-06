<div class="container-fluid px-4 py-3">

    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">Reports</h5>
        
    </div>

    <!-- SUMMARY CARDS -->
    <div class="row g-4 mb-4">

    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header fw-semibold text-center">
                Users by Role
            </div>
            <div class="card-body d-flex justify-content-center align-items-center"
                 style="height:320px;">
                <canvas id="usersByRole"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header fw-semibold text-center">
                Weekly User Growth
            </div>
            <div class="card-body d-flex justify-content-center align-items-center"
                 style="height:320px;">
                <canvas id="userGrowth"></canvas>
            </div>
        </div>
    </div>

</div>
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header fw-semibold text-center">
                Project Status
            </div>
            <div class="card-body d-flex align-items-center justify-content-center"
                 style="height:320px;">
                <canvas id="projectStatus"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header fw-semibold text-center">
                Projects per Agent
            </div>
            <div class="card-body d-flex align-items-center justify-content-center"
                 style="height:320px;">
                <canvas id="projectAgent"></canvas>
            </div>
        </div>
    </div>
</div>


    <!-- CHARTS -->
    <div class="row g-4">

        <!-- USERS BY ROLE -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Users by Role</div>
                <div class="card-body">
                    <canvas id="usersByRole"></canvas>
                </div>
            </div>
        </div>

        <!-- PROJECT STATUS -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Projects by Status</div>
                <div class="card-body">
                    <canvas id="projectsByStatus"></canvas>
                </div>
            </div>
        </div>

        <!-- TASK STATUS -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Tasks by Status</div>
                <div class="card-body">
                    <canvas id="tasksByStatus"></canvas>
                </div>
            </div>
        </div>

        <!-- ATTENDANCE -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Attendance Summary</div>
                <div class="card-body">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ===== USERS BY ROLE ===== */
const usersByRoleCtx = document.getElementById('usersByRole');
if (usersByRoleCtx) {
    new Chart(usersByRoleCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($rolesData ?? [], 'role_name')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($rolesData ?? [], 'total')) ?>
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

/* ===== PROJECT STATUS ===== */
const projectsByStatusCtx = document.getElementById('projectsByStatus');
if (projectsByStatusCtx) {
    new Chart(projectsByStatusCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($projectStatus ?? [], 'status')) ?>,
            datasets: [{
                label: 'Projects',
                data: <?= json_encode(array_column($projectStatus ?? [], 'total')) ?>
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

/* ===== TASK STATUS ===== */
const tasksByStatusCtx = document.getElementById('tasksByStatus');
if (tasksByStatusCtx) {
    new Chart(tasksByStatusCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($taskStatus ?? [], 'status')) ?>,
            datasets: [{
                label: 'Tasks',
                data: <?= json_encode(array_column($taskStatus ?? [], 'total')) ?>
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

/* ===== ATTENDANCE ===== */
const attendanceCtx = document.getElementById('attendanceChart');
if (attendanceCtx) {
    new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_column($attendanceStats ?? [], 'status')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($attendanceStats ?? [], 'total')) ?>
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}
</script>

