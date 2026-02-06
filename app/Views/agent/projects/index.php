<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-4">
    <h3>My Projects</h3>

    <div class="card table-container mt-3">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Project Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Tasks Completed</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($projects)):
                    $i = 1;
                    foreach($projects as $p): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars(substr($p['description'],0,50)) ?>...</td>
                        <td>
                            <span class="badge <?= $p['status']=='Active'?'bg-primary':($p['status']=='Completed'?'bg-success':($p['status']=='Pending'?'bg-warning':'bg-secondary')) ?>">
                                <?= $p['status'] ?>
                            </span>
                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $p['total_tasks']>0 ? ($p['completed_tasks']/$p['total_tasks']*100) : 0 ?>%"></div>
                            </div>
                            <small><?= $p['completed_tasks'] ?>/<?= $p['total_tasks'] ?></small>
                        </td>
                        <td><?= $p['start_date'] ?></td>
                        <td><?= $p['end_date'] ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/agent/projectView/<?= $p['id'] ?>" class="icon-btn"><i class="fa fa-eye"></i></a>
                            <a href="<?= BASE_URL ?>/agent/tasks?project_id=<?= $p['id'] ?>" class="icon-btn"><i class="fa fa-tasks"></i></a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="8" class="text-center text-muted">No projects assigned yet</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
