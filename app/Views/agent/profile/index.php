<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-semibold mb-0"><?= __('My Profile') ?></h5>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="text-center mb-3">
                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                        <h6 class="mt-2 mb-0">
                            <?= htmlspecialchars($user['name'] ?? '') ?>
                        </h6>
                        <small class="text-muted">
                            <?= htmlspecialchars($user['role_name'] ?? 'Agent') ?>
                        </small>
                    </div>

                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="35%"><?= __('Username') ?></th>
                            <td><?= htmlspecialchars($user['username'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Joined On') ?></th>
                            <td><?= isset($user['created_at']) ? date('F j, Y', strtotime($user['created_at'])) : '-' ?></td>
        
                    </table>

                    <div class="d-grid mt-3">
                        <a href="<?= BASE_URL ?>/agent/changePassword"
                           class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-key"></i> <?= __('Change Password') ?>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
