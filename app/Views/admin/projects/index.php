<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">
            Projects Management
        </h5>

        <a href="<?= BASE_URL ?>/admin/projectsCreate" class="btn btn-sm btn-primary px-3">
            <i class="bi bi-folder-plus"></i> Add Project
        </a>
    </div>

    <!-- FLASH MESSAGE -->
    <?php if (!empty($_SESSION['project_msg'])): ?>
        <div class="alert alert-<?= $_SESSION['project_msg']['type'] === 'success' ? 'success' : 'danger' ?> py-2">
            <?= htmlspecialchars($_SESSION['project_msg']['text']) ?>
        </div>
        <?php unset($_SESSION['project_msg']); ?>
    <?php endif; ?>

    <!-- SEARCH -->
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" id="projectSearch" class="form-control form-control-sm" placeholder="Search projects...">
        </div>
    </div>

    <!-- PROJECTS TABLE -->
    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle w-100">
            <thead class="table-light text-center">
                <tr>
                    <th style="width:50px">#</th>
                    <th>Project Name</th>
                    <th>Client</th>
                    <th>Agent</th>
                    <th style="width:120px">Start</th>
                    <th style="width:120px">End</th>
                    <th style="width:110px">Status</th>
                    <th style="width:160px">Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $i => $project): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($project['name']) ?></td>

                        <td><?= htmlspecialchars($project['client_name'] ?? 'Unknown') ?></td>

                        <td class="text-center">
                            <?php if (!empty($project['agent_name'])): ?>
                                <?= htmlspecialchars($project['agent_name']) ?>
                            <?php else: ?>
                                <!-- ASSIGN AGENT -->
                                <form method="post" action="<?= BASE_URL ?>/admin/assignAgent" class="d-flex gap-1 justify-content-center">
                                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                    <select name="agent_id" class="form-select form-select-sm" required>
                                        <option value="">Assign</option>
                                        <?php foreach ($agents as $agent): ?>
                                            <option value="<?= $agent['id'] ?>">
                                                <?= htmlspecialchars($agent['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="btn btn-sm btn-primary">Assign</button>
                                </form>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($project['start_date'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($project['end_date'] ?? '-') ?></td>

                          <!-- STATUS -->
                           <!-- STATUS -->
<td class="text-center">
<?php
$status = $project['status'] ?? 'Pending';

$badgeStyle = "px-2 py-1";
$fontStyle  = "style='font-size:11px;'";

switch ($status) {
    case 'Pending':
        echo "<span class='badge bg-warning $badgeStyle' $fontStyle>Pending</span>";
        break;

    case 'Assigned':
        echo "<span class='badge bg-primary $badgeStyle' $fontStyle>Assigned</span>";
        break;

    case 'In Progress':
    case 'On Progress':
        echo "<span class='badge bg-info $badgeStyle' $fontStyle>In Progress</span>";
        break;

    case 'Ready for Review':
        ?>
        <form method="post" action="<?= BASE_URL ?>/admin/approveProject" class="d-inline">
            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
            <button class="btn btn-success btn-sm px-2 py-0" style="font-size:11px;">
                <i class="bi bi-check-circle"></i> Approve
            </button>
        </form>
        <?php
        break;

    case 'Completed':
        echo "<span class='badge bg-success $badgeStyle' $fontStyle>Completed</span>";
        break;

    default:
        echo "<span class='badge bg-secondary $badgeStyle' $fontStyle>Unknown</span>";
}
?>
</td>





                        <!-- ACTIONS -->
                        <td class="text-center">
                            <a href="<?= BASE_URL ?>/admin/projectsEdit?id=<?= $project['id'] ?>"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="<?= BASE_URL ?>/admin/projectsDelete?id=<?= $project['id'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Delete this project?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        No projects found
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SEARCH FILTER -->
<script>
document.getElementById('projectSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
