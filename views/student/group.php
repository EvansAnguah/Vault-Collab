<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-people-group text-ocean-500"></i> My Project Group</h1>
        <p>Manage your research partners and monitor project repository status.</p>
    </div>
    <div class="header-actions">
        <?php if (!$group): ?>
            <a href="<?= APP_URL ?>/student/create-group" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Form Group</a>
        <?php elseif ($group && !$repository && !$pendingRequest): ?>
            <a href="<?= APP_URL ?>/student/request-repo" class="btn btn-secondary btn-sm"><i class="fa-solid fa-rocket"></i> Request Repository</a>
        <?php elseif ($repository): ?>
            <a href="<?= APP_URL ?>/workspace/<?= $repository['id'] ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-code"></i> Enter Workspace</a>
        <?php endif; ?>
    </div>
</div>

<?php if (!$group): ?>
    <div class="card animate__animated animate__fadeInUp max-w-2xl mx-auto py-12 text-center">
        <div class="card-body">
            <div class="mb-6">
                <i class="fa-solid fa-users-slash text-6xl text-slate-700"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-100">No Group Found</h2>
            <p class="text-slate-400 mt-2 mb-8">You haven't formed or joined a project group yet. You need a group to request a repository and start your project.</p>
            <a href="<?= APP_URL ?>/student/create-group" class="btn btn-primary lg:px-12">Create a New Group</a>
        </div>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp">
        
        <!-- Left Column: Group Details & Members -->
        <div class="lg:col-span-2 space-y-8">
            <div class="card border-slate-700/50 bg-slate-800/20">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="text-[10px] uppercase tracking-widest font-bold text-ocean-400">Project Group</span>
                            <h2 class="text-2xl font-bold text-slate-100"><?= htmlspecialchars($group['name']) ?></h2>
                        </div>
                        <span class="badge badge-primary text-[10px] uppercase"><?= $group['status'] ?></span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($members as $m): ?>
                            <div class="flex items-center gap-4 p-4 bg-slate-900/40 rounded-xl border border-slate-800 hover:border-ocean-500/30 transition-all">
                                <div class="avatar avatar-md border border-slate-700 bg-slate-800">
                                    <?php if ($m['profile_photo']): ?>
                                        <img src="<?= APP_URL ?>/<?= $m['profile_photo'] ?>" alt="Profile">
                                    <?php else: ?>
                                        <span class="text-lg font-bold text-ocean-400"><?= strtoupper(substr($m['first_name'], 0, 1)) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-100"><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></span>
                                    <span class="text-xs text-slate-500 font-mono"><?= htmlspecialchars($m['index_number']) ?></span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] uppercase font-bold tracking-widest <?= $m['role'] == 'leader' ? 'text-amber-400' : 'text-slate-400' ?>">
                                            <i class="fa-solid <?= $m['role'] == 'leader' ? 'fa-crown' : 'fa-user' ?> mr-1"></i> <?= $m['role'] ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Add Member Placeholder -->
                        <?php if (count($members) < 4): ?>
                            <button class="flex items-center justify-center gap-3 p-4 bg-slate-900/10 border-2 border-dashed border-slate-800 rounded-xl hover:border-ocean-500/40 group transition-all"
                                    onclick="openModal('add-member-modal')">
                                <i class="fa-solid fa-plus-circle text-slate-700 group-hover:text-ocean-400 transition-colors"></i>
                                <span class="text-sm font-bold text-slate-600 group-hover:text-slate-300">Add Member</span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Project Progress / Repository Information -->
            <div class="card bg-black/20 border-slate-800">
                <div class="card-body">
                    <h3 class="text-lg font-bold text-slate-100 flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-code-branch text-ocean-400"></i> Repository Status
                    </h3>

                    <?php if ($repository): ?>
                        <div class="p-6 bg-emerald-500/5 rounded-2xl border border-emerald-500/10 flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-bold text-emerald-400"><?= htmlspecialchars($repository['title']) ?></h4>
                                <p class="text-sm text-slate-400 mt-1">Status: <span class="text-emerald-500 uppercase font-bold text-xs"><?= $repository['status'] ?></span></p>
                                <div class="flex gap-4 mt-4">
                                    <div class="flex flex-col">
                                        <span class="text-[9px] text-slate-500 uppercase font-bold tracking-widest">Supervisor</span>
                                        <span class="text-sm text-slate-200">Processing assignment...</span>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= APP_URL ?>/workspace/<?= $repository['id'] ?>" class="btn btn-primary px-8">Open Workspace</a>
                        </div>
                    <?php elseif ($pendingRequest): ?>
                        <div class="p-8 text-center bg-amber-500/5 rounded-2xl border border-amber-500/10">
                            <i class="fa-solid fa-hourglass-half text-4xl text-amber-500 mb-4 animate-pulse"></i>
                            <h4 class="text-lg font-bold text-amber-200">Request Pending Review</h4>
                            <p class="text-sm text-slate-400 mt-2">Your proposal "<span class="italic text-slate-300"><?= htmlspecialchars($pendingRequest['title']) ?></span>" has been submitted. The HOD will review it and assign a supervisor.</p>
                        </div>
                    <?php else: ?>
                        <div class="p-8 text-center bg-slate-900/40 rounded-2xl border border-slate-800">
                            <i class="fa-solid fa-circle-exclamation text-4xl text-slate-700 mb-4"></i>
                            <h4 class="text-lg font-bold text-slate-300">No Repository Established</h4>
                            <p class="text-sm text-slate-500 mt-2">Once your team is ready, submit a project proposal to request a repository.</p>
                            <a href="<?= APP_URL ?>/student/request-repo" class="btn btn-outline btn-sm mt-6">Submit Proposal</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: Stats & Information -->
        <div class="space-y-6">
            <div class="card border-ocean-500/10 bg-ocean-500/5">
                <div class="card-body">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-ocean-400 mb-4">Project Guidelines</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-check text-ocean-500 mt-1"></i>
                            <p class="text-xs text-slate-400">Maximum of <strong>4 members</strong> per group.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-check text-ocean-500 mt-1"></i>
                            <p class="text-xs text-slate-400">Only the <strong>leader</strong> can request a repository or add members.</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card bg-slate-900 border-slate-800">
                <div class="card-body">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4">System Alerts</h3>
                    <div class="flex items-center gap-3 p-3 bg-black/20 rounded-lg">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                        <span class="text-xs text-slate-400">Submission deadline is approaching!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Add Member Modal -->
<div id="add-member-modal" class="modal-overlay">
    <div class="modal max-w-md animate__animated animate__slideInDown">
        <div class="modal-header">
            <h3>Add Group Member</h3>
            <button class="btn btn-ghost" onclick="closeModal('add-member-modal')">&times;</button>
        </div>
        <div class="modal-body p-6">
            <form method="POST" action="<?= APP_URL ?>/student/add-member">
                <?= \App\Core\Session::csrfField() ?>
                <div class="form-group mb-6">
                    <label class="form-label font-bold">Search by Index Number</label>
                    <div class="input-group">
                        <i class="fa-solid fa-id-card-clip input-icon"></i>
                        <input type="text" name="index_number" class="form-control" required placeholder="Ex: 20231234">
                    </div>
                    <p class="text-[10px] text-slate-500 mt-2">Only students currently without a group can be added.</p>
                </div>
                <button type="submit" class="btn btn-primary w-full py-4 shadow-lg shadow-ocean-500/20">Add to Group</button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}
</script>
