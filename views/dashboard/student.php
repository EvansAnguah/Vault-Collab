<?php use function App\Core\e; use function App\Core\time_ago; ?>

<!-- Welcome Card -->
<div class="welcome-card animate__animated animate__fadeIn">
    <h2>👋 Welcome, <?= e($user['first_name']) ?>!</h2>
    <p>Build your final year project, collaborate with your team, and create something amazing.</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card ocean animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="stat-icon"><i data-lucide="folder-git-2" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $hasRepo ? '1' : '0' ?></div>
        <div class="stat-label">My Repository</div>
    </div>
    <div class="stat-card teal animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="stat-icon"><i data-lucide="users" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $groupMembers ?? 0 ?></div>
        <div class="stat-label">Team Members</div>
    </div>
    <div class="stat-card purple animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="stat-icon"><i data-lucide="message-square" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $unreadMessages ?? 0 ?></div>
        <div class="stat-label">Unread Messages</div>
    </div>
    <div class="stat-card amber animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <div class="stat-icon"><i data-lucide="calendar" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $upcomingMeetings ?? 0 ?></div>
        <div class="stat-label">Upcoming Meetings</div>
    </div>
</div>

<!-- Content Grid -->
<div class="dashboard-grid">
    <!-- Project Status -->
    <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="card-header">
            <h3 style="font-size: var(--text-base);">Project Status</h3>
        </div>
        <div class="card-body">
            <?php if (isset($group) && $group): ?>
                <div style="margin-bottom: var(--space-6);">
                    <div style="display:flex;justify-content:space-between;margin-bottom:var(--space-2);">
                        <span class="text-sm font-semibold" style="color:var(--navy-100);">Group: <?= e($group['name']) ?></span>
                        <span class="badge badge-<?= $group['status'] === 'active' ? 'primary' : 'success' ?>"><?= ucfirst($group['status']) ?></span>
                    </div>
                    <?php if (isset($repo) && $repo): ?>
                        <p class="text-sm" style="margin-bottom:var(--space-4);"><?= e($repo['title']) ?></p>
                        <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>" class="btn btn-primary btn-block">
                            <i data-lucide="code" style="width:16px;height:16px;"></i>
                            Open Workspace
                        </a>
                    <?php else: ?>
                        <p class="text-sm text-muted mb-4">No repository yet. Submit a request to your HOD to get started.</p>
                        <a href="<?= APP_URL ?>/student/request-repo" class="btn btn-primary btn-block">
                            <i data-lucide="plus" style="width:16px;height:16px;"></i>
                            Request Repository
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Supervisor Info -->
                <?php if (isset($supervisor) && $supervisor): ?>
                <div style="padding-top:var(--space-4);border-top:1px solid var(--glass-border);">
                    <span class="text-xs text-muted" style="text-transform:uppercase;letter-spacing:0.05em;">Supervisor</span>
                    <div style="display:flex;align-items:center;gap:var(--space-3);margin-top:var(--space-2);">
                        <div class="avatar avatar-sm" style="background:var(--teal-600);">
                            <?= strtoupper(substr($supervisor['first_name'], 0, 1) . substr($supervisor['last_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <strong class="text-sm"><?= e($supervisor['first_name'] . ' ' . $supervisor['last_name']) ?></strong>
                            <p class="text-xs text-muted"><?= e($supervisor['email']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">👥</div>
                    <h3>No Group Yet</h3>
                    <p>Create or join a group to start your project.</p>
                    <a href="<?= APP_URL ?>/student/create-group" class="btn btn-primary mt-4">
                        <i data-lucide="plus" style="width:16px;height:16px;"></i>
                        Create Group
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <div class="card-header">
            <h3 style="font-size: var(--text-base);">Quick Access</h3>
        </div>
        <div class="card-body">
            <div class="quick-actions">
                <a href="<?= APP_URL ?>/student/group" class="quick-action-btn">
                    <i data-lucide="users"></i>
                    My Group
                </a>
                <a href="<?= APP_URL ?>/playground" class="quick-action-btn">
                    <i data-lucide="play-circle"></i>
                    Code Playground
                </a>
                <a href="<?= APP_URL ?>/cheat-sheets" class="quick-action-btn">
                    <i data-lucide="book-open"></i>
                    Cheat Sheets
                </a>
                <a href="<?= APP_URL ?>/learning" class="quick-action-btn">
                    <i data-lucide="graduation-cap"></i>
                    Learning Guide
                </a>
            </div>
        </div>

        <!-- Notices -->
        <?php if (!empty($notices)): ?>
        <div class="card-footer" style="background:rgba(245,158,11,0.05);border-top-color:rgba(245,158,11,0.15);">
            <div style="display:flex;align-items:center;gap:var(--space-2);color:var(--warning);margin-bottom:var(--space-2);">
                <i data-lucide="bell" style="width:16px;height:16px;"></i>
                <strong class="text-sm">Supervisor Notice</strong>
            </div>
            <?php foreach ($notices as $notice): ?>
                <p class="text-sm"><?= e($notice['content']) ?></p>
                <span class="text-xs text-muted"><?= time_ago($notice['created_at']) ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
