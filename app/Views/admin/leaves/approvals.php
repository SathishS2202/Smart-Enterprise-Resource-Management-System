<?php require_once BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">

    <h4 class="mb-4"><?= __('leave_approvals') ?></h4>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th><?= __('user') ?></th>
                    <th><?= __('start_date') ?></th>
                    <th><?= __('end_date') ?></th>
                    <th><?= __('reason') ?></th>
                    <th><?= __('status') ?></th>
                    <th><?= __('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($leaves)): ?>
                    <?php foreach ($leaves as $index => $leave): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($leave['user_name']) ?></td>
                            <td><?= htmlspecialchars($leave['start_date']) ?></td>
                            <td><?= htmlspecialchars($leave['end_date']) ?></td>
                            <td><?= htmlspecialchars($leave['reason']) ?></td>
                            <td class="text-center">
    <?php
    switch ($leave['status'] ?? 'Pending') {
        case 'Pending':
            echo "<span class='badge bg-warning text-dark small'>Pending</span>";
            break;
        case 'Approved':
            echo "<span class='badge bg-success small'>Approved</span>";
            break;
        case 'Rejected':
            echo "<span class='badge bg-danger small'>Rejected</span>";
            break;
        default:
            echo "<span class='badge bg-secondary small'>Unknown</span>";
    }
    ?>
</td>

                            <td>
    <form method="post" action="<?= BASE_URL ?>/admin/leave_update" class="d-inline">
        <input type="hidden" name="leave_id" value="<?= $leave['id'] ?>">
        <input type="hidden" name="action" value="Approved">
        <button type="submit" class="btn btn-sm btn-success"><?= __('approve') ?></button>
    </form>
    <form method="post" action="<?= BASE_URL ?>/admin/leave_update" class="d-inline">
        <input type="hidden" name="leave_id" value="<?= $leave['id'] ?>">
        <input type="hidden" name="action" value="Rejected">
        <button type="submit" class="btn btn-sm btn-danger"><?= __('reject') ?></button>
    </form>
</td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted"><?= __('no_pending_leave_requests') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
