<?php require_once BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 py-3">

    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">Reports</h5>
    </div>

    <!-- ======================= USERS REPORTS ======================= -->
    <h6 class="mt-3 mb-2">Users Distribution</h6>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Pie Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="usersPie"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Doughnut Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="usersDoughnut"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Bar Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="usersBar"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================= PROJECTS REPORTS ======================= -->
    <h6 class="mt-3 mb-2">Projects Distribution</h6>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Pie Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="projectsPie"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Doughnut Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="projectsDoughnut"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Bar Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="projectsBar"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================= TASKS REPORTS ======================= -->
    <h6 class="mt-3 mb-2">Tasks Distribution</h6>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Pie Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="tasksPie"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Doughnut Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="tasksDoughnut"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center fw-semibold">Bar Chart</div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height:250px;">
                    <canvas id="tasksBar"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/* ===== USERS CHARTS ===== */
const rolesLabels = <?= json_encode(array_column($rolesData ?? [], 'role_name')) ?>;
const rolesDataSet = <?= json_encode(array_column($rolesData ?? [], 'total')) ?>;

['usersPie','usersDoughnut','usersBar'].forEach(id => {
    const ctx = document.getElementById(id);
    if(ctx){
        new Chart(ctx, {
            type: id.includes('Bar') ? 'bar' : (id.includes('Doughnut') ? 'doughnut' : 'pie'),
            data: { labels: rolesLabels, datasets: [{ data: rolesDataSet, backgroundColor: ['#007bff','#28a745','#dc3545','#ffc107'] }] },
            options: { responsive:true, maintainAspectRatio:false }
        });
    }
});

/* ===== PROJECTS CHARTS ===== */
const projectLabels = <?= json_encode(array_column($projectStatus ?? [], 'status')) ?>;
const projectDataSet = <?= json_encode(array_column($projectStatus ?? [], 'total')) ?>;

['projectsPie','projectsDoughnut','projectsBar'].forEach(id => {
    const ctx = document.getElementById(id);
    if(ctx){
        new Chart(ctx, {
            type: id.includes('Bar') ? 'bar' : (id.includes('Doughnut') ? 'doughnut' : 'pie'),
            data: { labels: projectLabels, datasets: [{ data: projectDataSet, backgroundColor: ['#007bff','#28a745','#dc3545','#ffc107'] }] },
            options: { responsive:true, maintainAspectRatio:false }
        });
    }
});

/* ===== TASKS CHARTS ===== */
const taskLabels = <?= json_encode(array_column($taskStatus ?? [], 'status')) ?>;
const taskDataSet = <?= json_encode(array_column($taskStatus ?? [], 'total')) ?>;

['tasksPie','tasksDoughnut','tasksBar'].forEach(id => {
    const ctx = document.getElementById(id);
    if(ctx){
        new Chart(ctx, {
            type: id.includes('Bar') ? 'bar' : (id.includes('Doughnut') ? 'doughnut' : 'pie'),
            data: { labels: taskLabels, datasets: [{ data: taskDataSet, backgroundColor: ['#007bff','#28a745','#dc3545','#ffc107'] }] },
            options: { responsive:true, maintainAspectRatio:false }
        });
    }
});
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
