
<?php require_once BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>
<h3><?= __('welcome_admin') ?></h3>

<div class="cards"> <div class="card"><h5><?= __('total_users') ?></h5><span><?= $totalUsers ?></span></div> <div class="card"><h5><?= __('total_agents') ?></h5><span><?= $totalAgents ?></span></div> <div class="card"><h5><?= __('total_clients') ?></h5><span><?= $totalClients ?></span></div> <div class="card"><h5><?= __('total_projects') ?></h5><span><?= $totalProjects ?></span></div> <div class="card"><h5><?= __('pending_leaves') ?></h5><span><?= $pendingLeaves ?></span></div> <div class="card"><h5><?= __('pending_requests') ?></h5><span><?= $totalRequests ?></span></div> </div>
<div class="dashboard-icons mt-4">
    <a href="<?= BASE_URL ?>/admin/users" class="icon-box">
        <i class="bi bi-people"></i><span><?= __('users') ?></span>
    </a>

    <a href="<?= BASE_URL ?>/admin/projects" class="icon-box">
        <i class="bi bi-folder"></i><span><?= __('projects') ?></span>
    </a>

    <a href="<?= BASE_URL ?>/admin/tasks" class="icon-box">
        <i class="bi bi-list-task"></i><span><?= __('tasks') ?></span>
    </a>

    <a href="<?= BASE_URL ?>/admin/attendance" class="icon-box">
        <i class="bi bi-calendar-check"></i><span><?= __('attendance') ?></span>
    </a>
</div>

<div class="dashboard-icons">
    <a href="<?= BASE_URL ?>/admin/documents" class="icon-box">
        <i class="bi bi-file-earmark-text"></i><span><?= __('documents') ?></span>
    </a>

    <a href="<?= BASE_URL ?>/admin/leave_approvals" class="icon-box">
        <i class="bi bi-file-earmark-text"></i><span><?= __('leave_approvals') ?></span>
    </a>

    <a href="<?= BASE_URL ?>/admin/reports" class="icon-box">
        <i class="bi bi-bar-chart"></i><span><?= __('reports') ?></span>
    </a>

    <a href="<?= BASE_URL ?>/admin/email" class="icon-box">
        <i class="bi bi-envelope"></i><span><?= __('email') ?></span>
    </a>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

