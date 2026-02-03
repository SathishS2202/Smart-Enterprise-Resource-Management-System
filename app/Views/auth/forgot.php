<h4>Forgot Password</h4>
<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if(!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
<form method="POST" action="<?= BASE_URL ?>/auth/sendResetLink">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit" class="btn-login">Send Reset Link</button>
</form>
