<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa; min-height: 85vh;">
    <h4 class="mb-4">Add New Project</h4>

    <form method="post" action="<?= BASE_URL ?>/admin/projectsStore" class="p-4 bg-white rounded shadow-sm">

        <div class="mb-3">
            <label>Project Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Client</label>
            <select name="client_id" class="form-control">
                <option value="">Select Client</option>
                <?php foreach($clients as $client): ?>
                    <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- <div class="mb-3">
            <label>Assign Agent</label>
            <select name="agent_id" class="form-control">
                <option value="">Select Agent (optional)</option>
                <?php foreach($agents as $agent): ?>
                    <option value="<?= $agent['id'] ?>"><?= htmlspecialchars($agent['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div> -->

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="On Hold">On Hold</option>
            </select>
        </div>

        <!-- Centered Small Button -->
        <div class="text-center">
            <button class="btn btn-success btn-md px-4" type="submit">Add Project</button>
        </div>

    </form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
