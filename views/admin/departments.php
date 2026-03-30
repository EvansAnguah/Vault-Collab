<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-building-columns mr-3 text-blue-600"></i> Departmental Structure</h1>
    <div class="flex gap-2">
        <button class="btn btn-blue btn-sm" onclick="openModal('dept-modal')">
            <i class="fa-solid fa-plus-circle mr-2"></i> New Department
        </button>
    </div>
</div>

<div class="grid grid-cols-3 gap-8 animate-fade">
    <!-- Left: Departments Table -->
    <div class="col-span-2">
        <div class="card">
            <div class="card-header bg-gray-50/50">
                <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">University Units</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Unit Name</th>
                            <th>Code</th>
                            <th>Demographics</th>
                            <th>Status</th>
                            <th class="text-right">Administration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($departments)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-20">
                                    <i class="fa-solid fa-sitemap text-5xl text-gray-100 mb-4 block"></i>
                                    <p class="text-xs text-gray-400">No departmental structures defined yet.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($departments as $d): ?>
                                <tr>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900 leading-tight"><?= htmlspecialchars($d['name']) ?></span>
                                            <span class="text-[11px] text-gray-400 line-clamp-1"><?= htmlspecialchars($d['description'] ?? 'Primary administrative unit') ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info uppercase text-[10px] font-bold border-transparent"><?= htmlspecialchars($d['code']) ?></span>
                                    </td>
                                    <td>
                                        <div class="flex gap-4">
                                            <div class="flex flex-col">
                                                <span class="text-[9px] text-gray-400 uppercase font-bold tracking-tighter">Programs</span>
                                                <span class="text-xs font-bold text-blue-600"><?= count($d['programs'] ?? []) ?></span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[9px] text-gray-400 uppercase font-bold tracking-tighter">Students</span>
                                                <span class="text-xs font-bold text-blue-600"><?= $d['student_count'] ?? 0 ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-[10px] font-bold uppercase tracking-widest <?= $d['hod_id'] ? 'text-green-600' : 'text-amber-500' ?>">
                                            <?= $d['hod_id'] ? 'Head Assigned' : 'Vacant Seat' ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-ghost" onclick="openProgramModal(<?= $d['id'] ?>, '<?= htmlspecialchars($d['name']) ?>')">
                                            <i class="fa-solid fa-plus-square text-blue-300"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Quick Add Program -->
    <div class="space-y-6">
        <div class="card p-6 border-blue-100 bg-blue-50/10">
            <h4 class="text-[10px] font-bold uppercase text-blue-600 tracking-widest mb-6 border-b border-blue-100 pb-2">Academic Program Setup</h4>
            <form method="POST" action="<?= APP_URL ?>/admin/programs">
                <?= \App\Core\Session::csrfField() ?>
                <div class="form-group">
                    <label class="form-label font-bold text-xs">Degree Name</label>
                    <input type="text" name="name" class="form-control" placeholder="BSc. Computer Engineering" required>
                </div>
                <div class="form-group">
                    <label class="form-label font-bold text-xs">Mapping Unit</label>
                    <select name="department_id" class="form-control" required>
                        <option value="">Choose Unit...</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-6">
                    <label class="form-label font-bold text-xs">Standard Duration (Years)</label>
                    <input type="number" name="duration" class="form-control" value="4" min="1" max="7">
                </div>
                <button type="submit" class="btn btn-blue w-full p-2.5 font-bold uppercase tracking-widest text-[10px]">Deploy Program</button>
            </form>
        </div>

        <div class="card p-6">
            <h4 class="text-[10px] font-bold uppercase text-gray-400 tracking-widest mb-4">Metric Aggregation</h4>
            <div class="space-y-3">
                <?php 
                    $totalProgs = 0;
                    foreach ($departments as $d) {
                        $progs = $d['programs'] ?? [];
                        $totalProgs += count($progs);
                        if (count($progs) > 0):
                            echo '<div class="flex justify-between items-center p-2 rounded hover:bg-gray-50 transition-colors">';
                            echo '<span class="text-[11px] text-gray-600">' . htmlspecialchars($d['name']) . '</span>';
                            echo '<span class="text-xs font-bold text-blue-600">' . count($progs) . '</span>';
                            echo '</div>';
                        endif;
                    }
                ?>
                <div class="pt-4 border-t border-gray-100 flex justify-between items-center text-xs font-bold text-gray-900">
                    <span>GLOBAL AGGREGATE</span>
                    <span class="badge badge-info uppercase tracking-widest border-transparent"><?= $totalProgs ?> Items</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div id="dept-modal" class="modal-overlay">
    <div class="modal animate-fade max-w-lg">
        <div class="modal-header">
            <h3 class="text-sm font-bold uppercase tracking-widest">New Administrative Unit</h3>
            <button class="btn btn-ghost" onclick="closeModal('dept-modal')">&times;</button>
        </div>
        <form method="POST" action="<?= APP_URL ?>/admin/departments">
            <?= \App\Core\Session::csrfField() ?>
            <div class="modal-body p-8 space-y-6">
                <div class="form-group">
                    <label class="form-label font-bold text-xs">Department Full Nomenclature</label>
                    <input type="text" name="name" class="form-control" required placeholder="Faculty of Engineering">
                </div>
                <div class="form-group">
                    <label class="form-label font-bold text-xs">Index Code</label>
                    <input type="text" name="code" class="form-control" required placeholder="FOE">
                </div>
                <div class="form-group">
                    <label class="form-label font-bold text-xs">Mission Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-blue w-full p-4 font-bold uppercase tracking-widest text-[11px]">Authorize Unit Creation</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
function openProgramModal(deptId, deptName) {
    const select = document.querySelector('select[name="department_id"]');
    select.value = deptId;
    select.scrollIntoView({ behavior: 'smooth' });
}
</script>
