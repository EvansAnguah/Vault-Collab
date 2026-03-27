<?php use function App\Core\e; use function App\Core\time_ago; ?>

<!-- Welcome Card -->
<div class="welcome-card animate__animated animate__fadeIn">
    <h2>👋 Welcome, <?= e($user['first_name']) ?>!</h2>
    <p>Monitor your assigned groups, review student work, and collaborate on final year projects.</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card ocean animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="stat-icon"><i data-lucide="briefcase" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $assignedGroups ?? 0 ?></div>
        <div class="stat-label">Assigned Groups</div>
    </div>
    <div class="stat-card teal animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="stat-icon"><i data-lucide="message-square" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $pendingReviews ?? 0 ?></div>
        <div class="stat-label">Pending Reviews</div>
    </div>
    <div class="stat-card purple animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="stat-icon"><i data-lucide="calendar" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $upcomingMeetings ?? 0 ?></div>
        <div class="stat-label">Upcoming Meetings</div>
    </div>
    <div class="stat-card emerald animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <div class="stat-icon"><i data-lucide="check-circle" style="width:24px;height:24px;color:white;"></i></div>
        <div class="stat-value"><?= $completedProjects ?? 0 ?></div>
        <div class="stat-label">Completed Projects</div>
    </div>
</div>

<!-- Content Grid -->
<div class="dashboard-grid">
    <!-- Assigned Groups -->
    <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="card-header">
            <h3 style="font-size: var(--text-base);">My Assigned Groups</h3>
            <a href="<?= APP_URL ?>/supervisor/groups" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body">
            <?php if (!empty($groups)): ?>
                <ul class="activity-list">
                    <?php foreach ($groups as $group): ?>
                        <li class="activity-item">
                            <div class="activity-icon blue"><i data-lucide="folder" style="width:16px;height:16px;"></i></div>
                            <div class="activity-content">
                                <p><strong><?= e($group['title'] ?? $group['name']) ?></strong></p>
                                <span class="activity-time"><?= e($group['member_count'] ?? '0') ?> members</span>
                            </div>
                            <span class="badge badge-<?= ($group['status'] ?? 'active') === 'active' ? 'primary' : 'success' ?>"><?= ucfirst($group['status'] ?? 'active') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="empty-state"><p class="text-muted">No groups assigned yet</p></div>
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
                <a href="<?= APP_URL ?>/supervisor/groups" class="quick-action-btn">
                    <i data-lucide="briefcase"></i>
                    My Groups
                </a>
                <a href="#" class="quick-action-btn">
                    <i data-lucide="message-circle"></i>
                    Group Chat
                </a>
                <a href="#" class="quick-action-btn">
                    <i data-lucide="video"></i>
                    Start Meeting
                </a>
                <a href="#" class="quick-action-btn">
                    <i data-lucide="clipboard-list"></i>
                    Review Logbook
                </a>
            </div>
        </div>
    </div>
</div>
