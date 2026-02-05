<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<!-- FULL WIDTH CONTENT -->
<div class="container-fluid px-4 py-3">

    <div class="row">
        <div class="col-12">

            <!-- PAGE HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border">
                <h5 class="mb-0 fw-normal">Edit User</h5>

                <a href="<?= BASE_URL ?>/admin/users"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <!-- FORM CARD (FULL WIDTH, LEFT) -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <form method="post"
                          action="<?= BASE_URL ?>/admin/usersUpdate?id=<?= $user['id'] ?>">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label small">Name</label>
                                <input type="text" name="name"
                                       class="form-control form-control-sm"
                                       value="<?= htmlspecialchars($user['name']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Username</label>
                                <input type="text" name="username"
                                       class="form-control form-control-sm"
                                       value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Email</label>
                                <input type="email" name="email"
                                       class="form-control form-control-sm"
                                       value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>

                        

                            <div class="col-md-6">
                                <label class="form-label small">Role</label>
                                <select name="role_id"
                                        class="form-select form-select-sm">
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['id'] ?>"
                                            <?= $role['id'] == $user['role_id'] ? 'selected' : '' ?>>
                                            <?= $role['role_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="Active" <?= $user['status'] === 'Active' ? 'selected' : '' ?>>
            Active
        </option>
        <option value="Inactive" <?= $user['status'] === 'Inactive' ? 'selected' : '' ?>>
            Inactive
        </option>
    </select>
</div>

                        </div>

                        <!-- ACTIONS -->
                        <div class="mt-4">
                            <button class="btn btn-sm btn-primary">
                                <i class="bi bi-check-circle"></i> Update User
                            </button>

                            <a href="<?= BASE_URL ?>/admin/users"
                               class="btn btn-sm btn-outline-secondary ms-2">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
