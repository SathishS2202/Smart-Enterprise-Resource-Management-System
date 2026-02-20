<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <h5 class="mb-3"><?= __('change_password') ?></h5>

    <?php if (!empty($_SESSION['profile_msg'])): ?>
        <div class="alert alert-<?= $_SESSION['profile_msg']['type'] ?>">
            <?= htmlspecialchars($_SESSION['profile_msg']['text']) ?>
        </div>
        <?php unset($_SESSION['profile_msg']); ?>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>/admin/changePassword" class="col-md-4">

        <div class="mb-3">
            <label class="form-label"><?= __('current_password') ?></label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?= __('new_password') ?></label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?= __('confirm_new_password') ?></label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button class="btn btn-primary"><?= __('update_password') ?></button>
        <a href="<?= BASE_URL ?>/admin/profile" class="btn btn-secondary ms-2"><?= __('cancel') ?></a>

    </form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
