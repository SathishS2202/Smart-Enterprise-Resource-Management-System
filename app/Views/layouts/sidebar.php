<!-- <?php
use Core\Session;
$user = $user ?? Session::get('user'); // Either use passed variable or session directly
$role = $user['role'] ?? '';
?>

<div class="sidebar">
    <a href="<?= BASE_URL ?>/<?= strtolower($role) ?>/dashboard"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>

    <?php if($role === 'Admin'): ?>
        <a href="<?= BASE_URL ?>/admin/users"><i class="bi bi-people"></i><span>Users</span></a>
        <a href="<?= BASE_URL ?>/admin/projects"><i class="bi bi-folder"></i><span>Projects</span></a>
        <a href="<?= BASE_URL ?>/admin/tasks"><i class="bi bi-list-task"></i><span>Tasks</span></a>
        <a href="<?= BASE_URL ?>/admin/attendance"><i class="bi bi-calendar-check"></i><span>Attendance</span></a>
        <a href="<?= BASE_URL ?>/admin/documents"><i class="bi bi-file-earmark-text"></i><span>Documents</span></a>
        <a href="<?= BASE_URL ?>/admin/leave_approvals"><i class="bi bi-file-earmark-text"></i><span>Leave Approvals</span></a>
        <a href="<?= BASE_URL ?>/admin/reports"><i class="bi bi-bar-chart"></i><span>Reports</span></a>
    <?php elseif($role === 'Agent'): ?>
        <a href="<?= BASE_URL ?>/agent/tasks"><i class="bi bi-list-task"></i><span>My Tasks</span></a>
        <a href="<?= BASE_URL ?>/agent/attendance"><i class="bi bi-calendar-check"></i><span>Attendance</span></a>
        <a href="<?= BASE_URL ?>/agent/documents"><i class="bi bi-file-earmark-text"></i><span>Documents</span></a>
    <?php elseif($role === 'Client'): ?>
        <a href="<?= BASE_URL ?>/client/projects"><i class="bi bi-folder"></i><span>My Projects</span></a>
        <a href="<?= BASE_URL ?>/client/requests"><i class="bi bi-inbox"></i><span>Requests</span></a>
    <?php endif; ?>

    <a href="<?= BASE_URL ?>/auth/logout"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>
</div> -->
