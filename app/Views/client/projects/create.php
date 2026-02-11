<?php require_once __DIR__ . '/../../layouts/client_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/client_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3" style="background-color: #f8f9fa; min-height: 85vh;">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">
            Add New Project
        </h5>

        <a href="<?= BASE_URL ?>/client/projects"
           class="btn btn-sm btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="card shadow-sm p-3" style="max-width: 700px;">

        <form method="post" action="<?= BASE_URL ?>/client/projectsStore">

            <!-- PROJECT NAME -->
            <div class="mb-2">
                <label class="form-label small fw-semibold">
                    Project Name <span class="text-danger">*</span>
                </label>
                <input type="text"
                       name="name"
                       class="form-control form-control-sm"
                       placeholder="Enter project name"
                       required>
            </div>

            <!-- DATES -->
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">
                        Start Date
                    </label>
                    <input type="date"
                           name="start_date"
                           class="form-control form-control-sm">
                </div>

                <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">
                        End Date
                    </label>
                    <input type="date"
                           name="end_date"
                           class="form-control form-control-sm">
                </div>
            </div>

            <!-- INFO -->
            <div class="alert alert-info py-2 small mt-2 mb-3">
                <i class="bi bi-info-circle"></i>
                This project request will be reviewed by Admin before activation.
            </div>

            <!-- ACTIONS -->
            <div class="d-flex gap-2">
                <button type="submit"
                        class="btn btn-sm btn-primary px-4">
                    Add project
                </button>

                <a href="<?= BASE_URL ?>/client/projects"
                   class="btn btn-sm btn-outline-secondary px-4">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
