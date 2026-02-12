<?php require_once BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold">Projects Report</h5>

        <a href="<?= BASE_URL ?>/admin/exportProjectsReport?status=<?= urlencode($selectedStatus ?? '') ?>"
           class="btn btn-sm btn-success">
            <i class="bi bi-download"></i> Export CSV
        </a>
    </div>

    <div class="mb-3">
        <span class="badge bg-primary">
            Status: <?= htmlspecialchars($selectedStatus ?? 'All') ?>
        </span>
        <span class="badge bg-dark">
            Total Projects: <?= count($projects ?? []) ?>
        </span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Project Name</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Deadline</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
<?php if (!empty($projects)): ?>
    <?php foreach ($projects as $project): ?>
        <tr>
            <td><?= $project['id'] ?></td>

            <td><?= htmlspecialchars($project['name']) ?></td>

            <td><?= htmlspecialchars($project['client_name'] ?? 'N/A') ?></td>

            <td>
                <span class="badge bg-info">
                    <?= $project['status'] ?>
                </span>
            </td>

            <td><?= $project['start_date'] ?? '-' ?></td>

            <td><?= $project['end_date'] ?? '-' ?></td>

            <td><?= $project['created_at'] ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="text-center text-muted">
            No projects found for this status
        </td>
    </tr>
<?php endif; ?>
</tbody>

            </table>

        </div>
    </div>

</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
