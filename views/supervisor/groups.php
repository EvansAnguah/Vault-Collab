<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-chalkboard-user mr-3 text-blue-600"></i> My Assigned Projects</h1>
    <span class="badge badge-info uppercase text-[10px] font-bold"><?= count($groups) ?> Active Research Teams</span>
</div>

<?php if (empty($groups)): ?>
    <div class="card animate-fade py-24 text-center max-w-2xl mx-auto">
        <div class="card-body">
            <i class="fa-solid fa-folder-open text-6xl text-gray-100 mb-6 block"></i>
            <h2 class="text-xl font-bold text-gray-900 uppercase tracking-widest">No Assignments Allocated</h2>
            <p class="text-xs text-gray-400 mt-2 max-w-xs mx-auto leading-relaxed">
                You haven't been designated as a supervisor to any research groups for this academic session by your HOD.
            </p>
        </div>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-fade">
        <?php foreach ($groups as $g): ?>
            <div class="card card-hover flex flex-col">
                <div class="card-body p-8 flex-1">
                    <div class="flex justify-between items-start mb-6">
                        <span class="badge badge-success uppercase text-[9px] font-bold tracking-widest"><?= htmlspecialchars($g['status']) ?></span>
                        <div class="text-[9px] text-gray-300 font-mono font-bold uppercase">ID: #<?= $g['repo_id'] ?></div>
                    </div>
                    
                    <h3 class="text-sm font-bold text-gray-900 leading-snug mb-3 min-h-[40px]"><?= htmlspecialchars($g['title']) ?></h3>
                    
                    <div class="flex items-center gap-3 mb-8">
                        <div class="user-avatar text-[10px] w-8 h-8 font-bold text-blue-600 bg-blue-50 border-blue-100 uppercase">
                            <?= strtoupper(substr($g['group_name'], 0, 1)) ?>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold text-gray-700"><?= htmlspecialchars($g['group_name']) ?></span>
                            <span class="text-[9px] text-gray-400 uppercase tracking-tighter">Assigned Research Team</span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-6 border-t border-gray-50 mb-8">
                        <div class="flex justify-between items-center text-[10px]">
                            <span class="text-gray-400 font-bold uppercase tracking-widest">Commenced</span>
                            <span class="text-gray-700 font-mono"><?= date('M d, Y', strtotime($g['created_at'])) ?></span>
                        </div>
                        <div class="flex justify-between items-center text-[10px]">
                            <span class="text-gray-400 font-bold uppercase tracking-widest">Health Status</span>
                            <span class="text-green-600 font-bold uppercase tracking-tighter">Active Sync</span>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="<?= APP_URL ?>/supervisor/review/<?= $g['repo_id'] ?>" class="btn btn-blue w-full p-3 font-bold uppercase tracking-widest text-[11px]">
                            <i class="fa-solid fa-microscope mr-2"></i> Review Research Progress
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
