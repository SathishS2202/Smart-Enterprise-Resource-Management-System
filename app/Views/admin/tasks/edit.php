<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <h4>Edit Task</h4>

    <form method="post" action="<?= BASE_URL ?>/admin/tasksUpdate?id=<?= $task['id'] ?>">
        <div class="mb-3">
            <label>Task Name</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Project</label>
            <select name="project_id" class="form-control" required>
                <option value="">Select Project</option>
                <?php foreach($projects as $project): ?>
                    <option value="<?= $project['id'] ?>" <?= $task['project_id']==$project['id']?'selected':'' ?>>
                        <?= htmlspecialchars($project['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Assign Agent</label>
            <select name="agent_id" class="form-control">
                <option value="">Select Agent</option>
                <?php foreach($agents as $agent): ?>
                    <option value="<?= $agent['id'] ?>" <?= $task['agent_id']==$agent['id']?'selected':'' ?>>
                        <?= htmlspecialchars($agent['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?= $task['start_date'] ?>">
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" value="<?= $task['due_date'] ?>">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <?php foreach(['Pending','In Progress','Completed','On Hold'] as $status): ?>
                    <option value="<?= $status ?>" <?= $task['status']==$status?'selected':'' ?>><?= $status ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-primary" type="submit">Update Task</button>
        <a href="<?= BASE_URL ?>/admin/tasks" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
