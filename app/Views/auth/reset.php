<h4>Reset Password</h4>
<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST" action="<?= BASE_URL ?>/auth/updatePassword">
    <input type="hidden" name="token" value="<?= $token ?>">
    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="password_confirm" placeholder="Confirm Password" required>
    <button type="submit" class="btn-login">Reset Password</button>
</form>
