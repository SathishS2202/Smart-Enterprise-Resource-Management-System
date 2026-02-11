<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">
            Tasks Management
        </h5>

        <a href="<?= BASE_URL ?>/admin/tasksCreate" class="btn btn-sm btn-primary px-3">
            <i class="bi bi-list-task"></i> Add Task
        </a>
    </div>

    <!-- FLASH MESSAGE -->
    <?php if (!empty($_SESSION['task_msg'])): ?>
        <div class="alert alert-<?= $_SESSION['task_msg']['type'] === 'success' ? 'success' : 'danger' ?> py-2">
            <?= htmlspecialchars($_SESSION['task_msg']['text']) ?>
        </div>
        <?php unset($_SESSION['task_msg']); ?>
    <?php endif; ?>

    <!-- SEARCH -->
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" id="taskSearch" class="form-control form-control-sm" placeholder="Search tasks...">
        </div>
    </div>

    <!-- TASKS TABLE -->
    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle w-100">
            <thead class="table-light text-center">
                <tr>
                    <th style="width:50px">#</th>
                    <th>Task Name</th>
                    <th>Project</th>
                    <th>Agent</th>
                    <th style="width:120px">Start</th>
                    <th style="width:120px">Due</th>
                    <th style="width:110px">Status</th>
                    <th style="width:160px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $index => $task): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars($task['project_name'] ?? 'Unknown') ?></td>
                            <td>
                                <?php if(empty($task['agent_name'])): ?>
    <form method="post" action="<?= BASE_URL ?>/admin/tasksAssignAgent" style="display:flex; gap:5px;">
        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
        <select name="agent_id" required>
            <option value="">Assign Agent</option>
            <?php foreach($agents as $agent): ?>
                <option value="<?= $agent['id'] ?>"><?= htmlspecialchars($agent['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-sm btn-primary" type="submit">Assign</button>
    </form>
<?php else: ?>
    <?= htmlspecialchars($task['agent_name']) ?>
<?php endif; ?>

                            </td>
                            <td><?= htmlspecialchars($task['start_date'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($task['due_date'] ?? '-') ?></td>
                            <td class="text-center">
                                <?php
                                switch($task['status'] ?? 'Pending') {
                                    case 'Pending':
                                        echo "<span class='badge bg-warning text-dark py-1 px-2 fs-6 d-inline-block text-center mt-2'>Pending</span>";
                                        break;
                                    case 'In Progress':
                                        echo "<span class='badge bg-primary text-white py-1 px-2 fs-6 d-inline-block text-center mt-2'>In Progress</span>";
                                        break;
                                    case 'Completed':
                                        echo "<span class='badge bg-success text-white py-1 px-2 fs-6 d-inline-block text-center mt-2'>Completed</span>";
                                        break;
                                    case 'On Hold':
                                        echo "<span class='badge bg-secondary text-white py-1 px-2 fs-6 d-inline-block text-center mt-2'>On Hold</span>";
                                        break;
                                    default:
                                        echo "<span class='badge bg-light text-dark py-1 px-2 fs-6 d-inline-block text-center mt-2'>Unknown</span>";
                                }
                                ?>
                            </td>
                           <td>
    <a href="<?= BASE_URL ?>/admin/tasksEdit?id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
        <i class="bi bi-pencil"></i>
    </a>
    <form action="<?= BASE_URL ?>/admin/tasksDelete" method="post" style="display:inline;">
        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
        <a href="<?= BASE_URL ?>/admin/tasksDelete?id=<?= $task['id'] ?>"
   class="btn btn-sm btn-outline-danger">
    <i class="bi bi-trash"></i>
</a>

    </form>
</td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No tasks found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SEARCH SCRIPT -->
<script>
document.getElementById('taskSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
