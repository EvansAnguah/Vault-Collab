<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-users-gear mr-3 text-blue-600"></i> Global User Hub</h1>
    <div class="flex gap-2">
        <a href="<?= APP_URL ?>/admin/create-hod" class="btn btn-blue btn-sm">
            <i class="fa-solid fa-user-shield mr-2"></i> New HOD
        </a>
        <a href="<?= APP_URL ?>/admin/create-supervisor" class="btn btn-sm">
            <i class="fa-solid fa-user-tie mr-2 text-blue-600"></i> New Supervisor
        </a>
    </div>
</div>

<!-- Search & Filters -->
<div class="card mb-6 animate-fade">
    <div class="card-body bg-gray-50/30">
        <form method="GET" action="<?= APP_URL ?>/admin/users" class="grid grid-cols-4 gap-4 items-end">
            <div class="form-group col-span-1">
                <label class="text-[10px] uppercase font-bold text-gray-400 mb-2 block">Quick Search</label>
                <div class="relative">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs"></i>
                    <input type="text" name="search" class="form-control pl-10" placeholder="Name or Index..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="text-[10px] uppercase font-bold text-gray-400 mb-2 block">Account Role</label>
                <select name="role" class="form-control border-gray-200">
                    <option value="">All Categories</option>
                    <option value="admin" <?= ($filters['role'] ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="hod" <?= ($filters['role'] ?? '') == 'hod' ? 'selected' : '' ?>>HOD</option>
                    <option value="supervisor" <?= ($filters['role'] ?? '') == 'supervisor' ? 'selected' : '' ?>>Supervisor</option>
                    <option value="student" <?= ($filters['role'] ?? '') == 'student' ? 'selected' : '' ?>>Student</option>
                </select>
            </div>

            <div class="form-group">
                <label class="text-[10px] uppercase font-bold text-gray-400 mb-2 block">Unit / Department</label>
                <select name="department_id" class="form-control border-gray-200">
                    <option value="">Global Filter</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>" <?= ($filters['department_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="pb-1 flex gap-2">
                <button type="submit" class="btn btn-blue flex-1 py-2 font-bold uppercase text-[10px]">Execute Filter</button>
                <?php if (!empty($filters['role']) || !empty($filters['department_id']) || !empty($filters['search'])): ?>
                    <a href="<?= APP_URL ?>/admin/users" class="btn btn-sm px-4"><i class="fa-solid fa-rotate-left"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card animate-fade">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>University Member</th>
                    <th>Account Role</th>
                    <th>Structural Unit</th>
                    <th>Access Status</th>
                    <th>Registration</th>
                    <th class="text-right">Administration</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-20">
                            <i class="fa-solid fa-users-viewfinder text-5xl text-gray-100 mb-4 block"></i>
                            <p class="text-xs text-gray-400">No members match your current filter criteria.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="user-avatar w-10 h-10 border border-gray-100 uppercase text-[11px] font-bold text-gray-500 bg-gray-50">
                                        <?= strtoupper(substr($u['first_name'], 0, 1)) ?>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900 leading-tight"><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></span>
                                        <span class="text-[10px] text-blue-600 font-mono"><?= htmlspecialchars($u['email']) ?></span>
                                        <?php if ($u['index_number']): ?>
                                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">ID: <?= htmlspecialchars($u['index_number']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    $badgeClass = match($u['role']) {
                                        'admin' => 'badge-danger',
                                        'hod' => 'badge-success',
                                        'supervisor' => 'badge-info',
                                        'student' => 'badge-warning',
                                        default => ''
                                    };
                                ?>
                                <span class="badge <?= $badgeClass ?> uppercase text-[9px] font-bold tracking-widest border-transparent"><?= $u['role'] ?></span>
                            </td>
                            <td>
                                <span class="text-[11px] font-bold text-gray-600 uppercase tracking-tighter">
                                    <i class="fa-solid fa-building-columns text-gray-200 mr-2"></i>
                                    <?= htmlspecialchars($u['department_name'] ?? 'Core Administration') ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($u['is_active']): ?>
                                    <span class="inline-flex items-center gap-2 px-2 py-1 bg-green-50 text-green-700 text-[10px] font-bold uppercase rounded border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Authorized
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-2 px-2 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold uppercase rounded border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Restricted
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="text-xs text-gray-400 italic font-mono"><?= date('M d, Y', strtotime($u['created_at'])) ?></span>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="<?= APP_URL ?>/admin/users/edit/<?= $u['id'] ?>" class="btn btn-sm btn-ghost text-gray-400 hover:text-blue-600">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </a>
                                    <form method="POST" action="<?= APP_URL ?>/admin/toggle-user-status" class="inline">
                                        <?= \App\Core\Session::csrfField() ?>
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <input type="hidden" name="status" value="<?= $u['is_active'] ? '0' : '1' ?>">
                                        <button type="submit" class="btn btn-sm btn-ghost <?= $u['is_active'] ? 'text-red-400 hover:text-red-700' : 'text-green-400 hover:text-green-700' ?>">
                                            <i class="fa-solid <?= $u['is_active'] ? 'fa-user-lock' : 'fa-user-check' ?>"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
