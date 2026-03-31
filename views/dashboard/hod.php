<?php use function App\Core\e; use function App\Core\time_ago; ?>

<!-- Welcome Card -->
<div class="welcome-card animate__animated animate__fadeIn">
    <h2>👋 Welcome, <?= e($user['first_name']) ?>!</h2>
    <p>Manage your department's groups, review repository requests, and oversee project progress.</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card ocean animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="stat-icon"><i data-lucide="users" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $studentCount ?? 0 ?></div>
        <div class="stat-label">Department Students</div>
    </div>
    <div class="stat-card teal animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="stat-icon"><i data-lucide="users" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $groupCount ?? 0 ?></div>
        <div class="stat-label">Active Groups</div>
    </div>
    <div class="stat-card amber animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="stat-icon"><i data-lucide="git-pull-request" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $pendingRequests ?? 0 ?></div>
        <div class="stat-label">Pending Requests</div>
    </div>
    <div class="stat-card emerald animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <div class="stat-icon"><i data-lucide="archive" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $archivedCount ?? 0 ?></div>
        <div class="stat-label">Archived Projects</div>
    </div>
</div>

<!-- Content Grid -->
<div class="dashboard-grid">
    <!-- Pending Requests -->
    <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="card-header">
            <h3 style="font-size: var(--text-base);">Pending Repo Requests</h3>
            <a href="<?= APP_URL ?>/hod/repo-requests" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body">
            <?php if (!empty($recentRequests)): ?>
                <ul class="activity-list">
                    <?php foreach ($recentRequests as $req): ?>
                        <li class="activity-item">
                            <div class="activity-icon amber"><i data-lucide="git-pull-request" style="width:16px;height:16px;"></i></div>
                            <div class="activity-content">
                                <p><strong><?= e($req['title']) ?></strong></p>
                                <span class="activity-time"><?= time_ago($req['created_at']) ?></span>
                            </div>
                            <span class="badge badge-warning">Pending</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="empty-state"><p class="text-muted">No pending requests</p></div>
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
                <a href="<?= APP_URL ?>/hod/repo-requests" class="quick-action-btn">
                    <i data-lucide="git-pull-request"></i>
                    Review Requests
                </a>
                <a href="<?= APP_URL ?>/hod/groups" class="quick-action-btn">
                    <i data-lucide="users"></i>
                    Manage Groups
                </a>
                <a href="<?= APP_URL ?>/hod/upload-students" class="quick-action-btn">
                    <i data-lucide="upload"></i>
                    Upload Students
                </a>
                <a href="<?= APP_URL ?>/hod/archived" class="quick-action-btn">
                    <i data-lucide="archive"></i>
                    Archived Projects
                </a>
            </div>
        </div>
    </div>
</div>
