<?php require_once __DIR__.'/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__.'/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">Documents</h5>
         <a href="<?= BASE_URL ?>/admin/documentsCreate" class="btn btn-sm btn-primary">
        <i class="bi bi-upload"></i> Upload
    </a>
</div>

<?php if(!empty($_SESSION['doc_msg'])): ?>
<div class="alert alert-success py-2">
    <?= $_SESSION['doc_msg']['text'] ?>
</div>
<?php unset($_SESSION['doc_msg']); endif; ?>

<table class="table table-sm table-bordered">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Uploaded By</th>
            <th>Date</th>
            <th>File</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($documents as $i=>$d): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($d['title']) ?></td>
            <td><?= htmlspecialchars($d['uploaded_by']) ?></td>
            <td><?= date('d M Y', strtotime($d['created_at'])) ?></td>
            <td>
               <a href="<?= BASE_URL ?>/<?= $document['file_path'] . $document['file_name'] ?>"
   target="_blank"
   class="btn btn-sm btn-outline-primary">
   <i class="bi bi-eye"></i> View
</a>


            <td>
                <a href="<?= BASE_URL ?>/admin/documentsDelete?id=<?= $d['id'] ?>"
                   class="btn btn-sm btn-outline-danger">
                   <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

<?php require_once __DIR__.'/../../layouts/footer.php'; ?>
