<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <h4>Edit Project</h4>

    <form method="post" action="<?= BASE_URL ?>/admin/projectsUpdate?id=<?= $project['id'] ?>">
        <div class="mb-3">
            <label>Project Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($project['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Client</label>
            <select name="client_id" class="form-control" required>
                <option value="">Select Client</option>
                <?php foreach($clients as $client): ?>
                    <option value="<?= $client['id'] ?>" <?= $project['client_id']==$client['id']?'selected':'' ?>>
                        <?= htmlspecialchars($client['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Assign Agent</label>
            <select name="agent_id" class="form-control">
                <option value="">Select Agent</option>
                <?php foreach($agents as $agent): ?>
                    <option value="<?= $agent['id'] ?>" <?= $project['agent_id']==$agent['id']?'selected':'' ?>>
                        <?= htmlspecialchars($agent['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?= $project['start_date'] ?>">
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= $project['end_date'] ?>">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <?php foreach(['Pending','In Progress','Completed','On Hold'] as $status): ?>
                    <option value="<?= $status ?>" <?= $project['status']==$status?'selected':'' ?>><?= $status ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Project</button>
        <a href="<?= BASE_URL ?>/admin/projects" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
