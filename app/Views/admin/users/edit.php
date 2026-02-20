<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<!-- FULL WIDTH CONTENT -->
<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa; min-height: 85vh;">

    <div class="row">
        <div class="col-12">

            <!-- PAGE HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border">
                <h5 class="mb-0 fw-normal">_<?= __('edit_user') ?></h5>

                <a href="<?= BASE_URL ?>/admin/users"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> <?= __('back') ?>
                </a>
            </div>

            <!-- FORM CARD (FULL WIDTH, LEFT) -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <form method="post"
                          action="<?= BASE_URL ?>/admin/usersUpdate?id=<?= $user['id'] ?>">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label small"><?= __('name') ?></label>
                                <input type="text" name="name"
                                       class="form-control form-control-sm"
                                       value="<?= htmlspecialchars($user['name']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small"><?= __('username') ?></label>
                                <input type="text" name="username"
                                       class="form-control form-control-sm"
                                       value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small"><?= __('email') ?></label>
                                <input type="email" name="email"
                                       class="form-control form-control-sm"
                                       value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>

                        

                            <div class="col-md-6">
                                <label class="form-label small"><?= __('role') ?></label>
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
    <label class="form-label"><?= __('status') ?></label>
    <select name="status" class="form-select">
        <option value="Active" <?= $user['status'] === 'Active' ? 'selected' : '' ?>>
            _<?= __('active') ?>
        </option>
        <option value="Inactive" <?= $user['status'] === 'Inactive' ? 'selected' : '' ?>>
            <?= __('inactive') ?>
        </option>
    </select>
</div>

                        </div>

                        <!-- ACTIONS -->
                        <div class="mt-4">
                            <button class="btn btn-sm btn-primary">
                                <i class="bi bi-check-circle"></i> <?= __('update_user') ?>
                            </button>

                            <a href="<?= BASE_URL ?>/admin/users"
                               class="btn btn-sm btn-outline-secondary ms-2">
                                <?= __('cancel') ?>
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
