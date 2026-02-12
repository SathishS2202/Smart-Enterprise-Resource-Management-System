

<style>
    body {
    background: linear-gradient(
        180deg,
        #e5edf5 0%,
        #eef2f7 100%
    );
    color: #0f172a;
}

</style>
<div class="hero">
    <div class="hero-content">
        <span class="badge">Smart Enterprise Resource Management System</span>

        <h1>
            One platform to manage <br>
            people, projects, and processes
        </h1>

        <p>
            ERMS helps organizations streamline daily operations —
            from user management to project tracking and approvals —
            all in one secure system.
        </p>
        <div class="dropdown">
    <img src="<?= BASE_URL ?>/assets/flags/<?= $_SESSION['lang'] ?? 'en' ?>.png" width="30" height="20" data-bs-toggle="dropdown">
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="<?= BASE_URL ?>/public/set_language.php?lang=en"><img src="<?= BASE_URL ?>/assets/flags/en.png" width="20"> English</a></li>
        <li><a class="dropdown-item" href="<?= BASE_URL ?>/public/set_language.php?lang=es"><img src="<?= BASE_URL ?>/assets/flags/es.png" width="20"> Español</a></li>
        <li><a class="dropdown-item" href="<?= BASE_URL ?>/public/set_language.php?lang=hi"><img src="<?= BASE_URL ?>/assets/flags/hi.png" width="20"> हिंदी</a></li>
    </ul>
</div>


        <div class="actions">
            <a href="/serms/public/auth/login" class="btn-primary">Login</a>
            <a href="/serms/public/auth/register" class="btn-link">Create account</a>
            <!-- <form method="get" class="language-switcher">
    <select name="lang" onchange="this.form.submit()">
        <option value="en" <?= ($_SESSION['lang'] ?? 'en') === 'en' ? 'selected' : '' ?>>English</option>
        <option value="hi" <?= ($_SESSION['lang'] ?? '') === 'hi' ? 'selected' : '' ?>>हिंदी</option>
        <option value="es" <?= ($_SESSION['lang'] ?? '') === 'es' ? 'selected' : '' ?>>Español</option>
    </select>
</form> -->

        </div>
    </div>

</div>

<section class="info">
    <div class="info-grid">
        <div>
            <h3>Built for Admin Control</h3>
            <p>
                Centralized control over users, roles, permissions,
                and organizational workflows.
            </p>
        </div>

        <div>
            <h3>Designed for Teams</h3>
            <p>
                Manage projects, tasks, attendance, and documents
                without switching tools.
            </p>
        </div>

        <div>
            <h3>Secure & Structured</h3>
            <p>
                Role-based access, clean architecture, and secure
                data handling by design.
            </p>
        </div>
    </div>
</section>

<footer>
    © 2026 SERMS — Smart Enterprise Resource Management System
</footer>
