<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
<h5>Upload Document</h5>

<form method="post" action="<?= BASE_URL ?>/admin/documentsStore" enctype="multipart/form-data">

<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control form-control-sm" required>
</div>

<div class="mb-3">
    <label>File</label>
    <input type="file" name="document" class="form-control form-control-sm" required>
</div>

<button class="btn btn-sm btn-success">Upload</button>
<a href="<?= BASE_URL ?>/admin/documents" class="btn btn-sm btn-secondary ms-2">Cancel</a>

</form>
</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
