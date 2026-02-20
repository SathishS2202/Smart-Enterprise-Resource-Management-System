<?php
$locale = $_SESSION['locale'] ?? 'en';
$languages = [
    'en' => '🇬🇧 English',
    'ta' => '🇮🇳 Tamil',
    'hi' => '🇮🇳 Hindi',
    'fr' => '🇫🇷 Français',
    'es' => '🇪🇸 Español',
    'de' => '🇩🇪 Deutsch',
    'it' => '🇮🇹 Italiano',
    'zh' => '🇨🇳 中文',
    'ar' => '🇸🇦 العربية'
];
?>
<div class="header d-flex justify-content-between align-items-center">

    <!-- Left: Dashboard Title -->
    <div class="header-left d-flex align-items-center gap-3">
        <h3><?= __('dashboard') ?></h3>

        <!-- Language Switch -->
        <div class="role-switch">
            <i class="bi bi-globe2"></i>
            <select onchange="location = this.value;">
                <?php foreach ($languages as $code => $label): ?>
                    <option value="<?= BASE_URL ?>/language/switch?lang=<?= $code ?>" <?= $locale === $code ? 'selected' : '' ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Right: User Info -->
    <div class="header-right">
        <span><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
        <div class="dropdown">
            <i class="bi bi-person-circle" id="profileDropdown" data-bs-toggle="dropdown" style="cursor:pointer;"></i>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/profile"><?= __('my_profile') ?></a></li>
                <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/admin/logout"><?= __('logout') ?></a></li>
            </ul>
        </div>
    </div>

</div>
