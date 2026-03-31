<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-file-signature text-ocean-500"></i> Project Repository Requests</h1>
        <p>Review and approve project proposals submitted by student groups.</p>
    </div>
</div>

<div class="card animate__animated animate__fadeInUp">
    <div class="table-responsive">
        <table class="table-hover">
            <thead>
                <tr>
                    <th>Group</th>
                    <th>Project Title</th>
                    <th>Leader</th>
                    <th>Requested On</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($requests)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-12">
                            <div class="text-slate-500">
                                <i class="fa-solid fa-clipboard-list text-4xl mb-3"></i>
                                <p>No pending repository requests at the moment.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($requests as $r): ?>
                        <tr>
                            <td>
                                <span class="font-bold text-slate-100"><?= htmlspecialchars($r['group_name']) ?></span>
                            </td>
                            <td>
                                <div class="flex flex-col max-w-sm">
                                    <span class="text-sm font-medium text-slate-200"><?= htmlspecialchars($r['title']) ?></span>
                                    <span class="text-[10px] text-slate-500 truncate" title="<?= htmlspecialchars($r['description']) ?>"><?= htmlspecialchars(substr($r['description'], 0, 80)) ?>...</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-300"><?= htmlspecialchars($r['leader_first'] . ' ' . $r['leader_last']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-slate-400"><?= date('M d, Y', strtotime($r['created_at'])) ?></span>
                            </td>
                            <td class="text-right">
                                <button class="btn btn-primary btn-sm" onclick="openReviewModal(<?= $r['id'] ?>, '<?= htmlspecialchars(addslashes($r['title'])) ?>')">
                                    Review Proposal
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Review Modal -->
<div id="review-modal" class="modal-overlay">
    <div class="modal animate__animated animate__slideInDown max-w-lg">
        <div class="modal-header">
            <h3>Review Project Proposal</h3>
            <button class="btn btn-ghost" onclick="closeModal('review-modal')">&times;</button>
        </div>
        <div class="modal-body p-6">
            <h4 id="project-title" class="text-lg font-bold text-ocean-400 mb-6"></h4>
            
            <form method="POST" action="<?= APP_URL ?>/hod/repo-requests/review">
                <?= \App\Core\Session::csrfField() ?>
                <input type="hidden" name="request_id" id="modal-request-id">
                
                <div class="form-group mb-6">
                    <label class="form-label font-bold text-slate-100">Assign Supervisor (For Approval Only)</label>
                    <select name="supervisor_id" id="modal-supervisor-id" class="form-control" required disabled>
                        <option value="">Select a supervisor...</option>
                        <?php foreach ($supervisors as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?> (<?= $s['index_number'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-[9px] text-slate-500 mt-2 italic">* Supervisor must be assigned at the time of approval.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="submit" name="action" value="declined" class="btn btn-outline border-rose-500/30 text-rose-500 hover:bg-rose-500/10" onclick="setSupervisorRequired(false)">
                        <i class="fa-solid fa-xmark mr-2"></i> Decline
                    </button>
                    <button type="submit" name="action" value="approved" class="btn btn-primary" onclick="setSupervisorRequired(true)">
                        <i class="fa-solid fa-check mr-2"></i> Approve & Active Repo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openReviewModal(requestId, title) {
    document.getElementById('modal-request-id').value = requestId;
    document.getElementById('project-title').textContent = title;
    document.getElementById('review-modal').classList.add('active');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}
function setSupervisorRequired(required) {
    const select = document.getElementById('modal-supervisor-id');
    select.disabled = !required;
    select.required = required;
}
</script>
