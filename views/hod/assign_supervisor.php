<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-user-tie text-ocean-500"></i> Assign Project Supervisors</h1>
        <p>Allocate academic supervisors to newly approved project repositories.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp">
    <!-- Unassigned Repositories -->
    <div class="lg:col-span-2 card bg-slate-800/20 border-slate-700/50">
        <div class="table-responsive">
            <table class="table-hover">
                <thead>
                    <tr>
                        <th>Repository Title</th>
                        <th>Group</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($repositories)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-10 text-slate-500">No unassigned repositories found. All currently active projects have supervisors.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($repositories as $r): ?>
                            <tr>
                                <td>
                                    <span class="font-bold text-slate-100"><?= htmlspecialchars($r['title']) ?></span>
                                </td>
                                <td>
                                    <span class="text-xs text-slate-400 font-mono"><?= htmlspecialchars($r['group_name']) ?></span>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-primary btn-sm" onclick="selectRepo(<?= $r['id'] ?>, '<?= htmlspecialchars(addslashes($r['title'])) ?>')">
                                        Assign Supervisor
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Assignment Sidebar -->
    <div id="assignment-pane" class="card bg-slate-900 border-slate-800 hidden">
        <div class="card-body">
            <h3 class="text-sm font-bold uppercase tracking-widest text-ocean-400 mb-6">Allocate Supervisor</h3>
            <div id="selected-repo-title" class="text-xs text-slate-300 font-bold mb-6 italic"></div>
            
            <form method="POST" action="<?= APP_URL ?>/hod/assign-supervisor">
                <?= \App\Core\Session::csrfField() ?>
                <input type="hidden" name="repo_id" id="modal-repo-id">
                
                <div class="form-group mb-6">
                    <label class="form-label font-bold text-slate-100">Select Supervisor</label>
                    <select name="supervisor_id" class="form-control" required>
                        <option value="">Choose a Supervisor...</option>
                        <?php foreach ($supervisors as $s): ?>
                            <option value="<?= $s['id'] ?>">
                                <?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 shadow-lg shadow-ocean-500/20">
                    <i class="fa-solid fa-link mr-2"></i> Confirm Assignment
                </button>
                <button type="button" class="btn btn-ghost w-full btn-sm mt-4" onclick="hidePane()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Placeholder for Pane -->
    <div id="placeholder-pane" class="card bg-slate-900/40 border-slate-800 border-dashed">
        <div class="card-body flex flex-col items-center justify-center py-20 text-center">
            <i class="fa-solid fa-hand-pointer text-4xl text-slate-700 mb-4"></i>
            <p class="text-sm text-slate-500">Select a repository from the list to assign a supervisor.</p>
        </div>
    </div>
</div>

<script>
function selectRepo(repoId, title) {
    document.getElementById('modal-repo-id').value = repoId;
    document.getElementById('selected-repo-title').textContent = title;
    document.getElementById('assignment-pane').classList.remove('hidden');
    document.getElementById('placeholder-pane').classList.add('hidden');
    document.getElementById('assignment-pane').scrollIntoView({ behavior: 'smooth' });
}
function hidePane() {
    document.getElementById('assignment-pane').classList.add('hidden');
    document.getElementById('placeholder-pane').classList.remove('hidden');
}
</script>
