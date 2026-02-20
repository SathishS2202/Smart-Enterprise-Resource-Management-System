<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid mt-4">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h4 class="mb-2 mb-md-0 text-primary"><?= __('Tasks') ?></h4>

        <div class="d-flex gap-2">
            <!-- Export Button -->
            <a href="<?= BASE_URL ?>/agent/tasks/export?status=<?= urlencode($status) ?>" 
               class="btn btn-success btn-sm">
                <i class="bi bi-download"></i> <?= __('Export') ?>
            </a>

            <!-- Back Button -->
            <a href="<?= BASE_URL ?>/agent/reports" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> <?= __('Back') ?>
            </a>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th><?= __('Task Title') ?></th>
                            <th><?= __('Project') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Created At') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tasks)): ?>
                            <?php foreach ($tasks as $index => $task): ?>
                                <tr class="text-center">
                                    <td><?= $index + 1 ?></td>
                                    <td class="text-start"><?= htmlspecialchars($task['title']) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($task['project_name'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge 
                                            <?= $task['status'] === __('Completed') ? 'bg-success' : 
                                                ($task['status'] === __('Pending') ? 'bg-warning text-dark' : 'bg-info text-dark') ?> 
                                            py-1 px-2 fs-7">
                                            <?= $task['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= !empty($task['due_date']) ? date('d M Y', strtotime($task['due_date'])) : '-' ?>
                                    </td>
                                    <td>
                                        <?= date('d M Y', strtotime($task['created_at'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i> No tasks found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
