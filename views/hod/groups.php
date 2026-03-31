<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-users-rectangle text-ocean-500"></i> Departmental Project Groups</h1>
        <p>Monitor all active research teams within your department.</p>
    </div>
    <div class="header-actions">
        <a href="<?= APP_URL ?>/hod/repo-requests" class="btn btn-secondary btn-sm"><i class="fa-solid fa-clipboard-check"></i> Review Proposals</a>
    </div>
</div>

<div class="card animate__animated animate__fadeInUp">
    <div class="table-responsive">
        <table class="table-hover">
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Status</th>
                    <th>Members</th>
                    <th>Formed On</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($groups)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-10 text-slate-500">No project groups formed in your department yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($groups as $g): ?>
                        <tr>
                            <td>
                                <span class="font-bold text-slate-100"><?= htmlspecialchars($g['name']) ?></span>
                            </td>
                            <td>
                                <span class="badge badge-outline uppercase text-[10px]"><?= $g['status'] ?></span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-user-group text-[10px] text-slate-500"></i>
                                    <span class="text-xs font-bold text-ocean-400"><?= $g['member_count'] ?> Members</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-slate-400"><?= date('M d, Y', strtotime($g['created_at'])) ?></span>
                            </td>
                            <td class="text-right">
                                <button class="btn btn-ghost btn-sm text-slate-400">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
