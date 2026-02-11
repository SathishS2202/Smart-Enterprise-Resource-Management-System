<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <!-- PAGE TITLE (TOP, LEFT) -->
    <!-- PAGE TITLE BAR -->
<div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">

    <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">
        Users Management
    </h5>

    <a href="<?= BASE_URL ?>/admin/usersCreate"
       class="btn btn-sm btn-primary px-3">
        <i class="bi bi-person-plus"></i> Add User
    </a>

</div>

    <!-- FLASH MESSAGE -->
    <?php if (!empty($_SESSION['user_msg'])): ?>
        <div class="alert alert-<?= $_SESSION['user_msg']['type'] === 'success' ? 'success' : 'danger' ?> py-2">
            <?= $_SESSION['user_msg']['text'] ?>
        </div>
        <?php unset($_SESSION['user_msg']); ?>
    <?php endif; ?>

    <!-- SEARCH -->
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" id="userSearch"
                   class="form-control form-control-sm"
                   placeholder="Search users...">
        </div>
    </div>

    <!-- TABLE (FULL WIDTH, LEFT ALIGNED) -->
    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle w-100">

            <thead class="table-light text-center">
                <tr>
                    <th style="width:50px">#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th style="width:120px">Role</th>
                    <th style="width:120px">Status</th>
                    <th style="width:160px">Actions</th>
                </tr>
            </thead>

            <tbody>
<?php if (!empty($users)): ?>
    <?php foreach ($users as $index => $user): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>

            <!-- ROLE -->
            <td class="small">
                <?= htmlspecialchars($user['role_name']) ?>
            </td>

            <!-- STATUS -->
            <td class="small">
                <?= htmlspecialchars($user['status']) ?>

            </td>

            <!-- ACTIONS (THIS MUST BE INSIDE THE LOOP) -->
            <td class="text-start">

                <!-- ENABLE / DISABLE -->
                <?php if ($user['status'] === 'Active'): ?>
    <a href="<?= BASE_URL ?>/admin/userStatus?id=<?= $user['id'] ?>&status=Inactive"
       class="btn btn-sm btn-outline-secondary me-1"
       onclick="return confirm('Disable this user?')">
        <i class="bi bi-person-x"></i>
    </a>
<?php else: ?>
    <a href="<?= BASE_URL ?>/admin/userStatus?id=<?= $user['id'] ?>&status=Active"
       class="btn btn-sm btn-outline-success me-1"
       onclick="return confirm('Enable this user?')">
        <i class="bi bi-person-check"></i>
    </a>
<?php endif; ?>


                <!-- EDIT -->
                <a href="<?= BASE_URL ?>/admin/usersEdit?id=<?= $user['id'] ?>"
                   class="btn btn-sm btn-outline-primary me-1">
                    <i class="bi bi-pencil"></i>
                </a>

                <!-- DELETE -->
                <a href="<?= BASE_URL ?>/admin/usersDelete?id=<?= $user['id'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Delete this user permanently?')">
                    <i class="bi bi-trash"></i>
                </a>

            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="text-center text-muted">No users found</td>
    </tr>
<?php endif; ?>
</tbody>


        </table>
    </div>
</div>

<!-- SEARCH SCRIPT -->
<script>
document.getElementById('userSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
