<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light border rounded">
        <h5 class="fw-semibold mb-0 px-2 py-1 bg-white border rounded">Send Email</h5>
    </div>

    <!-- FLASH MESSAGE -->
    <?php if (!empty($_SESSION['email_msg'])): ?>
        <div class="alert alert-<?= $_SESSION['email_msg']['type']; ?> py-2">
            <?= htmlspecialchars($_SESSION['email_msg']['text']); ?>
        </div>
        <?php unset($_SESSION['email_msg']); ?>
    <?php endif; ?>

    <!-- EMAIL FORM -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <form method="POST" action="<?= BASE_URL ?>/admin/sendEmail">

                <div class="mb-3">
                    <label class="form-label">From</label>
                    <input type="email" name="from" class="form-control" placeholder="Your Email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">To</label>
                    <input type="email" name="to" class="form-control" placeholder="Recipient Email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" placeholder="Email Subject" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="6" placeholder="Write your message here..." required></textarea>
                </div>

                <button class="btn btn-primary">
                    <i class="bi bi-envelope"></i> Send Email
                </button>

            </form>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
