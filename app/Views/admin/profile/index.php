<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-semibold mb-0">My Profile</h5>

        <!-- Logout -->
       <a href="<?= BASE_URL ?>/admin/logout" 
   class="btn btn-danger"
   onclick="return confirm('Are you sure you want to logout?')">
   Logout
</a>

    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="text-center mb-3">
                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                        <h6 class="mt-2 mb-0"><?= htmlspecialchars($user['name'] ?? '') ?></h6>
                        <small class="text-muted"><?= htmlspecialchars($user['role_name'] ?? '') ?></small>
                    </div>

                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="35%">Username</th>
                            <td><?= htmlspecialchars($user['username'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php if(($user['status'] ?? '') === 'Active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>

                    <div class="d-grid mt-3">
                        <a href="<?= BASE_URL ?>/admin/changePassword" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-key"></i> Change Password
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
