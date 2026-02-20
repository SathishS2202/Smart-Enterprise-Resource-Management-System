<?php $rtl = APP_RTL; ?>

<div class="sidebar <?= $rtl ? 'rtl-sidebar' : '' ?>">

    <ul class="nav flex-column <?= $rtl ? 'text-end' : '' ?>">

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/dashboard" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-speedometer2"></i>
                <span><?= __('dashboard') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/users" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-people"></i>
                <span><?= __('users') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/projects" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-folder"></i>
                <span><?= __('projects') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/tasks" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-list-task"></i>
                <span><?= __('tasks') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/attendance" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-calendar-check"></i>
                <span><?= __('attendance') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/documents" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-file-earmark-text"></i>
                <span><?= __('documents') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-bar-chart"></i>
                <span><?= __('reports') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/email" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-envelope"></i>
                <span><?= __('send_email') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/leave_approvals" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-check2-square"></i>
                <span><?= __('leave_approvals') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/profile" class="nav-link d-flex align-items-center gap-2 <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-person-circle"></i>
                <span><?= __('my_profile') ?></span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL ?>/admin/logout" class="nav-link d-flex align-items-center gap-2 text-danger <?= $rtl ? 'flex-row-reverse justify-content-end' : '' ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span><?= __('logout') ?></span>
            </a>
        </li>

    </ul>
</div>
