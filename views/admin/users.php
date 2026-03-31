<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-users-gear text-ocean-500"></i> Manage Users</h1>
        <p>Monitor and configure platform access for all university roles.</p>
    </div>
    <div class="header-actions">
        <a href="<?= APP_URL ?>/admin/create-hod" class="btn btn-primary btn-sm"><i class="fa-solid fa-user-plus"></i> New HOD</a>
        <a href="<?= APP_URL ?>/admin/create-supervisor" class="btn btn-secondary btn-sm"><i class="fa-solid fa-user-tie"></i> New Supervisor</a>
        <a href="<?= APP_URL ?>/admin/upload-students" class="btn btn-outline btn-sm"><i class="fa-solid fa-file-csv"></i> Bulk Upload Students</a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6 animate__animated animate__fadeIn">
    <div class="card-body">
        <form method="GET" action="<?= APP_URL ?>/admin/users" class="flex flex-wrap items-end gap-4">
            <div class="form-group flex-1 min-w-[200px] mb-0">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <i class="fa-solid fa-search input-icon"></i>
                    <input type="text" name="search" class="form-control" placeholder="Name, Email, or Index..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                </div>
            </div>
            
            <div class="form-group min-w-[150px] mb-0">
                <label class="form-label">Role</label>
                <select name="role" class="form-control">
                    <option value="">All Roles</option>
                    <option value="admin" <?= ($filters['role'] ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="hod" <?= ($filters['role'] ?? '') == 'hod' ? 'selected' : '' ?>>HOD</option>
                    <option value="supervisor" <?= ($filters['role'] ?? '') == 'supervisor' ? 'selected' : '' ?>>Supervisor</option>
                    <option value="student" <?= ($filters['role'] ?? '') == 'student' ? 'selected' : '' ?>>Student</option>
                </select>
            </div>

            <div class="form-group min-w-[200px] mb-0">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-control">
                    <option value="">All Departments</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>" <?= ($filters['department_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i> Apply</button>
            <?php if (!empty($filters['role']) || !empty($filters['department_id']) || !empty($filters['search'])): ?>
                <a href="<?= APP_URL ?>/admin/users" class="btn btn-ghost"><i class="fa-solid fa-rotate-left"></i> Reset</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card animate__animated animate__fadeInUp">
    <div class="table-responsive">
        <table class="table-hover">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-10">
                            <div class="text-slate-400">
                                <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
                                <p>No users found matching your criteria.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-sm bg-slate-800 border border-slate-700">
                                        <?php if ($u['profile_photo']): ?>
                                            <img src="<?= APP_URL ?>/<?= $u['profile_photo'] ?>" alt="Profile">
                                        <?php else: ?>
                                            <span class="text-xs font-bold text-ocean-400"><?= strtoupper(substr($u['first_name'], 0, 1)) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-100"><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></span>
                                        <span class="text-xs text-slate-400"><?= htmlspecialchars($u['email']) ?></span>
                                        <?php if ($u['index_number']): ?>
                                            <span class="text-[10px] text-ocean-400 font-mono tracking-tight"><?= htmlspecialchars($u['index_number']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    $badgeClass = match($u['role']) {
                                        'admin' => 'badge-danger',
                                        'hod' => 'badge-primary',
                                        'supervisor' => 'badge-success',
                                        'student' => 'badge-info',
                                        default => ''
                                    };
                                ?>
                                <span class="badge <?= $badgeClass ?> uppercase text-[10px]"><?= $u['role'] ?></span>
                            </td>
                            <td>
                                <span class="text-sm text-slate-300"><?= htmlspecialchars($u['department_name'] ?? 'System') ?></span>
                            </td>
                            <td>
                                <?php if ($u['is_active']): ?>
                                    <span class="flex items-center gap-1.5 text-xs text-green-400 font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                    </span>
                                <?php else: ?>
                                    <span class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span> Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="text-xs text-slate-400"><?= date('M d, Y', strtotime($u['created_at'])) ?></span>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="btn btn-ghost btn-sm text-slate-400 hover:text-ocean-400" title="Edit User">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form method="POST" action="<?= APP_URL ?>/admin/toggle-user-status" class="inline">
                                        <?= \App\Core\Session::csrfField() ?>
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <input type="hidden" name="status" value="<?= $u['is_active'] ? '0' : '1' ?>">
                                        <button type="submit" class="btn btn-ghost btn-sm <?= $u['is_active'] ? 'text-rose-500 hover:bg-rose-500/10' : 'text-emerald-500 hover:bg-emerald-500/10' ?>" 
                                                title="<?= $u['is_active'] ? 'Deactivate' : 'Activate' ?> User">
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

<style>
/* Dashboard-specific tweaks */
.table-hover tbody tr:hover {
    background-color: rgba(15, 23, 42, 0.4);
}
</style>
