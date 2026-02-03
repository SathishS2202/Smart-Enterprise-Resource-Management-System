<?php
// Set page title for layout
$title = "Admin Dashboard";

// Capture the content in a buffer
ob_start();
?>

<div class="sidebar">
    <a href="/admin/dashboard"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
    <a href="/admin/users"><i class="bi bi-people"></i><span>Users</span></a>
    <a href="/admin/projects"><i class="bi bi-folder"></i><span>Projects</span></a>
    <a href="/admin/tasks"><i class="bi bi-list-task"></i><span>Tasks</span></a>
    <a href="/admin/attendance"><i class="bi bi-calendar-check"></i><span>Attendance</span></a>
    <a href="/admin/documents"><i class="bi bi-file-earmark-text"></i><span>Documents</span></a>
    <a href="/admin/client_requests"><i class="bi bi-inbox"></i><span>Client Requests</span></a>
    <a href="/admin/leave_approvals"><i class="bi bi-file-earmark-text"></i><span>Leave Approvals</span></a>
    <a href="/admin/reports"><i class="bi bi-bar-chart"></i><span>Reports</span></a>
    <a href="/admin/profile"><i class="bi bi-person-circle"></i><span>My Profile</span></a>
    <a href="/logout"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>
</div>

<div class="main">
    <div class="header">
        <div class="header-left">
            <h3>Admin Dashboard</h3>
            <div class="role-switch">
                <i class="bi bi-person-lines-fill"></i>
                <select onchange="location.href=this.value">
                    <option selected disabled>Switch Role</option>
                    <option value="/agent/dashboard">Agent View</option>
                    <option value="/client/dashboard">Client View</option>
                </select>
            </div>
        </div>
        <div class="header-right">
            <i class="bi bi-bell"></i>
            <?= $_SESSION['user']['username'] ?? 'Admin'; ?>
        </div>
    </div>

    <div class="main-content">

        <!-- Dashboard Cards -->
        <div class="cards">
            <div class="card"><h5>Total Users</h5><span><?= $totalUsers ?></span></div>
            <div class="card"><h5>Total Agents</h5><span><?= $totalAgents ?></span></div>
            <div class="card"><h5>Total Clients</h5><span><?= $totalClients ?></span></div>
            <div class="card"><h5>Total Projects</h5><span><?= $totalProjects ?></span></div>
            <div class="card"><h5>Pending Leaves</h5><span><?= $pendingLeaves ?></span></div>
            <div class="card"><h5>Pending Requests</h5><span><?= $totalRequests ?></span></div>
        </div>

        <!-- Dashboard Icons -->
        <div class="dashboard-icons">
            <a href="/admin/users" class="icon-box"><i class="bi bi-people"></i><span>Users</span></a>
            <a href="/admin/projects" class="icon-box"><i class="bi bi-folder"></i><span>Projects</span></a>
            <a href="/admin/tasks" class="icon-box"><i class="bi bi-list-task"></i><span>Tasks</span></a>
            <a href="/admin/attendance" class="icon-box"><i class="bi bi-calendar-check"></i><span>Attendance</span></a>
        </div>

        <div class="dashboard-icons">
            <a href="/admin/documents" class="icon-box"><i class="bi bi-file-earmark-text"></i><span>Documents</span></a>
            <a href="/admin/leave_approvals" class="icon-box"><i class="bi bi-file-earmark-text"></i><span>Leave Approvals</span></a>
            <a href="/admin/reports" class="icon-box"><i class="bi bi-bar-chart"></i><span>Reports</span></a>
            <a href="/admin/notifications" class="icon-box"><i class="bi bi-bell"></i><span>Notifications</span></a>
        </div>

        <!-- Task Status Chart -->
        <div class="table-box">
            <h5>Task Status Overview</h5>
            <canvas id="taskPieChart"></canvas>
        </div>

    </div>
</div>

<footer>© 2026 SERMS</footer>

<script>
const ctx = document.getElementById('taskPieChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['To Do', 'In Progress', 'Done'],
        datasets: [{
            data: [<?= $pendingTasks ?>, <?= $inProgressTasks ?>, <?= $doneTasks ?>],
            backgroundColor: ['#f59e0b','#2563eb','#16a34a']
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom' },
            title: { display: false }
        }
    }
});
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>

