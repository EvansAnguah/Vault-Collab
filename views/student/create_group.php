<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-plus-circle text-ocean-500"></i> Form a Project Group</h1>
        <p>Start a new research team to begin your final-year project journey.</p>
    </div>
    <div class="header-actions">
        <a href="<?= APP_URL ?>/student/group" class="btn btn-ghost btn-sm"><i class="fa-solid fa-arrow-left"></i> Back to My Group</a>
    </div>
</div>

<div class="card max-w-2xl mx-auto animate__animated animate__fadeInUp">
    <div class="card-body">
        <form method="POST" action="<?= APP_URL ?>/student/create-group">
            <?= \App\Core\Session::csrfField() ?>
            
            <div class="form-group mb-6">
                <label class="form-label font-bold text-slate-100">Project Group Name <span class="text-rose-500">*</span></label>
                <div class="input-group">
                    <i class="fa-solid fa-tag input-icon"></i>
                    <input type="text" name="name" class="form-control" required placeholder="Ex: Smart Campus IoT Team">
                </div>
                <p class="text-[10px] text-slate-500 mt-2">You can change this name later in your group settings.</p>
            </div>

            <div class="bg-ocean-500/5 p-4 rounded-xl border border-ocean-500/10 mb-8">
                <div class="flex items-start gap-4">
                    <i class="fa-solid fa-crown text-amber-400 mt-1"></i>
                    <div>
                        <h4 class="text-sm font-bold text-slate-100">Group Leadership</h4>
                        <p class="text-xs text-slate-400 mt-1">By creating this group, you will be designated as the **Group Leader**. Only the leader can submit repository requests and add members.</p>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full py-4 text-base shadow-lg shadow-ocean-500/20">
                <i class="fa-solid fa-check-circle mr-2"></i> Confirm and Create Group
            </button>
        </form>
    </div>
</div>
