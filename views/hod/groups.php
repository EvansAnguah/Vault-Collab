<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-list-check mr-3 text-blue-600"></i> Departmental Project Groups</h1>
    <div class="flex gap-2">
        <a href="<?= APP_URL ?>/hod/repo-requests" class="btn btn-blue btn-sm">
            <i class="fa-solid fa-clipboard-check mr-2"></i> Review Proposals
        </a>
    </div>
</div>

<div class="card animate-fade">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Group Detail</th>
                    <th>Status</th>
                    <th>Team Size</th>
                    <th>Date Formed</th>
                    <th class="text-right">Administration</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($groups)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-20">
                            <i class="fa-solid fa-users-viewfinder text-5xl text-gray-100 mb-4 font-thin block"></i>
                            <p class="text-sm text-gray-400">No project groups have been established in your department yet.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($groups as $g): ?>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="user-avatar w-8 h-8 text-[10px] uppercase font-bold text-gray-500">
                                        <?= strtoupper(substr($g['name'], 0, 1)) ?>
                                    </div>
                                    <span class="font-bold text-gray-900"><?= htmlspecialchars($g['name']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info uppercase text-[10px] font-bold"><?= $g['status'] ?></span>
                            </td>
                            <td>
                                <span class="text-[11px] font-bold text-gray-600 uppercase tracking-tighter">
                                    <i class="fa-solid fa-user-group text-blue-300 mr-2"></i>
                                    <?= $g['member_count'] ?> Students
                                </span>
                            </td>
                            <td>
                                <span class="text-xs text-gray-500 italic font-mono"><?= date('M d, Y', strtotime($g['created_at'])) ?></span>
                            </td>
                            <td class="text-right">
                                <a href="<?= APP_URL ?>/hod/groups/view/<?= $g['id'] ?>" class="btn btn-sm">
                                    <i class="fa-solid fa-arrow-right-long text-gray-400"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 bg-blue-50 border border-blue-100 p-6 rounded flex items-start gap-4">
    <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
    <p class="text-xs text-blue-900 leading-relaxed max-w-4xl">
        <strong>Academic Oversight:</strong> All active groups listed above have been verified as legitimate research teams within your department. 
        You can monitor their progress, verify member contributions, and ensure academic integrity through the management console.
    </p>
</div>
