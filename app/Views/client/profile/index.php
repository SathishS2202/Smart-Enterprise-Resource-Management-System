<?php require_once __DIR__ . '/../../layouts/client_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/client_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">

    <h4 class="mb-4">My Profile</h4>

    <?php if (!empty($_SESSION['profile_msg'])): ?>
        <div class="alert alert-success py-2">
            <?= $_SESSION['profile_msg'] ?>
        </div>
        <?php unset($_SESSION['profile_msg']); ?>
    <?php endif; ?>

    <div class="card shadow-sm p-4" style="max-width:600px">

        <form method="post" action="<?= BASE_URL ?>/client/profileUpdate">

            <!-- NAME -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text"
                       name="name"
                       value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                       class="form-control form-control-sm"
                       required>
            </div>

            <!-- EMAIL (READ ONLY) -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email"
                       value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                       class="form-control form-control-sm"
                       readonly>
            </div>

           

            <!-- ROLE -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
                <input type="text"
                       value="<?= htmlspecialchars($user['role'] ?? 'Client') ?>"
                       class="form-control form-control-sm"
                       readonly>
            </div>

            <button class="btn btn-primary btn-sm px-4">
                Update Profile
            </button>

        </form>
    </div>

</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
