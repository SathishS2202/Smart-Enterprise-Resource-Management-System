<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">Attendance</h5>
        <a href="<?= BASE_URL ?>/admin/attendanceCreate" class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> Add Attendance
        </a>
    </div>

    <?php if(!empty($_SESSION['attendance_msg'])): ?>
        <div class="alert alert-<?= $_SESSION['attendance_msg']['type']==='success'?'success':'danger' ?> py-2">
            <?= htmlspecialchars($_SESSION['attendance_msg']['text']) ?>
        </div>
        <?php unset($_SESSION['attendance_msg']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($attendances)): ?>
                    <?php foreach($attendances as $index => $a): ?>
                        <tr>
                            <td><?= $index+1 ?></td>
                            <td><?= htmlspecialchars($a['user_name'] ?? 'Unknown') ?></td>
                            <td><?= htmlspecialchars($a['date']) ?></td>
                            <td class="text-center">
                                <?php
                                switch($a['status']) {
                                    case 'Pending': echo "<span class='badge bg-warning text-dark'>Pending</span>"; break;
                                    case 'In Progress': echo "<span class='badge bg-primary text-white'>In Progress</span>"; break;
                                    case 'Completed': echo "<span class='badge bg-success text-white'>Completed</span>"; break;
                                    case 'On Hold': echo "<span class='badge bg-secondary text-white'>On Hold</span>"; break;
                                    default: echo "<span class='badge bg-light text-dark'>Unknown</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>/admin/attendanceEdit?id=<?= $a['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/admin/attendanceDelete?id=<?= $a['id'] ?>" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-muted">No records found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
