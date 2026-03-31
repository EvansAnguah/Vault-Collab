<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-building-columns text-ocean-500"></i> Manage Departments</h1>
        <p>Configure university faculties, specialized departments, and academic programs.</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary btn-sm" onclick="openModal('dept-modal')"><i class="fa-solid fa-plus-circle"></i> New Department</button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10 animate__animated animate__fadeInUp">
    <div class="lg:col-span-2">
        <div class="card bg-slate-900/40 border-slate-800">
            <div class="table-responsive">
                <table class="table-hover">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Code</th>
                            <th>Stats</th>
                            <th>HOD</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($departments)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-10 text-slate-500">No departments configured yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($departments as $d): ?>
                                <tr>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-100"><?= htmlspecialchars($d['name']) ?></span>
                                            <span class="text-xs text-slate-500"><?= htmlspecialchars($d['description'] ?? 'No description') ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline text-[10px] font-mono"><?= htmlspecialchars($d['code']) ?></span>
                                    </td>
                                    <td>
                                        <div class="flex gap-4">
                                            <div class="flex flex-col" title="Programs">
                                                <span class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">PROG</span>
                                                <span class="text-xs font-bold text-ocean-400"><?= count($d['programs'] ?? []) ?></span>
                                            </div>
                                            <div class="flex flex-col" title="Students">
                                                <span class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">STUD</span>
                                                <span class="text-xs font-bold text-ocean-400"><?= $d['student_count'] ?? 0 ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-xs text-slate-400"><?= $d['hod_id'] ? 'Assigned' : 'Vacant' ?></span>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button class="btn btn-ghost btn-sm text-ocean-400" onclick="openProgramModal(<?= $d['id'] ?>, '<?= htmlspecialchars($d['name']) ?>')" title="Add Program">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <button class="btn btn-ghost btn-sm text-slate-400">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Sidebar info or quick add program -->
    <div class="space-y-6">
        <div class="card border-ocean-500/10 bg-ocean-500/5">
            <div class="card-body">
                <h3 class="text-sm font-bold uppercase tracking-widest text-ocean-400 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-graduation-cap"></i> Quick Program Add
                </h3>
                <form method="POST" action="<?= APP_URL ?>/admin/programs">
                    <?= \App\Core\Session::csrfField() ?>
                    <div class="form-group mb-3">
                        <label class="form-label text-xs">Program Name</label>
                        <input type="text" name="name" class="form-control text-sm" placeholder="Ex: BSc. Computer Science" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label text-xs">Department</label>
                        <select name="department_id" class="form-control text-sm" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label text-xs">Duration (Years)</label>
                        <input type="number" name="duration" class="form-control text-sm" value="4" min="1" max="7">
                    </div>
                    <button type="submit" class="btn btn-primary w-full btn-sm">Add Program</button>
                </form>
            </div>
        </div>

        <div class="card bg-slate-900 border-slate-800">
            <div class="card-body">
                <h4 class="text-xs font-bold uppercase text-slate-500 tracking-widest mb-4">Total Programs Across All Departments</h4>
                <div class="space-y-3">
                    <?php 
                        $totalProgs = 0;
                        foreach ($departments as $d) {
                            $progs = $d['programs'] ?? [];
                            $totalProgs += count($progs);
                            if (count($progs) > 0):
                                echo '<div class="flex justify-between items-center bg-black/20 p-2 rounded border border-slate-800/50">';
                                echo '<span class="text-xs text-slate-400">' . htmlspecialchars($d['name']) . '</span>';
                                echo '<span class="text-xs font-bold text-ocean-400">' . count($progs) . '</span>';
                                echo '</div>';
                            endif;
                        }
                    ?>
                    <div class="pt-4 border-t border-slate-800 flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-200">TOTAL</span>
                        <span class="badge badge-primary"><?= $totalProgs ?> Programs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div id="dept-modal" class="modal-overlay">
    <div class="modal animate__animated animate__slideInDown">
        <div class="modal-header">
            <h3>Add New Department</h3>
            <button class="btn btn-ghost" onclick="closeModal('dept-modal')">&times;</button>
        </div>
        <div class="modal-body p-6">
            <form method="POST" action="<?= APP_URL ?>/admin/departments">
                <?= \App\Core\Session::csrfField() ?>
                <div class="form-group mb-4">
                    <label class="form-label">Department Full Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="Ex: Computer Science & Engineering">
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Short Code</label>
                    <input type="text" name="code" class="form-control" required placeholder="Ex: CS">
                </div>
                <div class="form-group mb-6">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-full">Create Department</button>
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
function openProgramModal(deptId, deptName) {
    // We can reuse the quick add sidebar or make a modal
    // For now let's just prefill the sidebar select
    const select = document.querySelector('select[name="department_id"]');
    select.value = deptId;
    select.scrollIntoView({ behavior: 'smooth' });
}
</script>
