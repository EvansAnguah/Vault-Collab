<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-archive text-ocean-500"></i> Archived Projects</h1>
        <p>A permanent record of completed and defended project milestones in your department.</p>
    </div>
</div>

<div class="card animate__animated animate__fadeInUp">
    <div class="table-responsive">
        <table class="table-hover">
            <thead>
                <tr>
                    <th>Archived Date</th>
                    <th>Project Title</th>
                    <th>Group</th>
                    <th>Supervisor</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($archived)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-12 text-slate-500">
                            <i class="fa-solid fa-folder-open text-4xl mb-4"></i>
                            <p>No projects archived in your department yet.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($archived as $a): ?>
                        <tr>
                            <td>
                                <span class="text-xs text-slate-400 font-mono"><?= date('M d, Y', strtotime($a['archived_at'])) ?></span>
                            </td>
                            <td class="font-bold text-slate-100 max-w-sm truncate" title="<?= htmlspecialchars($a['project_title']) ?>"><?= htmlspecialchars($a['project_title']) ?></td>
                            <td><?= htmlspecialchars($a['group_name']) ?></td>
                            <td><?= htmlspecialchars($a['supervisor_name']) ?></td>
                            <td class="text-right">
                                <a href="<?= APP_URL ?>/workspace/<?= $a['repo_id'] ?>/download" class="btn btn-outline border-slate-700 btn-xs">Download Bundle</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
