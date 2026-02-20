<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <h4><?= __('add_attendance') ?></h4>
    <form method="post" action="<?= BASE_URL ?>/admin/attendanceStore">
        <div class="mb-3">
            <label><?= __('users') ?></label>
            <select name="user_id" class="form-control" required>
                <option value="">Select User</option>
                <?php foreach($users as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label><?= __('date') ?></label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label><?= __('status') ?></label>
            <select name="status" class="form-control" required>
                <option value="Present"><?= __('present') ?></option>
                <option value="Absent"><?= __('absent') ?></option>
                <option value="Late"><?= __('late') ?></option>
                <option value="Leave"><?= __('leave') ?></option>
            </select>
        </div>

        <button type="submit" class="btn btn-success"><?= __('add') ?></button>
        <a href="<?= BASE_URL ?>/admin/attendance" class="btn btn-secondary ms-2"><?= __('cancel') ?></a>
    </form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
