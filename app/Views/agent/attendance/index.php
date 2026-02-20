<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <h3 class="mb-3"><?= __('My Attendance') ?></h3>

    <!-- =========================
         CHECK IN / CHECK OUT CARD
    ========================== -->
    <div class="card p-3 mb-4 shadow-sm">

        <?php if (empty($today)): ?>

            <!-- CHECK IN -->
            <form method="post" action="<?= BASE_URL ?>/agent/checkIn">
                <button class="btn btn-success btn-sm">
                    <i class="bi bi-box-arrow-in-right"></i> <?= __('Check In') ?>
                </button>
            </form>

        <?php elseif (!empty($today) && empty($today['check_out'])): ?>

            <!-- CHECK OUT -->
            <form method="post" action="<?= BASE_URL ?>/agent/checkOut">
                <button class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-left"></i> <?= __('Check Out') ?>
                </button>
            </form>

        <?php else: ?>

            <div class="alert alert-success mb-0 py-2">
                <i class="bi bi-check-circle-fill"></i>
                <?= __('Attendance completed for today') ?>
            </div>

        <?php endif; ?>

    </div>


    <!-- =========================
         ATTENDANCE TABLE
    ========================== -->
    <div class="card table-container shadow-sm">

        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th><?= __('Date') ?></th>
                    <th><?= __('Check In') ?></th>
                    <th><?= __('Check Out') ?></th>
                    <th><?= __('Working Hours') ?></th>
                    <th><?= __('Status') ?></th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($attendance)): ?>
                <?php 
                $i = 1; 
                foreach ($attendance as $a): 

                    // Calculate working hours
                    $hoursWorked = '-';
                    if (!empty($a['check_in']) && !empty($a['check_out'])) {
                        $start = strtotime($a['check_in']);
                        $end   = strtotime($a['check_out']);
                        $diff  = $end - $start;

                        $hours = floor($diff / 3600);
                        $minutes = floor(($diff % 3600) / 60);

                        $hoursWorked = $hours . "h " . $minutes . "m";
                    }

                    // Status Badge
                    $statusClass =
                        $a['status'] === __('Present')   ? 'bg-success' :
                        ($a['status'] === __('Half Day') ? 'bg-warning text-dark' : 'bg-danger');
                ?>
                    <tr class="text-center">
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($a['date']) ?></td>
                        <td><?= $a['check_in'] ?? '-' ?></td>
                        <td><?= $a['check_out'] ?? '-' ?></td>
                        <td><?= $hoursWorked ?></td>
                        <td>
                            <span class="badge <?= $statusClass ?> px-2 py-1" style="font-size:11px;">
                                <?= htmlspecialchars($a['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        <?= __('No attendance records found') ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>

        </table>

    </div>

</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
