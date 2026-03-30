<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-book mr-3 text-blue-600"></i> Project Execution Logbook</h1>
    <div class="flex gap-2">
        <?php if (\App\Core\Auth::role() == 'student'): ?>
            <button class="btn btn-blue btn-sm" onclick="openModal('add-entry-modal')">
                <i class="fa-solid fa-pen-nib mr-2"></i> Log New Activity
            </button>
        <?php endif; ?>
    </div>
</div>

<div class="card animate-fade">
    <div class="card-header bg-gray-50/50">
        <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">Chronological Work Record</h3>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date / Time</th>
                    <th>Activity Detail</th>
                    <th>Recorded By</th>
                    <th>Supervisor Remarks</th>
                    <?php if (\App\Core\Auth::role() == 'supervisor'): ?>
                        <th class="text-right">Administration</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($entries)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-20 text-gray-400 font-thin italic">
                            <i class="fa-solid fa-feather-pointed text-5xl mb-4 font-thin border-b border-gray-100 pb-4"></i>
                            <p class="text-xs">No entries recorded in the logbook yet.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($entries as $e): ?>
                        <tr>
                            <td class="whitespace-nowrap">
                                <div class="flex flex-col text-[11px] font-mono leading-tight">
                                    <span class="font-bold text-gray-900"><?= date('M d, Y', strtotime($e['created_at'])) ?></span>
                                    <span class="text-gray-400 uppercase tracking-tighter"><?= date('h:i A', strtotime($e['created_at'])) ?></span>
                                </div>
                            </td>
                            <td class="max-w-xl">
                                <p class="text-sm font-medium text-gray-800 leading-relaxed"><?= htmlspecialchars($e['content']) ?></p>
                                <span class="badge badge-info text-[9px] mt-2 font-bold uppercase tracking-widest"><?= ucfirst($e['status'] ?? 'Draft') ?></span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="user-avatar w-6 h-6 text-[8px]"><?= strtoupper(substr($e['first_name'], 0, 1)) ?></div>
                                    <span class="text-xs text-gray-600 font-bold"><?= htmlspecialchars($e['first_name']) ?></span>
                                </div>
                            </td>
                            <td>
                                <?php if ($e['remark']): ?>
                                    <div class="p-3 bg-amber-50 border border-amber-100 rounded text-xs text-amber-900 italic relative group">
                                        <i class="fa-solid fa-quote-left mr-2 text-amber-200"></i>
                                        <?= htmlspecialchars($e['remark']) ?>
                                        <p class="text-[9px] font-bold mt-2 text-amber-600 uppercase tracking-widest">— Supervisor</p>
                                    </div>
                                <?php else: ?>
                                    <span class="text-[10px] text-gray-300 font-bold uppercase tracking-tighter">Waiting for review</span>
                                <?php endif; ?>
                            </td>
                            <?php if (\App\Core\Auth::role() == 'supervisor'): ?>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-ghost text-blue-600 hover:bg-blue-50" onclick="openRemarkModal(<?= $e['id'] ?>)">
                                        <i class="fa-solid fa-comment-dots"></i> Add Remark
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

<!-- Modals -->
<div id="add-entry-modal" class="modal-overlay">
    <div class="modal animate-fade">
        <div class="modal-header">
            <h3 class="text-sm font-bold uppercase tracking-widest">Record Activity</h3>
            <button class="btn btn-ghost" onclick="closeModal('add-entry-modal')">&times;</button>
        </div>
        <form method="POST" action="<?= APP_URL ?>/logbook/save">
            <?= \App\Core\Session::csrfField() ?>
            <div class="modal-body p-8">
                <div class="form-group mb-4">
                    <label class="form-label font-bold text-xs">Activity Description</label>
                    <textarea name="content" class="form-control" rows="4" placeholder="Briefly describe the research or development performed today..." required></textarea>
                </div>
                <button type="submit" class="btn btn-blue w-full p-3 font-bold uppercase tracking-wider">Sync to Logbook</button>
            </div>
        </form>
    </div>
</div>

<div id="remark-modal" class="modal-overlay">
    <div class="modal animate-fade">
        <div class="modal-header">
            <h3 class="text-sm font-bold uppercase tracking-widest">Supervisor Remark</h3>
            <button class="btn btn-ghost" onclick="closeModal('remark-modal')">&times;</button>
        </div>
        <form method="POST" action="<?= APP_URL ?>/logbook/remark">
            <?= \App\Core\Session::csrfField() ?>
            <input type="hidden" name="entry_id" id="remark-entry-id">
            <div class="modal-body p-8">
                <div class="form-group mb-4">
                    <label class="form-label font-bold text-xs">Correction or Review Remark</label>
                    <textarea name="remark" class="form-control" rows="3" placeholder="Provide academic guidance or feedback..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-full p-3 font-bold uppercase tracking-wider">Submit Academic Remark</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
function openRemarkModal(id) {
    document.getElementById('remark-entry-id').value = id;
    openModal('remark-modal');
}
</script>
