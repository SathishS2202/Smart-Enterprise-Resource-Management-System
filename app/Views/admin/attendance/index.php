<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">_<?= __('Attendance') ?></h5>
        <a href="<?= BASE_URL ?>/admin/attendanceCreate" class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> <?= __('add_attendance') ?>
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
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th><?= __('users') ?></th>
                    <th><?= __('date') ?></th>
                    <th><?= __('status') ?></th>
                    <th><?= __('actions') ?></th>
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
switch ($a['status']) {
    case 'Present':
        echo "<span class='badge bg-success px-2 py-1 mt-2' style='font-size:11px;'>__" . __('Present') . "</span>";
        break;

    case 'Absent':
        echo "<span class='badge bg-danger px-2 py-1 mt-2' style='font-size:11px;'>__" . __('Absent') . "</span>";
        break;

    case 'Late':
        echo "<span class='badge bg-warning text-dark px-2 py-1 mt-2' style='font-size:11px;'>__" . __('Late') . "</span>";
        break;

    case 'Leave':
        echo "<span class='badge bg-info text-dark px-2 py-1 mt-2' style='font-size:11px;'>__" . __('Leave') . "</span>";
        break;

    default:
        echo "<span class='badge bg-secondary px-2 py-1 mt-2' style='font-size:11px;'>Unknown</span>";
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
                    <tr><td colspan="5" class="text-center text-muted"><?= __('no_records_found') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
