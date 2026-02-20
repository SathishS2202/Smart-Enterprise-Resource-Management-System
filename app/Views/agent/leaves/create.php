<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa;">
    <h4><?= __('Add Leave Request') ?></h4>

    <form method="POST" action="<?= BASE_URL ?>/agent/leaveSubmit" class="mt-3">
        <div class="mb-3">
            <label><?= __('Start Date') ?></label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label><?= __('End Date') ?></label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label><?= __('Reason') ?></label>
            <textarea name="reason" class="form-control" rows="3" required></textarea>
        </div>
        <button class="btn btn-success"><?= __('Submit Leave') ?></button>
    </form>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
