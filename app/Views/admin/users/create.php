<?php require_once BASE_PATH . '/app/Views/layouts/admin_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa; min-height: 85vh;">

<h4>Add New User</h4>

<form method="POST" action="<?= BASE_URL ?>/admin/users/store">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role_id" class="form-control" required>
    <option value="">Select Role</option>
    <?php foreach ($roles as $role): ?>
        <option value="<?= $role['id'] ?>">
            <?= $role['role_name'] ?>
        </option>
    <?php endforeach; ?>
</select>
        </select>
    </div>

    <button class="btn btn-success">Create User</button>
    <a href="<?= BASE_URL ?>/admin/users" class="btn btn-secondary">Back</a>
</form>
</div>
