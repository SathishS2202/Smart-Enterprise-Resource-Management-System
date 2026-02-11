
<div class="support-header">
    <h2>SERMS</h2>

  
</div>

<!-- Reset Form -->
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <h4 class="card-title text-center mb-4">Reset Your Password</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/auth/updatePassword">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirm" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Reset Password</button>

                <div class="text-center">
                    <a href="<?= BASE_URL ?>/auth/login">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

