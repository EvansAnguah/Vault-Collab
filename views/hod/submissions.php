<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-file-import text-ocean-500"></i> Final Project Submissions</h1>
        <p>Review completed projects recommended by supervisors for departmental archival.</p>
    </div>
</div>

<div class="card animate__animated animate__fadeInUp">
    <div class="table-responsive">
        <table class="table-hover">
            <thead>
                <tr>
                    <th>Group</th>
                    <th>Project Title</th>
                    <th>Supervisor</th>
                    <th>Status</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($submissions)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-12 text-slate-500">
                            <i class="fa-solid fa-inbox text-4xl mb-4"></i>
                            <p>No final submissions awaiting review.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($submissions as $s): ?>
                        <tr>
                            <td class="font-bold text-slate-100"><?= htmlspecialchars($s['group_name']) ?></td>
                            <td class="max-w-md"><?= htmlspecialchars($s['repo_title']) ?></td>
                            <td>
                                <span class="text-xs text-slate-400"><?= htmlspecialchars($s['sup_first'] . ' ' . $s['sup_last']) ?></span>
                            </td>
                            <td>
                                <span class="badge badge-primary">READY FOR ARCHIVE</span>
                            </td>
                            <td class="text-right">
                                <div class="flex gap-2 justify-end">
                                    <a href="<?= APP_URL ?>/workspace/<?= $s['repo_id'] ?>" class="btn btn-outline border-slate-700 btn-xs">Inspect Project</a>
                                    <form method="POST" action="<?= APP_URL ?>/hod/archive-project" onsubmit="return confirm('Archive this project? It will become immutable.')">
                                        <?= \App\Core\Session::csrfField() ?>
                                        <input type="hidden" name="repo_id" value="<?= $s['repo_id'] ?>">
                                        <button type="submit" class="btn btn-primary btn-xs">Archive Project</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
