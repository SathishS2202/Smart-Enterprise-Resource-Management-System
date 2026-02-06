<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <h5 class="mb-3">Edit Attendance</h5>

    <form method="post" action="<?= BASE_URL ?>/admin/attendanceUpdate?id=<?= $attendance['id'] ?>">

        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control form-control-sm" required>
                <?php foreach($users as $u): ?>
                    <option value="<?= $u['id'] ?>"
                        <?= $attendance['user_id']==$u['id']?'selected':'' ?>>
                        <?= htmlspecialchars($u['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control form-control-sm"
                   value="<?= $attendance['date'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control form-control-sm">
                <?php foreach(['Present','Absent','Late','Leave'] as $s): ?>
                    <option value="<?= $s ?>" <?= $attendance['status']==$s?'selected':'' ?>>
                        <?= $s ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control form-control-sm"><?= htmlspecialchars($attendance['remarks'] ?? '') ?></textarea>
        </div>

        <button class="btn btn-sm btn-primary">Update</button>
        <a href="<?= BASE_URL ?>/admin/attendance" class="btn btn-sm btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
