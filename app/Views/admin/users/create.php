<?php require_once BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa; min-height: 85vh;">

<h4>_<?= __('add_new_user') ?></h4>

<form method="POST" action="<?= BASE_URL ?>/admin/users/store">
    <div class="mb-3">
        <label><?= __('name') ?></label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label><?= __('email') ?></label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label><?= __('username') ?></label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label><?= __('password') ?></label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label><?= __('role') ?></label>
        <select name="role_id" class="form-control" required>
    <option value="">_<?= __('select_role') ?></option>
    <?php foreach ($roles as $role): ?>
        <option value="<?= $role['id'] ?>">
            <?= $role['role_name'] ?>
        </option>
    <?php endforeach; ?>
</select>
        </select>
    </div>

    <button class="btn btn-success">__<?= __('create_user') ?></button>
    <a href="<?= BASE_URL ?>/admin/users" class="btn btn-secondary">__<?= __('back') ?></a>
</form>
</div>
