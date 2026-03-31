<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="<?= APP_URL ?>/supervisor/groups" class="text-slate-500 hover:text-ocean-400 transition-colors"><i class="fa-solid fa-arrow-left"></i> My Projects</a>
            <span class="text-slate-700">/</span>
            <span class="text-ocean-400 font-bold"><?= htmlspecialchars($repo['group_name']) ?></span>
        </div>
        <h1><?= htmlspecialchars($repo['title']) ?></h1>
    </div>
    <div class="header-actions">
        <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-laptop-code"></i> Inspect Workspace</a>
        <a href="<?= APP_URL ?>/chat/<?= $repo['group_id'] ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-message"></i> Group Chat</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp">
    
    <!-- Status & Submissions -->
    <div class="lg:col-span-2 space-y-8">
        <div class="card bg-slate-800/20 border-slate-700/50">
            <div class="card-body">
                <h3 class="text-lg font-bold text-slate-100 flex items-center gap-2 mb-6">
                    <i class="fa-solid fa-file-export text-ocean-400"></i> Active Submissions
                </h3>

                <?php if ($submission && $submission['status'] == 'pending'): ?>
                    <div class="p-8 bg-black/40 rounded-2xl border border-ocean-500/20">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="badge badge-primary text-[10px] mb-2">NEW SUBMISSION</span>
                                <h4 class="text-lg font-bold text-slate-100">Milestone Review Request</h4>
                                <p class="text-xs text-slate-500 mt-1">Submitted on <?= date('M d, Y at H:i', strtotime($submission['created_at'])) ?></p>
                            </div>
                            <i class="fa-solid fa-file-circle-check text-4xl text-ocean-500/50"></i>
                        </div>
                        
                        <div class="mt-8 flex gap-4">
                            <button class="btn btn-primary px-8" onclick="openReviewModal()">Review & Decision</button>
                            <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>/chapters" class="btn btn-outline border-slate-700">View Chapters</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="p-12 text-center bg-slate-900/40 rounded-2xl border border-slate-800 border-dashed">
                        <i class="fa-solid fa-clock-rotate-left text-4xl text-slate-800 mb-4"></i>
                        <h4 class="text-lg font-bold text-slate-400">No Pending Submissions</h4>
                        <p class="text-xs text-slate-600 mt-2">The group has not submitted a milestone for review yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Collaborative Activity -->
        <div class="card bg-black/20 border-slate-800">
            <div class="card-body">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-emerald-400"></i> Project Activity
                    </h3>
                    <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>/logbook" class="text-xs text-ocean-400 font-bold hover:underline">View Logbook</a>
                </div>
                
                <div class="space-y-4">
                    <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-800/60 flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                            <i class="fa-solid fa-file-pen text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-300 font-medium">Chapter 1.pdf updated by Group Leader</p>
                            <span class="text-[10px] text-slate-500 font-mono">2 hours ago</span>
                        </div>
                    </div>
                    <!-- Sample activity -->
                    <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-800/60 flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                            <i class="fa-solid fa-folder-plus text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-300 font-medium">New directory 'Diagrams' created</p>
                            <span class="text-[10px] text-slate-500 font-mono">Yesterday</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Sidebar -->
    <div class="space-y-6">
        <!-- Post Notice -->
        <div class="card border-ocean-500/10 bg-ocean-500/5">
            <div class="card-body">
                <h3 class="text-xs font-bold uppercase tracking-widest text-ocean-400 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn"></i> Post Group Notice
                </h3>
                <form method="POST" action="<?= APP_URL ?>/supervisor/notice">
                    <?= \App\Core\Session::csrfField() ?>
                    <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
                    <div class="form-group mb-3">
                        <label class="form-label text-[10px] uppercase font-bold text-slate-500 mb-1">Notice Title</label>
                        <input type="text" name="title" class="form-control text-sm" placeholder="Ex: Update on Chapter 2" required>
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label text-[10px] uppercase font-bold text-slate-500 mb-1">Content</label>
                        <textarea name="content" class="form-control text-sm" rows="3" placeholder="Write your message..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-full">Broadcast to Group</button>
                    <p class="text-[9px] text-slate-500 mt-2 text-center italic">Notices automatically expire after 48 hours.</p>
                </form>
            </div>
        </div>

        <!-- Meeting Scheduling -->
        <div class="card bg-slate-900 border-slate-800">
            <div class="card-body">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-video"></i> Schedule Meeting
                </h3>
                <a href="<?= APP_URL ?>/meetings/<?= $repo['id'] ?>" class="btn btn-outline border-slate-700 w-full text-xs font-bold">
                    <i class="fa-solid fa-calendar-plus mr-2"></i> Set Up Discussion
                </a>
            </div>
        </div>

        <!-- Final Recommendation -->
        <div class="card border-emerald-500/10 bg-emerald-500/5">
            <div class="card-body">
                <h3 class="text-xs font-bold uppercase tracking-widest text-emerald-400 mb-2">Finalization</h3>
                <p class="text-[10px] text-slate-500 mb-4 font-medium leading-relaxed">Only use this when the project is 100% complete and ready for archival by the HOD.</p>
                <form method="POST" action="<?= APP_URL ?>/supervisor/submit-to-hod" onsubmit="return confirm('Recommend this project for final HOD review / archival?')">
                    <?= \App\Core\Session::csrfField() ?>
                    <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
                    <button type="submit" class="btn btn-success btn-sm w-full">Recommend to HOD</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Review Decision Modal -->
<div id="review-modal" class="modal-overlay">
    <div class="modal animate__animated animate__slideInDown max-w-lg">
        <div class="modal-header">
            <h3>Milestone Decision</h3>
            <button class="btn btn-ghost" onclick="closeModal('review-modal')">&times;</button>
        </div>
        <div class="modal-body p-6">
            <form method="POST" action="<?= APP_URL ?>/supervisor/review">
                <?= \App\Core\Session::csrfField() ?>
                <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
                
                <div class="form-group mb-6">
                    <label class="form-label font-bold text-slate-100 italic">Reviewer Feedback</label>
                    <textarea name="comments" class="form-control" rows="4" placeholder="Mention what needs to be fixed or what was done well..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="submit" name="action" value="declined" class="btn btn-outline border-rose-500/30 text-rose-500 hover:bg-rose-500/10">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Request Revisions
                    </button>
                    <button type="submit" name="action" value="accepted" class="btn btn-primary">
                        <i class="fa-solid fa-circle-check mr-2"></i> Accept Milestone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openReviewModal() {
    document.getElementById('review-modal').classList.add('active');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}
</script>
