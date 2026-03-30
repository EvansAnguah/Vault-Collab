<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid <?= $role === 'hod' ? 'fa-user-plus' : 'fa-user-tie' ?> text-ocean-500"></i> <?= $pageTitle ?></h1>
        <p>Creating a new academic <?= strtoupper($role) ?> account for the university portal.</p>
    </div>
    <div class="header-actions">
        <a href="<?= APP_URL ?>/admin/users?role=<?= $role ?>" class="btn btn-ghost btn-sm"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
    </div>
</div>

<div class="card max-w-2xl mx-auto animate__animated animate__fadeInUp">
    <div class="card-body">
        <form method="POST" action="<?= APP_URL ?>/admin/create-<?= $role ?>">
            <?= \App\Core\Session::csrfField() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label class="form-label font-bold">First Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="first_name" class="form-control" required placeholder="Ex: John">
                </div>
                
                <div class="form-group">
                    <label class="form-label font-bold">Last Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="last_name" class="form-control" required placeholder="Ex: Doe">
                </div>
            </div>

            <div class="form-group mt-4">
                <label class="form-label font-bold">Email Address <span class="text-rose-500">*</span></label>
                <input type="email" name="email" class="form-control" required placeholder="johndoe@rmu.edu.gh">
            </div>

            <div class="form-group mt-4">
                <label class="form-label font-bold">Department <span class="text-rose-500">*</span></label>
                <select name="department_id" class="form-control" required>
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="bg-slate-800/50 p-4 rounded-lg mt-8 border border-slate-700/50">
                <div class="flex items-start gap-4">
                    <i class="fa-solid fa-shield-halved text-ocean-400 mt-1"></i>
                    <div>
                        <h4 class="text-sm font-bold text-slate-100">Security Credentials</h4>
                        <p class="text-xs text-slate-400 mt-1">A default system password <span class="font-mono text-ocean-400">Password123!</span> will be set. The user will be prompted to change it upon their first login.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-700">
                <button type="submit" class="btn btn-primary w-full py-4 text-base shadow-lg shadow-ocean-500/20">
                    <i class="fa-solid fa-user-check"></i> Create Account
                </button>
            </div>
        </form>
    </div>
</div>
