<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <h3>My Projects</h3>

    <div class="card table-container mt-3">
        <table class="table table-bordered table-hover align-middle">
            
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Project Name</th>
                    <th>Status</th>
                    <th>Tasks Progress</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($projects)): ?>
                <?php $i = 1; foreach ($projects as $project): ?>

                <?php
                    $status = $project['status'] ?? 'Pending';

                    // Status Badge Styling
                    $statusClass =
                        $status === 'Completed'   ? 'bg-success' :
                        ($status === 'In Progress' ? 'bg-primary' : 'bg-warning');

                    $completed = $project['completed_tasks'] ?? 0;
                    $total     = $project['total_tasks'] ?? 0;
                ?>

                <tr>
                    <td><?= $i++ ?></td>

                    <td><?= htmlspecialchars($project['name']) ?></td>

                    <!-- STATUS -->
                    <td class="text-center">
                        <span class="badge <?= $statusClass ?> px-2 py-1" style="font-size:11px;">
                            <?= htmlspecialchars($status) ?>
                        </span>
                    </td>

                    <!-- TASK PROGRESS -->
                    <td class="text-center">
                        <span class="badge bg-secondary px-2 py-1" style="font-size:11px;">
                            <?= $completed ?> / <?= $total ?>
                        </span>
                    </td>

                    <!-- ACTION -->
                    <td class="text-center">
                        <?php if ($status === 'In Progress'): ?>
                            <form method="post" action="<?= BASE_URL ?>/agent/submitForReview" class="d-inline">
                                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                <button type="submit"
                                        class="btn btn-success btn-sm px-2 py-0"
                                        style="font-size:11px;">
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

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
