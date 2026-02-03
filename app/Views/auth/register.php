<div class="support-header">
    <h2>SERMS</h2>

    <nav>
        <a href="<?= BASE_URL ?>/">Home</a>
        <a href="<?= BASE_URL ?>/auth/login">Login</a>
        <a href="<?= BASE_URL ?>/auth/register" class="active">Register</a>
    </nav>
</div>

<div class="login-container">
    <div class="login-box">
        <h4>Create your account</h4>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/auth/store">
            <input type="text" name="name" placeholder="Full name" required>
            <input type="email" name="email" placeholder="Email address" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm password" required>

            <label class="remember">
                <input type="checkbox" required>
                I agree to the Terms & Conditions
            </label>

            <button type="submit" class="btn-login">REGISTER</button>

            <a href="<?= BASE_URL ?>/auth/login" class="forgot">
                Already have an account? Login
            </a>
        </form>
    </div>
</div>
