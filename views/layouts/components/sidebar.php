<?php
use App\Core\Auth;
$currentPath = '/' . trim($_GET['url'] ?? '', '/');
$role = $user['role'] ?? 'student';

function isActive($path, $currentPath) {
    if ($path === '/dashboard') return $currentPath === '/dashboard' ? 'active' : '';
    return strpos($currentPath, $path) === 0 ? 'active' : '';
}
?>

<aside class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-header">
        <a href="<?= APP_URL ?>/dashboard" class="sidebar-logo">
            <div class="logo-icon">⚓</div>
            <div class="logo-text">
                <span class="logo-title">ProjectVault</span>
                <span class="logo-subtitle"><?= UNIVERSITY_SHORT ?></span>
            </div>
        </a>
        <button class="sidebar-toggle-btn" id="sidebar-toggle" data-tooltip="Toggle Sidebar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="11 17 6 12 11 7"/><polyline points="18 17 13 12 18 7"/></svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <!-- Main -->
        <div class="nav-section">
            <span class="nav-section-title">Main</span>
            <a href="<?= APP_URL ?>/dashboard" class="nav-link <?= isActive('/dashboard', $currentPath) ?>">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <?php if ($role === 'admin'): ?>
        <!-- Admin Navigation -->
        <div class="nav-section">
            <span class="nav-section-title">Administration</span>
            <a href="<?= APP_URL ?>/admin/users" class="nav-link <?= isActive('/admin/users', $currentPath) ?>">
                <i data-lucide="users"></i>
                <span>Manage Users</span>
            </a>
            <a href="<?= APP_URL ?>/admin/create-hod" class="nav-link <?= isActive('/admin/create-hod', $currentPath) ?>">
                <i data-lucide="user-plus"></i>
                <span>Create HOD</span>
            </a>
            <a href="<?= APP_URL ?>/admin/create-supervisor" class="nav-link <?= isActive('/admin/create-supervisor', $currentPath) ?>">
                <i data-lucide="user-cog"></i>
                <span>Create Supervisor</span>
            </a>
            <a href="<?= APP_URL ?>/admin/upload-students" class="nav-link <?= isActive('/admin/upload-students', $currentPath) ?>">
                <i data-lucide="upload"></i>
                <span>Upload Students</span>
            </a>
            <a href="<?= APP_URL ?>/admin/departments" class="nav-link <?= isActive('/admin/departments', $currentPath) ?>">
                <i data-lucide="building-2"></i>
                <span>Departments</span>
            </a>
            <a href="<?= APP_URL ?>/admin/settings" class="nav-link <?= isActive('/admin/settings', $currentPath) ?>">
                <i data-lucide="settings"></i>
                <span>System Settings</span>
            </a>
        </div>

        <?php elseif ($role === 'hod'): ?>
        <!-- HOD Navigation -->
        <div class="nav-section">
            <span class="nav-section-title">Department</span>
            <a href="<?= APP_URL ?>/hod/groups" class="nav-link <?= isActive('/hod/groups', $currentPath) ?>">
                <i data-lucide="users"></i>
                <span>Manage Groups</span>
            </a>
            <a href="<?= APP_URL ?>/hod/repo-requests" class="nav-link <?= isActive('/hod/repo-requests', $currentPath) ?>">
                <i data-lucide="git-pull-request"></i>
                <span>Repo Requests</span>
                <?php if (isset($pendingRequests) && $pendingRequests > 0): ?>
                    <span class="nav-badge"><?= $pendingRequests ?></span>
                <?php endif; ?>
            </a>
            <a href="<?= APP_URL ?>/hod/submissions" class="nav-link <?= isActive('/hod/submissions', $currentPath) ?>">
                <i data-lucide="check-square"></i>
                <span>Review Submissions</span>
            </a>
            <a href="<?= APP_URL ?>/hod/upload-students" class="nav-link <?= isActive('/hod/upload-students', $currentPath) ?>">
                <i data-lucide="upload"></i>
                <span>Upload Students</span>
            </a>
            <a href="<?= APP_URL ?>/hod/archived" class="nav-link <?= isActive('/hod/archived', $currentPath) ?>">
                <i data-lucide="archive"></i>
                <span>Archived Projects</span>
            </a>
        </div>

        <?php elseif ($role === 'supervisor'): ?>
        <!-- Supervisor Navigation -->
        <div class="nav-section">
            <span class="nav-section-title">Supervision</span>
            <a href="<?= APP_URL ?>/supervisor/groups" class="nav-link <?= isActive('/supervisor/groups', $currentPath) ?>">
                <i data-lucide="briefcase"></i>
                <span>My Groups</span>
            </a>
        </div>

        <?php elseif ($role === 'student'): ?>
        <!-- Student Navigation -->
        <div class="nav-section">
            <span class="nav-section-title">Project</span>
            <a href="<?= APP_URL ?>/student/group" class="nav-link <?= isActive('/student/group', $currentPath) ?>">
                <i data-lucide="users"></i>
                <span>My Group</span>
            </a>
        </div>
        <?php endif; ?>

        <?php if ($role === 'student' || $role === 'supervisor'): ?>
        <!-- Tools (Student & Supervisor) -->
        <div class="nav-section">
            <span class="nav-section-title">Tools</span>
            <?php if ($role === 'student'): ?>
            <a href="<?= APP_URL ?>/playground" class="nav-link <?= isActive('/playground', $currentPath) ?>">
                <i data-lucide="play-circle"></i>
                <span>Code Playground</span>
            </a>
            <a href="<?= APP_URL ?>/cheat-sheets" class="nav-link <?= isActive('/cheat-sheets', $currentPath) ?>">
                <i data-lucide="book-open"></i>
                <span>Cheat Sheets</span>
            </a>
            <a href="<?= APP_URL ?>/learning" class="nav-link <?= isActive('/learning', $currentPath) ?>">
                <i data-lucide="graduation-cap"></i>
                <span>Learning Guide</span>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Common -->
        <div class="nav-section">
            <span class="nav-section-title">Account</span>
            <a href="<?= APP_URL ?>/profile" class="nav-link <?= isActive('/profile', $currentPath) ?>">
                <i data-lucide="user"></i>
                <span>Profile</span>
            </a>
            <a href="<?= APP_URL ?>/settings" class="nav-link <?= isActive('/settings', $currentPath) ?>">
                <i data-lucide="settings"></i>
                <span>Settings</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="<?= APP_URL ?>/logout" class="nav-link logout-link">
            <i data-lucide="log-out"></i>
            <span>Sign Out</span>
        </a>
    </div>
</aside>
