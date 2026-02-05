<h3>Welcome Admin </h3>

<div class="cards"> <div class="card"><h5>Total Users</h5><span><?= $totalUsers ?></span></div> <div class="card"><h5>Total Agents</h5><span><?= $totalAgents ?></span></div> <div class="card"><h5>Total Clients</h5><span><?= $totalClients ?></span></div> <div class="card"><h5>Total Projects</h5><span><?= $totalProjects ?></span></div> <div class="card"><h5>Pending Leaves</h5><span><?= $pendingLeaves ?></span></div> <div class="card"><h5>Pending Requests</h5><span><?= $totalRequests ?></span></div> </div>
<div class="dashboard-icons mt-4">
    <a href="<?= BASE_URL ?>/admin/users" class="icon-box">
        <i class="bi bi-people"></i><span>Users</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/projects" class="icon-box">
        <i class="bi bi-folder"></i><span>Projects</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/tasks" class="icon-box">
        <i class="bi bi-list-task"></i><span>Tasks</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/attendance" class="icon-box">
        <i class="bi bi-calendar-check"></i><span>Attendance</span>
    </a>
</div>

<div class="dashboard-icons">
    <a href="<?= BASE_URL ?>/admin/documents" class="icon-box">
        <i class="bi bi-file-earmark-text"></i><span>Documents</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/leave_approvals" class="icon-box">
        <i class="bi bi-file-earmark-text"></i><span>Leave Approvals</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/reports" class="icon-box">
        <i class="bi bi-bar-chart"></i><span>Reports</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/notifications" class="icon-box">
        <i class="bi bi-bell"></i><span>Notifications</span>
    </a>
</div>


<div class="table-box">
    <h5>Task Status Overview</h5>
    <canvas id="taskPieChart"></canvas>
</div>

<script>
new Chart(document.getElementById('taskPieChart'), {
    type: 'pie',
    data: {
        labels: ['Pending', 'In Progress', 'Done'],
        datasets: [{
            data: [<?= $pendingTasks ?>, <?= $inProgressTasks ?>, <?= $doneTasks ?>]
        }]
    }
});
</script>
