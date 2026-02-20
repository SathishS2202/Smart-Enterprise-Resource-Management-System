


<div class="support-header">
    <h2>SERMS</h2>

    <nav>
        <a href="<?= BASE_URL ?>/"><?= __('Home') ?></a>
        <a href="<?= BASE_URL ?>/auth/login" class="active"><?= __('Login') ?></a>
    </nav>
</div>


<div class="login-container">
    <div class="login-box">
        <h4><?= __('Login to start your session') ?></h4>
         <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>


       <form method="POST" action="<?= BASE_URL ?>/auth/authenticate">
    <input type="text" name="username" placeholder="email/username">
    <input type="password" name="password" placeholder="Password">

    <label class="remember">
        <input type="checkbox"> <?= __('Remember me') ?>
    </label>

    <button type="submit" class="btn-login"><?= __('LOGIN') ?></button>

    <a href="<?= BASE_URL ?>/auth/forgot" class="forgot"><?= __('Forgot password?') ?></a>

</form>

<a href="<?= BASE_URL ?>/auth/register" class="btn-register">
    <?= __('CREATE ACCOUNT') ?>
</a>

    </div>
</div>
