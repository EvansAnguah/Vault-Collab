<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-box-open mr-3 text-blue-600"></i> Project Repository Vault</h1>
    <span class="badge badge-info uppercase text-[10px] font-bold"><?= count($archived) ?> Immutable Records</span>
</div>

<div class="card animate-fade">
    <div class="card-header bg-gray-50/50">
        <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">Historical Research Data</h3>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Research Team</th>
                    <th>Finalized Project Title</th>
                    <th>Lead Supervisor</th>
                    <th>Archival Date</th>
                    <th class="text-right">Administration</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($archived)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-20">
                            <i class="fa-solid fa-folder-closed text-5xl text-gray-100 mb-4 block"></i>
                            <p class="text-xs text-gray-400">The university vault is currently empty for this session.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($archived as $a): ?>
                        <tr>
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900"><?= htmlspecialchars($a['group_name']) ?></span>
                                    <span class="text-[9px] text-gray-400 font-mono uppercase tracking-widest">ID: <?= htmlspecialchars($a['repo_id']) ?></span>
                                </div>
                            </td>
                            <td class="max-w-md">
                                <span class="text-sm font-semibold text-gray-700 leading-tight"><?= htmlspecialchars($a['project_title']) ?></span>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="user-avatar text-[9px] w-6 h-6 border border-gray-100 uppercase font-bold text-gray-500 bg-gray-50">S</div>
                                    <span class="text-[11px] font-bold text-gray-600"><?= htmlspecialchars($a['supervisor_name']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-gray-400 italic font-mono"><?= date('M d, Y', strtotime($a['archived_at'])) ?></span>
                            </td>
                            <td class="text-right">
                                <a href="<?= APP_URL ?>/hod/vault/view/<?= $a['id'] ?>" class="btn btn-sm btn-ghost text-blue-600 hover:bg-blue-50">
                                    <i class="fa-solid fa-file-shield mr-2"></i> Inspect Record
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 bg-gray-50 border border-gray-200 p-6 rounded-lg flex items-start gap-4">
    <i class="fa-solid fa-shield-halved text-gray-300 text-lg"></i>
    <p class="text-[10px] text-gray-500 leading-relaxed max-w-3xl">
        <strong>Vault Integrity:</strong> Archived projects represent fixed snapshots of the final repository state. 
        These records are preserved as immutable artifacts for academic compliance, plagiarism cross-referencing, and historical institutional research.
    </p>
</div>
