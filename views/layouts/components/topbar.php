<?php
use App\Core\Auth;

$userName = ($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '');
$initials = strtoupper(substr($user['first_name'] ?? 'U', 0, 1) . substr($user['last_name'] ?? '', 0, 1));
$roleBadge = ucfirst($user['role'] ?? 'user');
?>

<header class="topbar">
    <!-- Mobile menu toggle -->
    <button class="mobile-menu-btn" id="mobile-sidebar-toggle">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    <!-- Page Title -->
    <div class="topbar-title">
        <h1><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></h1>
    </div>

    <!-- Right Actions -->
    <div class="topbar-actions">
        <!-- Search -->
        <div class="topbar-search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." id="global-search">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </span>
            </div>
        </div>

        <!-- Notifications -->
        <div class="topbar-item" style="position:relative;">
            <button class="topbar-icon-btn" id="notification-bell" data-dropdown data-tooltip="Notifications">
                <i data-lucide="bell"></i>
                <span class="notification-count hidden" id="notif-count">0</span>
            </button>
            <div class="dropdown-menu notification-dropdown" id="notification-dropdown">
                <div class="dropdown-header">
                    <h4>Notifications</h4>
                    <button class="btn btn-ghost btn-sm" id="mark-all-read">Mark all read</button>
                </div>
                <div class="dropdown-body" id="notification-list">
                    <div class="empty-state" style="padding: 30px 20px;">
                        <p class="text-sm text-muted">No new notifications</p>
                    </div>
                </div>
                <div class="dropdown-footer">
                    <a href="#" class="text-sm">View All Notifications</a>
                </div>
            </div>
        </div>

        <!-- User Menu -->
        <div class="topbar-item user-menu-container" style="position:relative;">
            <button class="user-menu-trigger" data-dropdown>
                <div class="avatar avatar-sm" style="background: <?= htmlspecialchars(avatar_color($userName)) ?>;">
                    <?php if (!empty($user['profile_photo'])): ?>
                        <img src="<?= APP_URL ?>/public/uploads/profiles/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Profile">
                    <?php else: ?>
                        <?= $initials ?>
                    <?php endif; ?>
                </div>
                <div class="user-info hide-mobile">
                    <span class="user-name"><?= htmlspecialchars($userName) ?></span>
                    <span class="user-role"><?= $roleBadge ?></span>
                </div>
                <svg class="hide-mobile" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="dropdown-menu user-dropdown">
                <div class="dropdown-user-info">
                    <div class="avatar" style="background: <?= htmlspecialchars(avatar_color($userName)) ?>;">
                        <?php if (!empty($user['profile_photo'])): ?>
                            <img src="<?= APP_URL ?>/public/uploads/profiles/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Profile">
                        <?php else: ?>
                            <?= $initials ?>
                        <?php endif; ?>
                    </div>
                    <div>
                        <strong><?= htmlspecialchars($userName) ?></strong>
                        <small><?= htmlspecialchars($user['email'] ?? '') ?></small>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="<?= APP_URL ?>/profile" class="dropdown-item">
                    <i data-lucide="user" style="width:16px;height:16px;"></i>
                    My Profile
                </a>
                <a href="<?= APP_URL ?>/settings" class="dropdown-item">
                    <i data-lucide="settings" style="width:16px;height:16px;"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= APP_URL ?>/logout" class="dropdown-item text-danger">
                    <i data-lucide="log-out" style="width:16px;height:16px;"></i>
                    Sign Out
                </a>
            </div>
        </div>
    </div>
</header>
