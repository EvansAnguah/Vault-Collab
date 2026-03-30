<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-graduation-cap mr-3 text-blue-600"></i> Final Academic Submissions</h1>
    <span class="badge badge-warning uppercase text-[10px] font-bold"><?= count($submissions) ?> For Final Review</span>
</div>

<div class="card animate-fade">
    <div class="card-header bg-gray-50/50">
        <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">Recommended Projects</h3>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Research Team</th>
                    <th>Official Project Title</th>
                    <th>Faculty Endorsement</th>
                    <th class="text-right">Academic Finalization</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($submissions)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-20">
                            <i class="fa-solid fa-cloud-check text-5xl text-gray-100 mb-4 block"></i>
                            <p class="text-xs text-gray-400">All student projects have been successfully archived for this cycle.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($submissions as $sub): ?>
                        <tr>
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900"><?= htmlspecialchars($sub['group_name']) ?></span>
                                    <span class="text-[9px] text-gray-400 font-mono uppercase tracking-widest">ID: <?= htmlspecialchars($sub['repo_id']) ?></span>
                                </div>
                            </td>
                            <td class="max-w-md">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-blue-600 leading-tight"><?= htmlspecialchars($sub['repo_title']) ?></span>
                                    <span class="text-[9px] text-gray-400 mt-1 uppercase font-bold tracking-tighter italic">Pending Repository Snapshot</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    <div class="flex flex-col">
                                        <span class="text-[11px] font-bold text-gray-700">Recommended by <?= htmlspecialchars($sub['sup_first'] . ' ' . $sub['sup_last']) ?></span>
                                        <span class="text-[9px] text-gray-400 font-mono uppercase"><?= date('M d, Y', strtotime($sub['created_at'])) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <form method="POST" action="<?= APP_URL ?>/hod/archive-project" class="inline-block" onsubmit="return confirm('Verification: Final archival creates a permanent immutable record in the university vault. Proceed?')">
                                    <?= \App\Core\Session::csrfField() ?>
                                    <input type="hidden" name="repo_id" value="<?= $sub['repo_id'] ?>">
                                    <button type="submit" class="btn btn-blue btn-sm px-6 font-bold uppercase tracking-widest text-[10px]">
                                        <i class="fa-solid fa-box-archive mr-2"></i> Execute Archive
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 bg-blue-50 border border-blue-100 p-6 rounded-lg flex items-start gap-5">
    <i class="fa-solid fa-circle-check text-blue-600 text-lg"></i>
    <div>
        <h4 class="text-xs font-bold text-blue-900 uppercase tracking-widest mb-1">Archival Protocol</h4>
        <p class="text-[11px] text-blue-800 leading-relaxed max-w-3xl">
            Projects reaching this terminal stage have undergone full academic verification by their respective supervisors. 
            Final archival secures the research data permanently and concludes the active collaborative phase for the group.
        </p>
    </div>
</div>
