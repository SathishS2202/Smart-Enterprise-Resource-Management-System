<?php require_once __DIR__ . '/../../layouts/client_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/client_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">

<h4 class="mb-4"><?= __('Reports & Analytics') ?></h4>

<!-- ================= TASKS DISTRIBUTION ================= -->
<h6 class="fw-semibold mb-2"><?= __('Tasks Distribution') ?></h6>
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="tasksDoughnut"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="tasksPie"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="tasksBar"></canvas>
        </div>
    </div>

</div>

<!-- ================= PROJECTS DISTRIBUTION ================= -->
<h6 class="fw-semibold mb-2"><?= __('Projects Distribution') ?></h6>
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="projectsDoughnut"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="projectsPie"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="projectsBar"></canvas>
        </div>
    </div>

</div>

<!-- ================= PROGRESS TRENDS ================= -->
<h6 class="fw-semibold mb-2"><?= __('Overall Progress') ?></h6>
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="progressLine"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="progressArea"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <canvas id="progressBar"></canvas>
        </div>
    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ================= TASK DATA ================= */
const taskData = {
    labels: ['Completed','Pending'],
    datasets: [{
        data: [<?= $completedTasks ?>, <?= $pendingTasks ?>],
        backgroundColor: ['#16a34a','#facc15']
    }]
};

new Chart(tasksDoughnut,{ type:'doughnut', data: taskData });
new Chart(tasksPie,{ type:'pie', data: taskData });
new Chart(tasksBar,{
    type:'bar',
    data:{
        labels: taskData.labels,
        datasets:[{
            label:'Tasks',
            data: taskData.datasets[0].data,
            backgroundColor:['#16a34a','#facc15']
        }]
    }
});

/* ================= PROJECT DATA ================= */
const projectData = {
    labels:['Active','Completed'],
    datasets:[{
        data:[<?= $activeProjects ?>, <?= $completedProjects ?>],
        backgroundColor:['#3b82f6','#22c55e']
    }]
};

new Chart(projectsDoughnut,{ type:'doughnut', data: projectData });
new Chart(projectsPie,{ type:'pie', data: projectData });
new Chart(projectsBar,{
    type:'bar',
    data:{
        labels: projectData.labels,
        datasets:[{
            label:'Projects',
            data: projectData.datasets[0].data,
            backgroundColor:['#3b82f6','#22c55e']
        }]
    }
});

/* ================= PROGRESS DATA ================= */
const progressLabels = ['Week 1','Week 2','Week 3','Week 4'];
const progressValues = [20,40,65,90];

new Chart(progressLine,{
    type:'line',
    data:{ labels:progressLabels,
        datasets:[{
            label:'Progress %',
            data:progressValues,
            borderColor:'#6366f1',
            tension:.4
        }]
    }
});

new Chart(progressArea,{
    type:'line',
    data:{ labels:progressLabels,
        datasets:[{
            label:'Progress %',
            data:progressValues,
            borderColor:'#6366f1',
            backgroundColor:'rgba(99,102,241,0.3)',
            fill:true,
            tension:.4
        }]
    }
});

new Chart(progressBar,{
    type:'bar',
    data:{
        labels:progressLabels,
        datasets:[{
            label:'Progress %',
            data:progressValues,
            backgroundColor:'#6366f1'
        }]
    }
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
