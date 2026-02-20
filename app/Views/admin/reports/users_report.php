<?php require_once BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold"><?= __('Users Report') ?></h5>

        <!-- Export Button -->
        <a href="<?= BASE_URL ?>/admin/exportUsersReport?role=<?= urlencode($selectedRole ?? '') ?>"
           class="btn btn-sm btn-success">
            <i class="bi bi-download"></i> <?= __('Export CSV') ?>
        </a>
    </div>

    <!-- Filter Info -->
    <div class="mb-3">
        <span class="badge bg-primary">
            <?= __('Role: ' . ($selectedRole ?? 'All')) ?>
        </span>
        <span class="badge bg-dark">
            <?= __('Total Users: ' . count($users ?? [])) ?>
        </span>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Email') ?></th>
                        <th><?= __('Username') ?></th>
                        <th><?= __('Role') ?></th>
                        <th><?= __('Status') ?></th>
                        <th><?= __('Created At') ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?= htmlspecialchars($user['role_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['status'] === 'Active'): ?>
                                        <span class="badge bg-success"><?= __('Active') ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><?= __('Inactive') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                <?= __('No users found.') ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
