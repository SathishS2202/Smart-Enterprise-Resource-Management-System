<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">
    <h3>My Attendance</h3>

    <!-- CHECK IN / OUT -->
    <div class="mb-3">
       <?php if (empty($today)): ?>
<form method="post" action="<?= BASE_URL ?>/agent/checkIn">
    <button class="btn btn-success mb-3">
        <i class="bi bi-check-circle"></i> Check In
    </button>
</form>
<?php else: ?>
<div class="alert alert-success">
    ✅ Attendance already marked for today
</div>
<?php endif; ?>

    </div>

    <!-- TABLE -->
    <div class="card table-container">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($attendance)):
                $i = 1;
                foreach ($attendance as $a): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $a['date'] ?></td>
                    <td><?= $a['check_in'] ?? '-' ?></td>
                    <td><?= $a['check_out'] ?? '-' ?></td>
                    <td>
                        <span class="badge 
                            <?= $a['status']=='Present' ? 'bg-success' :
                               ($a['status']=='Half Day' ? 'bg-warning' : 'bg-danger') ?>">
                            <?= $a['status'] ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No attendance records found
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
