<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid mt-4">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h4 class="mb-2 mb-md-0 text-primary"><?= htmlspecialchars($status) ?> Attendance Records</h4>

        <div class="d-flex gap-2">
            <!-- Export Button -->
            <a href="<?= BASE_URL ?>/agent/attendance/export?status=<?= urlencode($status) ?>" 
               class="btn btn-success btn-sm">
                <i class="bi bi-download"></i> Export
            </a>

            <!-- Back Button -->
            <a href="<?= BASE_URL ?>/agent/reports" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Card Wrapper -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($records)): ?>
                            <?php foreach ($records as $index => $row): ?>
                                <tr class="text-center">
                                    <td><?= $index + 1 ?></td>
                                    <td><?= date('d M Y', strtotime($row['date'])) ?></td>
                                     <td>
    <span class="badge 
        <?= $row['status'] === 'Present' ? 'bg-success' : 
            ($row['status'] === 'Absent' ? 'bg-danger' : 
            ($row['status'] === 'Late' ? 'bg-warning text-dark' : 'bg-info')) ?> 
        py-0 px-1 fs-7">
        <?= $row['status'] ?>
    </span>
</td>


                                    <td>
                                        <?= !empty($row['check_in']) ? date('h:i A', strtotime($row['check_in'])) : '-' ?>
                                    </td>
                                    <td>
                                        <?= !empty($row['check_out']) ? date('h:i A', strtotime($row['check_out'])) : '-' ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['remarks'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i> No attendance records found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
