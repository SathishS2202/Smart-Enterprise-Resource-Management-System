<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid mt-4">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h4 class="mb-2 mb-md-0 text-primary"><?= htmlspecialchars($project['name']) ?> Details</h4>

        <div class="d-flex gap-2">
            <!-- Export Tasks Button -->
            <a href="<?= BASE_URL ?>/agent/tasks/export?project_id=<?= $project['id'] ?>" 
               class="btn btn-success btn-sm">
                <i class="bi bi-download"></i> Export Tasks
            </a>

            <!-- Back Button -->
            <a href="<?= BASE_URL ?>/agent/projects" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Projects
            </a>
        </div>
    </div>

    <!-- Project Info Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>Client:</strong> <?= htmlspecialchars($project['client_name'] ?? '-') ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Assigned Agent:</strong> <?= htmlspecialchars($project['agent_name'] ?? '-') ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Status:</strong>
                    <span class="badge 
                        <?= $project['status'] === 'Completed' ? 'bg-success' :
                            ($project['status'] === 'In Progress' ? 'bg-warning text-dark' :
                            'bg-info text-dark') ?> py-1 px-2 fs-7">
                        <?= $project['status'] ?>
                    </span>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Start Date:</strong> <?= !empty($project['start_date']) ? date('d M Y', strtotime($project['start_date'])) : '-' ?>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>End Date:</strong> <?= !empty($project['end_date']) ? date('d M Y', strtotime($project['end_date'])) : '-' ?>
                </div>
                <div class="col-md-12 mb-2">
                    <strong>Description:</strong> <?= htmlspecialchars($project['description'] ?? '-') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Tasks Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Tasks</h5>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Task Title</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tasks)): ?>
                            <?php foreach ($tasks as $index => $task): ?>
                                <tr class="text-center">
                                    <td><?= $index + 1 ?></td>
                                    <td class="text-start"><?= htmlspecialchars($task['title']) ?></td>
                                    <td>
                                        <span class="badge 
                                            <?= $task['status'] === 'Completed' ? 'bg-success' :
                                                ($task['status'] === 'Pending' ? 'bg-warning text-dark' : 'bg-info text-dark') ?>
                                            py-1 px-2 fs-7">
                                            <?= $task['status'] ?>
                                        </span>
                                    </td>
                                    <td><?= !empty($task['due_date']) ? date('d M Y', strtotime($task['due_date'])) : '-' ?></td>
                                    <td><?= date('d M Y', strtotime($task['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i> No tasks found for this project
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
