<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) session_start();

$username = $_SESSION['username'] ?? 'Agent';
$role = $_SESSION['role'] ?? '';
$impersonate_role = $_SESSION['impersonate_role'] ?? '';
$currentLocale = $_SESSION['locale'] ?? 'en';

// Available languages
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

<div class="container-fluid px-4 pt-3">

    <div class="header d-flex justify-content-between align-items-center p-2 shadow-sm bg-white">

        <!-- LEFT: Panel Title + Role Switch -->
        <div class="d-flex align-items-center gap-3">
            <h4 class="mb-0">
                <?= $impersonate_role === 'agent' ? __('Agent Panel (Impersonated)') : __('Agent Panel') ?>
            </h4>

            <?php if ($role === 'admin'): ?>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-lines-fill fs-5"></i>
                <select class="form-select form-select-sm" onchange="if(this.value) location.href=this.value;">
                    <option selected disabled value=""><?= __('Switch Role') ?></option>
                    <option value="<?= BASE_URL ?>/admin/dashboard"><?= __('Admin View') ?></option>
                    <option value="<?= BASE_URL ?>/agent/dashboard"><?= __('Agent View') ?></option>
                    <option value="<?= BASE_URL ?>/client/dashboard"><?= __('Client View') ?></option>
                </select>
            </div>
            <span class="badge bg-warning text-dark ms-2"><?= __('Admin Viewing') ?></span>
            <?php endif; ?>
        </div>

        <!-- RIGHT: Language Dropdown + Username + Profile -->
        <div class="d-flex align-items-center gap-3">

            <!-- Language Switcher -->
            <div class="dropdown">
                <a href="#" class="text-dark d-flex align-items-center gap-1"
                   data-bs-toggle="dropdown">
                    <i class="bi bi-globe2"></i>
                    <span class="fw-semibold"><?= strtoupper($currentLocale) ?></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow rounded-3 p-2" style="min-width: 200px;">
                    <?php foreach ($languages as $code => $label): ?>
                        <li>
                            <a class="dropdown-item d-flex justify-content-between align-items-center <?= $currentLocale === $code ? 'active fw-semibold' : '' ?>"
                               href="<?= BASE_URL ?>/language/switch?lang=<?= $code ?>">
                                <span><?= $label ?></span>
                                <?php if ($currentLocale === $code): ?>
                                    <i class="bi bi-check-lg text-success"></i>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Username -->
            <span class="fw-semibold"><?= htmlspecialchars($username) ?></span>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a href="#" class="text-dark fs-4" id="agentProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="agentProfileDropdown">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/agent/profile"><?= __('My Profile') ?></a></li>
                    <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/agent/logout"><?= __('Logout') ?></a></li>
                </ul>
            </div>

        </div>

    </div>
</div>