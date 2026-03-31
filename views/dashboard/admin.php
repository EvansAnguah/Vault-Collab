<?php use function App\Core\e; use function App\Core\format_datetime; use function App\Core\time_ago; ?>

<!-- Welcome Card -->
<div class="welcome-card animate__animated animate__fadeIn">
    <h2>👋 Welcome back, <?= e($user['first_name']) ?>!</h2>
    <p>Here's an overview of the entire system. Manage users, departments, and keep everything running smoothly.</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card ocean animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="stat-icon"><i data-lucide="users" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $stats['total'] ?? 0 ?></div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card teal animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="stat-icon"><i data-lucide="graduation-cap" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $stats['student'] ?? 0 ?></div>
        <div class="stat-label">Students</div>
    </div>
    <div class="stat-card purple animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="stat-icon"><i data-lucide="building-2" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $departmentCount ?? 0 ?></div>
        <div class="stat-label">Departments</div>
    </div>
    <div class="stat-card rose animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <div class="stat-icon"><i data-lucide="folder-git-2" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $repoCount ?? 0 ?></div>
        <div class="stat-label">Active Projects</div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="dashboard-grid">
    <!-- Recent Activity -->
    <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="card-header">
            <h3 style="font-size: var(--text-base);">Recent Activity</h3>
            <span class="badge badge-primary">Live</span>
        </div>
        <div class="card-body">
            <?php if (!empty($recentUsers)): ?>
                <ul class="activity-list">
                    <?php foreach ($recentUsers as $ru): ?>
                        <li class="activity-item">
                            <div class="activity-icon blue">
                                <i data-lucide="user-plus" style="width:16px;height:16px;"></i>
                            </div>
                            <div class="activity-content">
                                <p><strong><?= e($ru['first_name'] . ' ' . $ru['last_name']) ?></strong> registered as <span class="badge badge-<?= $ru['role'] === 'student' ? 'primary' : 'info' ?>"><?= ucfirst($ru['role']) ?></span></p>
                                <span class="activity-time"><?= time_ago($ru['created_at']) ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="empty-state">
                    <p class="text-muted">No recent activity</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <div class="card-header">
            <h3 style="font-size: var(--text-base);">Quick Actions</h3>
        </div>
        <div class="card-body">
            <div class="quick-actions">
                <a href="<?= APP_URL ?>/admin/create-hod" class="quick-action-btn">
                    <i data-lucide="user-plus"></i>
                    Create HOD
                </a>
                <a href="<?= APP_URL ?>/admin/create-supervisor" class="quick-action-btn">
                    <i data-lucide="user-cog"></i>
                    Create Supervisor
                </a>
                <a href="<?= APP_URL ?>/admin/upload-students" class="quick-action-btn">
                    <i data-lucide="upload"></i>
                    Upload Students
                </a>
                <a href="<?= APP_URL ?>/admin/departments" class="quick-action-btn">
                    <i data-lucide="building-2"></i>
                    Manage Depts
                </a>
            </div>
        </div>
    </div>
</div>

<!-- User Breakdown -->
<div class="dashboard-grid-equal mt-6">
    <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
        <div class="card-header">
            <h3 style="font-size: var(--text-base);">User Breakdown</h3>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:var(--space-4);">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="text-sm">Admins</span>
                    <span class="badge badge-danger"><?= $stats['admin'] ?? 0 ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="text-sm">HODs</span>
                    <span class="badge badge-warning"><?= $stats['hod'] ?? 0 ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="text-sm">Supervisors</span>
                    <span class="badge badge-info"><?= $stats['supervisor'] ?? 0 ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="text-sm">Students</span>
                    <span class="badge badge-primary"><?= $stats['student'] ?? 0 ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
        <div class="card-header">
            <h3 style="font-size: var(--text-base);">System Info</h3>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:var(--space-4);">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="text-sm text-muted">Version</span>
                    <span class="text-sm font-semibold"><?= APP_VERSION ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="text-sm text-muted">PHP Version</span>
                    <span class="text-sm font-semibold"><?= phpversion() ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="text-sm text-muted">Server Time</span>
                    <span class="text-sm font-semibold"><?= date('M d, Y h:i A') ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="text-sm text-muted">Timezone</span>
                    <span class="text-sm font-semibold">Africa/Accra</span>
                </div>
            </div>
        </div>
    </div>
</div>
