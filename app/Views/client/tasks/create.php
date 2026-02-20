<?php require_once __DIR__ . '/../../layouts/client_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/client_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa; min-height: 85vh;">

    <h5 class="mb-3"><?= __('Add Task') ?></h5>

    <div class="card p-4 shadow-sm">

        <form method="post" action="<?= BASE_URL ?>/client/storeTask">

            <!-- PROJECT -->
            <div class="mb-3">
                <label class="form-label"><?= __('Project') ?></label>
                <select name="project_id" class="form-select form-select-sm" required>
                    <option value="">__<?= __('Select Project') ?></option>
                    <?php foreach ($projects as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= htmlspecialchars($p['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- TITLE -->
            <div class="mb-3">
                <label class="form-label"><?= __('Task Title') ?></label>
                <input type="text" name="title"
                       class="form-control form-control-sm" required>
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-3">
                <label class="form-label"><?= __('Description') ?></label>
                <textarea name="description"
                          class="form-control form-control-sm"
                          rows="3"></textarea>
            </div>

            <!-- PRIORITY -->
            <div class="mb-3">
                <label class="form-label"><?= __('Priority') ?></label>
                <select name="priority" class="form-select form-select-sm">
                    <option value="Low"><?= __('Low') ?></option>
                    <option value="Normal" selected><?= __('Normal') ?></option>
                    <option value="High"><?= __('High') ?></option>
                </select>
            </div>

            <!-- DATES -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><?= __('Start Date') ?></label>
                    <input type="date" name="start_date"
                           class="form-control form-control-sm">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><?= __('Due Date') ?></label>
                    <input type="date" name="due_date"
                           class="form-control form-control-sm">
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-sm">
                    <?= __('Save Task') ?>
                </button>
                <a href="<?= BASE_URL ?>/client/tasks"
                   class="btn btn-secondary btn-sm">
                    <?= __('Cancel') ?>
                </a>
            </div>

        </form>

    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
