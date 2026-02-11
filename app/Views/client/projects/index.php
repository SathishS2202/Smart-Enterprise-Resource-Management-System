<?php require_once __DIR__ . '/../../layouts/client_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/client_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <!-- PAGE HEADER -->
   <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
    <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">
        My Projects
    </h5>

   <a href="<?= BASE_URL ?>/client/projects/create"
   class="btn btn-sm btn-primary">
    <i class="bi bi-plus-circle"></i> Add Project
</a>


</div>


    <!-- SEARCH -->
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" id="projectSearch"
                   class="form-control form-control-sm"
                   placeholder="Search projects...">
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th style="width:50px">#</th>
                    <th>Project Name</th>
                    <th>Agent</th>
                    <th style="width:120px">Start</th>
                    <th style="width:120px">End</th>
                    <th style="width:110px">Status</th>
                    <th style="width:120px">Progress</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $index => $project): ?>

                        <?php
                        $total = $project['total_tasks'] ?? 0;
                        $done  = $project['completed_tasks'] ?? 0;
                        $progress = $total > 0 ? round(($done / $total) * 100) : 0;
                        ?>

                        <tr>
                            <td><?= $index + 1 ?></td>

                            <td class="fw-medium">
                                <?= htmlspecialchars($project['name']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($project['agent_name'] ?? 'Not Assigned') ?>
                            </td>

                            <td><?= htmlspecialchars($project['start_date'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($project['end_date'] ?? '-') ?></td>

                            <!-- STATUS -->
                            <td class="text-center">
                                <?php
                                switch ($project['status'] ?? 'Pending') {
    case 'Pending':
        echo "<span class='badge bg-warning text-white px-2 py-1' style='font-size:11px'>Pending</span>";
        break;

    case 'Active':
    case 'In Progress':
        echo "<span class='badge bg-primary text-white px-2 py-1' style='font-size:11px'>In Progress</span>";
        break;

    case 'Completed':
        echo "<span class='badge bg-success text-white px-2 py-1' style='font-size:11px'>Completed</span>";
        break;

    case 'On Hold':
        echo "<span class='badge bg-secondary text-white px-2 py-1' style='font-size:11px'>On Hold</span>";
        break;

    default:
        echo "<span class='badge bg-dark text-white px-2 py-1' style='font-size:11px'>Unknown</span>";
}

                                ?>
                            </td>

                            <!-- PROGRESS -->
                            <td>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar"
                                         role="progressbar"
                                         style="width: <?= $progress ?>%;"
                                         aria-valuenow="<?= $progress ?>"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted"><?= $progress ?>%</small>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No projects assigned yet
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SEARCH SCRIPT -->
<script>
document.getElementById('projectSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
