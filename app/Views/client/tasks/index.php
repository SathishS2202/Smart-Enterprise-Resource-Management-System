<?php require_once __DIR__ . '/../../layouts/client_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/client_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">
            Project Tasks
        </h5>
        <a href="<?= BASE_URL ?>/client/createTask"
   class="btn btn-primary btn-sm mb-3">
    <i class="bi bi-plus-circle"></i> Add Task
</a>

    </div>

    <!-- SEARCH -->
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text"
                   id="taskSearch"
                   class="form-control form-control-sm"
                   placeholder="Search tasks...">
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle w-100">
            <thead class="table-light text-center">
                <tr>
                    <th style="width:50px">#</th>
                    <th>Task Title</th>
                    <th>Project</th>
                    <th style="width:110px">Status</th>
                    <th style="width:100px">Priority</th>
                    <th style="width:120px">Due Date</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($tasks)): ?>
                <?php foreach ($tasks as $i => $task): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>

                        <td class="fw-medium">
                            <?= htmlspecialchars($task['title']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($task['project_name'] ?? '-') ?>
                        </td>

                        <!-- STATUS -->
                        <td class="text-center">
                            <?php
                            switch ($task['status'] ?? 'Pending') {
                                case 'Pending':
                                    echo "<span class='badge bg-warning text-white px-2' style='font-size:11px'>Pending</span>";
                                    break;
                                case 'In Progress':
                                    echo "<span class='badge bg-primary text-white px-2' style='font-size:11px'>In Progress</span>";
                                    break;
                                case 'Completed':
                                    echo "<span class='badge bg-success text-white px-2' style='font-size:11px'>Completed</span>";
                                    break;
                                default:
                                    echo "<span class='badge bg-secondary text-white px-2' style='font-size:11px'>Unknown</span>";
                            }
                            ?>
                        </td>

                        <!-- PRIORITY -->
                        <td class="text-center">
                            <?php
                            $priority = $task['priority'] ?? 'Normal';

                            $priorityClass = match ($priority) {
                                'High'   => 'bg-danger',
                                'Medium' => 'bg-warning',
                                'Low'    => 'bg-info',
                                default  => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $priorityClass ?> text-white px-2"
                                  style="font-size:11px">
                                <?= $priority ?>
                            </span>
                        </td>

                        <td>
                            <?= htmlspecialchars($task['due_date'] ?? '-') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No tasks found
                    </td>
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
