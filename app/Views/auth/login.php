


<div class="support-header">
    <h2>SERMS</h2>

    <nav>
        <a href="<?= BASE_URL ?>/">Home</a>
        <a href="<?= BASE_URL ?>/auth/login" class="active">Login</a>
    </nav>
</div>


<div class="login-container">
    <div class="login-box">
        <h4>Login to start your session</h4>
         <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>


       <form method="POST" action="<?= BASE_URL ?>/auth/authenticate">
    <input type="text" name="username" placeholder="email/username">
    <input type="password" name="password" placeholder="Password">

    <label class="remember">
        <input type="checkbox"> Remember me
    </label>

    <button type="submit" class="btn-login">LOGIN</button>

    <a href="<?= BASE_URL ?>/auth/forgot" class="forgot">Forgot password?</a>

</form>

<a href="<?= BASE_URL ?>/auth/register" class="btn-register">
    CREATE ACCOUNT
</a>

    </div>
</div>
