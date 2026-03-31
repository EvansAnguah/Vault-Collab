<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-chalkboard-user text-ocean-500"></i> My Assigned Projects</h1>
        <p>Monitor the progress of research teams currently under your academic supervision.</p>
    </div>
</div>

<?php if (empty($groups)): ?>
    <div class="card animate__animated animate__fadeInUp py-16 text-center max-w-2xl mx-auto">
        <div class="card-body">
            <i class="fa-solid fa-folder-open text-6xl text-slate-700 mb-6"></i>
            <h2 class="text-2xl font-bold text-slate-100">No Assignments Found</h2>
            <p class="text-slate-500 mt-2">You haven't been assigned as a supervisor to any project groups yet by your HOD.</p>
        </div>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp">
        <?php foreach ($groups as $g): ?>
            <div class="card card-hover border-slate-700/40 bg-slate-800/10 hover:bg-slate-800/30 group">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-4">
                        <span class="badge badge-primary text-[9px] uppercase tracking-widest"><?= $g['status'] ?></span>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">ID: #<?= $g['id'] ?></div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-100 group-hover:text-ocean-400 transition-colors mb-2"><?= htmlspecialchars($g['title']) ?></h3>
                    <p class="text-xs text-slate-400 font-medium mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-users text-ocean-500"></i> <?= htmlspecialchars($g['group_name']) ?>
                    </p>

                    <div class="space-y-4 pt-4 border-t border-slate-800">
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-500">Created On</span>
                            <span class="text-slate-300 font-mono"><?= date('M d, Y', strtotime($g['created_at'])) ?></span>
                        </div>
                        <div class="flex justify-between text-[11px]">
                            <span class="text-slate-500">Latest Activity</span>
                            <span class="text-slate-300 font-mono">Today</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="<?= APP_URL ?>/supervisor/review/<?= $g['id'] ?>" class="btn btn-primary w-full py-3 shadow-lg shadow-ocean-500/10">
                            <i class="fa-solid fa-eye mr-2"></i> Review Progress
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
