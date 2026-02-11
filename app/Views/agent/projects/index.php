<?php require_once __DIR__ . '/../../layouts/agent_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <h5 class="mb-3">My Projects</h5>

    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Project Name</th>
                    <th>Status</th>
                    <th>Tasks</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $index => $project): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>

                        <td><?= htmlspecialchars($project['name']) ?></td>

                        <td>
                            <span class="badge bg-info">
                                <?= htmlspecialchars($project['status']) ?>
                            </span>
                        </td>

                       <td>
    <?= $project['completed_tasks'] ?? 0 ?>
    /
    <?= $project['total_tasks'] ?? 0 ?>
</td>


                        <td>
                            <?php if ($project['status'] === 'In Progress'): ?>
                                <form method="post" action="<?= BASE_URL ?>/agent/submitForReview">
                                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                    <button class="btn btn-sm btn-success">
                                        Submit for Review
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No projects assigned
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
