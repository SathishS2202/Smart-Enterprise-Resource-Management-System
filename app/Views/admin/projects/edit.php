<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<!-- Add background color to the container -->
<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa; min-height: 85vh;">
    <h4>Edit Project</h4>

    <form method="post" action="<?= BASE_URL ?>/admin/projectsUpdate?id=<?= $project['id'] ?>">
        <div class="mb-3">
            <label><?= __('project_name') ?></label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($project['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label><?= __('client') ?></label>
            <select name="client_id" class="form-control" required>
                <option value="">__<?= __('select_client') ?></option>
                <?php foreach($clients as $client): ?>
                    <option value="<?= $client['id'] ?>" <?= $project['client_id']==$client['id']?'selected':'' ?>>
                        <?= htmlspecialchars($client['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label><?= __('assign_agent') ?></label>
            <select name="agent_id" class="form-control">
                <option value="">__<?= __('select_agent') ?></option>
                <?php foreach($agents as $agent): ?>
                    <option value="<?= $agent['id'] ?>" <?= $project['agent_id']==$agent['id']?'selected':'' ?>>
                        <?= htmlspecialchars($agent['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label><?= __('start_date') ?></label>
            <input type="date" name="start_date" class="form-control" value="<?= $project['start_date'] ?>">
        </div>

        <div class="mb-3">
            <label><?= __('end_date') ?></label>
            <input type="date" name="end_date" class="form-control" value="<?= $project['end_date'] ?>">
        </div>

        <div class="mb-3">
            <label><?= __('status') ?></label>
            <select name="status" class="form-control">
                <?php foreach(['Pending','In Progress','Completed','On Hold'] as $status): ?>
                    <option value="<?= $status ?>" <?= $project['status']==$status?'selected':'' ?>><?= $status ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success"><?= __('update_project') ?></button>
        <a href="<?= BASE_URL ?>/admin/projects" class="btn btn-secondary ms-2"><?= __('cancel') ?></a>
    </form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
