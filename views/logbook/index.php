<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>" class="text-slate-500 hover:text-ocean-400 transition-colors"><i class="fa-solid fa-arrow-left"></i> Workspace</a>
            <span class="text-slate-700">/</span>
            <span class="text-ocean-400 font-bold"><?= htmlspecialchars($repo['title']) ?> Logbook</span>
        </div>
        <h1><i class="fa-solid fa-book text-ocean-500"></i> Project Activity Log</h1>
        <p>A chronological record of research, development, and supervision milestones.</p>
    </div>
    <div class="header-actions">
        <?php if (\App\Core\Auth::role() == 'student'): ?>
            <button class="btn btn-primary btn-sm" onclick="openModal('add-entry-modal')">
                <i class="fa-solid fa-pen-nib"></i> New Activity
            </button>
        <?php endif; ?>
    </div>
</div>

<div class="card animate__animated animate__fadeInUp">
    <div class="table-responsive">
        <table class="table-hover">
            <thead>
                <tr>
                    <th class="w-16">S.No</th>
                    <th class="w-40">Date & Time</th>
                    <th>Activity Description</th>
                    <th>Recorded By</th>
                    <th>Supervisor Remarks</th>
                    <?php if (\App\Core\Auth::role() == 'supervisor'): ?>
                        <th class="text-right">Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($entries)): ?>
                    <tr>
                        <td colspan="<?= \App\Core\Auth::role() == 'supervisor' ? 6 : 5 ?>" class="text-center py-12 text-slate-500">
                            <i class="fa-solid fa-feather text-4xl mb-4 text-slate-800"></i>
                            <p>No activity recorded in the logbook yet.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($entries as $e): ?>
                        <tr>
                            <td class="font-mono text-xs text-ocean-400">#<?= str_pad($e['serial_no'], 3, '0', STR_PAD_LEFT) ?></td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="text-xs text-slate-200"><?= date('M d, Y', strtotime($e['date_time'])) ?></span>
                                    <span class="text-[10px] text-slate-500"><?= date('H:i', strtotime($e['date_time'])) ?></span>
                                </div>
                            </td>
                            <td>
                                <p class="text-sm text-slate-300"><?= htmlspecialchars($e['activity']) ?></p>
                            </td>
                            <td>
                                <span class="text-xs font-bold text-slate-400"><?= htmlspecialchars($e['first_name']) ?></span>
                            </td>
                            <td>
                                <?php if ($e['remark']): ?>
                                    <div class="flex flex-col p-2 bg-emerald-500/5 rounded border border-emerald-500/10">
                                        <p class="text-xs italic text-emerald-400">"<?= htmlspecialchars($e['remark']) ?>"</p>
                                        <span class="text-[9px] mt-1 text-slate-500">- <?= htmlspecialchars($e['sup_first']) ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-[10px] text-slate-600 italic">No remarks yet</span>
                                <?php endif; ?>
                            </td>
                            <?php if (\App\Core\Auth::role() == 'supervisor'): ?>
                                <td class="text-right">
                                    <button class="btn btn-ghost btn-xs text-ocean-400" onclick="openRemarkModal(<?= $e['id'] ?>)">
                                        <i class="fa-solid fa-comment-dots mr-1"></i> Add Remark
                                    </button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Entry Modal -->
<div id="add-entry-modal" class="modal-overlay">
    <div class="modal animate__animated animate__slideInDown max-w-lg">
        <div class="modal-header">
            <h3>New Logbook Entry</h3>
            <button class="btn btn-ghost" onclick="closeModal('add-entry-modal')">&times;</button>
        </div>
        <div class="modal-body p-6">
            <form method="POST" action="<?= APP_URL ?>/logbook/add">
                <?= \App\Core\Session::csrfField() ?>
                <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
                
                <div class="form-group mb-6">
                    <label class="form-label font-bold text-slate-100">Describe Today's Activity</label>
                    <textarea name="activity" class="form-control" rows="5" required placeholder="What milestones did you achieve today?"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-full py-4 shadow-lg shadow-ocean-500/20">
                    <i class="fa-solid fa-save mr-2"></i> Record Entry
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Add Remark Modal (Supervisor) -->
<div id="remark-modal" class="modal-overlay">
    <div class="modal animate__animated animate__slideInDown max-w-md">
        <div class="modal-header">
            <h3>Supervisor Remark</h3>
            <button class="btn btn-ghost" onclick="closeModal('remark-modal')">&times;</button>
        </div>
        <div class="modal-body p-6">
            <form method="POST" action="<?= APP_URL ?>/supervisor/remark">
                <?= \App\Core\Session::csrfField() ?>
                <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
                <input type="hidden" name="logbook_entry_id" id="modal-entry-id">
                
                <div class="form-group mb-6">
                    <label class="form-label font-bold text-slate-100 italic">Your Remark</label>
                    <textarea name="remark" class="form-control" rows="3" required placeholder="Guidance for the student..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 shadow-lg shadow-ocean-500/20">
                    <i class="fa-solid fa-check mr-2"></i> Submit Remark
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
function openRemarkModal(id) {
    document.getElementById('modal-entry-id').value = id;
    openModal('remark-modal');
}
</script>
