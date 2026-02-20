<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa; min-height: 85vh;">
    <h4>Add New Task</h4>

    <form method="post" action="<?= BASE_URL ?>/admin/tasksStore">
        <div class="mb-3">
            <label><?= __('task_name') ?></label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label><?= __('project') ?></label>
            <select name="project_id" class="form-control" required>
                <option value="">_<?= __('select_project') ?></option>
                <?php foreach($projects as $project): ?>
                    <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label><?= __('assign_agent') ?></label>
            <select name="agent_id" class="form-control">
                <option value="">_<?= __('select_agent') ?></option>
                <?php foreach($agents as $agent): ?>
                    <option value="<?= $agent['id'] ?>"><?= htmlspecialchars($agent['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label><?= __('start_date') ?></label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label><?= __('due_date') ?></label>
            <input type="date" name="due_date" class="form-control">

        </div>

        <div class="mb-3">
            <label><?= __('status') ?></label>
            <select name="status" class="form-control">
                <?php foreach(['Pending','In Progress','Completed','On Hold'] as $status): ?>
                    <option value="<?= $status ?>"><?= $status ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-success" type="submit"><?= __('add_task') ?></button>
        <a href="<?= BASE_URL ?>/admin/tasks" class="btn btn-secondary ms-2"><?= __('cancel') ?></a>
    </form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
