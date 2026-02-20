<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><?= __('My Leave Requests') ?></h4>
        <a href="<?= BASE_URL ?>/agent/leaveSubmit" class="btn btn-primary btn-sm"><?= __('Add Leave') ?></a>
    </div>
     <div class="card table-container shadow-sm">

    <table class="table table-bordered table-hover">
        <thead class="table-light text-center">
            <tr>
                <th>#</th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Reason') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Submitted At') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($leaves)): $i=1; ?>
                <?php foreach($leaves as $leave): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($leave['start_date']) ?></td>
                    <td><?= htmlspecialchars($leave['end_date']) ?></td>
                    <td><?= htmlspecialchars($leave['reason']) ?></td>
                    <td class="text-center">
    <span class="badge 
        <?= $leave['status'] === __('Approved') ? 'bg-success' : 
           ($leave['status'] === __('Rejected') ? 'bg-danger' : 'bg-warning text-dark') ?> 
        small px-2 py-1" style="font-size: 0.75rem;">
        <?= htmlspecialchars($leave['status']) ?>
    </span>
</td>

                    <td><?= $leave['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No leave requests yet</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
