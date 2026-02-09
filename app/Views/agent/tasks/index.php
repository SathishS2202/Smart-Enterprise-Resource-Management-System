<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">
    <h3>My Tasks</h3>

    <div class="card table-container mt-3">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Task Title</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($tasks)):
                $i = 1;
                foreach ($tasks as $t): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($t['title']) ?></td>
                    <td><?= htmlspecialchars($t['project_name']) ?></td>
                    <td>
                        <span class="badge 
                            <?= $t['status']=='Completed' ? 'bg-success' :
                               ($t['status']=='In Progress' ? 'bg-primary' : 'bg-warning') ?>">
                            <?= $t['status'] ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-secondary"><?= $t['priority'] ?></span>
                    </td>
                    <td><?= $t['due_date'] ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/agent/taskView/<?= $t['id'] ?>" class="icon-btn">
                            <i class="fa fa-eye"></i>
                        </a>

                        <?php if ($t['status'] !== 'Completed'): ?>
                        <a href="<?= BASE_URL ?>/agent/markTaskDone/<?= $t['id'] ?>" 
                           class="btn btn-success btn-sm">
                            Mark Done
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No tasks assigned yet
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
