<div class="page-header animate-fade">
    <div class="flex flex-col">
        <div class="flex items-center gap-3 mb-2 text-[10px] font-bold uppercase tracking-widest">
            <a href="<?= APP_URL ?>/supervisor/groups" class="text-gray-400 hover:text-blue-600 transition-colors">Supervisor Hub</a>
            <span class="text-gray-200">/</span>
            <span class="text-blue-600"><?= htmlspecialchars($repo['group_name']) ?></span>
        </div>
        <h1 class="page-title leading-tight"><?= htmlspecialchars($repo['title']) ?></h1>
    </div>
    <div class="flex gap-2">
        <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>" class="btn btn-sm bg-green-50 text-green-700 border-green-100 hover:bg-green-100">
            <i class="fa-solid fa-laptop-code mr-2"></i> Inspect Workspace
        </a>
        <a href="<?= APP_URL ?>/chat/<?= $repo['group_id'] ?>" class="btn btn-blue btn-sm">
            <i class="fa-solid fa-comments mr-2"></i> Open Channel
        </a>
    </div>
</div>

<div class="grid grid-cols-3 gap-8 animate-fade">
    
    <!-- Main Content: Milestone Review & Activity -->
    <div class="col-span-2 space-y-8">
        <div class="card">
            <div class="card-header bg-gray-50/50">
                <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">Academic Assessment Hub</h3>
            </div>
            <div class="card-body p-8">
                <?php if ($submission && $submission['status'] == 'pending'): ?>
                    <div class="p-8 bg-blue-50/30 border border-blue-100 rounded-lg flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-6 shadow-lg shadow-blue-100">
                            <i class="fa-solid fa-file-export text-2xl"></i>
                        </div>
                        <span class="badge badge-info uppercase text-[9px] mb-2 font-bold tracking-widest border-transparent">New Milestone Submission</span>
                        <h4 class="text-lg font-bold text-gray-900 leading-tight">Critical Review Required</h4>
                        <p class="text-xs text-gray-400 mt-2 font-mono uppercase">Submitted: <?= date('M d, Y at H:i', strtotime($submission['created_at'])) ?></p>
                        
                        <div class="mt-8 flex gap-3 w-full max-w-sm">
                            <button class="btn btn-blue flex-1 py-3 font-bold uppercase tracking-widest text-[10px]" onclick="openReviewModal()">Execute Review</button>
                            <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>" class="btn flex-1 py-3 font-bold uppercase tracking-widest text-[10px]">Open Artifacts</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="p-16 text-center bg-gray-50/30 rounded-lg border-2 border-dashed border-gray-100">
                        <i class="fa-solid fa-hourglass-start text-5xl text-gray-100 mb-6 block"></i>
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Awaiting Submission</h4>
                        <p class="text-[11px] text-gray-400 mt-2 max-w-xs mx-auto mb-8">The research group has not yet transmitted a milestone for your academic evaluation.</p>
                        <a href="<?= APP_URL ?>/chat/<?= $repo['group_id'] ?>" class="text-[10px] font-bold text-blue-600 uppercase hover:underline"><i class="fa-solid fa-paper-plane mr-2"></i> Send Reminder to Group</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Project Activity Timeline (Placeholder styled) -->
        <div class="card">
            <div class="card-header bg-gray-50/50 flex justify-between items-center">
                <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">System Sync Log</h3>
                <a href="<?= APP_URL ?>/logbook" class="text-[9px] font-bold text-blue-600 uppercase hover:underline tracking-widest">Full Logbook <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
            <div class="card-body p-8">
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded bg-green-50 border border-green-100 flex items-center justify-center text-green-600">
                            <i class="fa-solid fa-code-commit text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Technical repository synchronized by Group Leader</p>
                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-mono italic">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400">
                            <i class="fa-solid fa-message text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Communication channel activity: +12 messages</p>
                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-mono italic">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar: Management Control -->
    <div class="space-y-6">
        <!-- Post Notice -->
        <div class="card p-6 border-blue-50 bg-blue-50/20">
            <h4 class="text-[10px] font-bold uppercase text-blue-600 tracking-widest mb-6 border-b border-blue-100 pb-2">Academic Directive</h4>
            <form method="POST" action="<?= APP_URL ?>/supervisor/notice">
                <?= \App\Core\Session::csrfField() ?>
                <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
                <div class="form-group">
                    <label class="form-label font-bold text-[10px] uppercase text-gray-400">Subject</label>
                    <input type="text" name="title" class="form-control text-xs" placeholder="Submission Deadline Extension..." required>
                </div>
                <div class="form-group mb-6">
                    <label class="form-label font-bold text-[10px] uppercase text-gray-400">Message Content</label>
                    <textarea name="content" class="form-control text-xs" rows="3" placeholder="Provide clarity or instructions..." required></textarea>
                </div>
                <button type="submit" class="btn btn-blue w-full p-2.5 font-bold uppercase tracking-widest text-[10px]">Transmit Notice</button>
            </form>
        </div>

        <!-- Meeting Control -->
        <div class="card p-6">
            <h4 class="text-[10px] font-bold uppercase text-gray-400 tracking-widest mb-4">Real-time Discussion</h4>
            <p class="text-[10px] text-gray-400 mb-6 leading-relaxed">Initiate a secure video conference or virtual defense session with the research team.</p>
            <a href="<?= APP_URL ?>/meetings/<?= $repo['id'] ?>" class="btn w-full p-2.5 font-bold uppercase tracking-widest text-[10px]">
                <i class="fa-solid fa-video mr-2 text-blue-600"></i> Start Sync Session
            </a>
        </div>

        <!-- Milestone Status Check -->
        <div class="card p-6 border-gray-100 bg-gray-50/50">
            <h4 class="text-[10px] font-bold uppercase text-gray-400 tracking-widest mb-2">Finalization Protocol</h4>
            <p class="text-[9px] text-gray-400 leading-relaxed mb-6 italic">Only recommend for defense when research artifacts are historically complete.</p>
            <form method="POST" action="<?= APP_URL ?>/supervisor/submit-to-hod" onsubmit="return confirm('Recommend this project for final HOD review / archival?')">
                <?= \App\Core\Session::csrfField() ?>
                <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
                <button type="submit" class="btn w-full p-3 font-bold uppercase tracking-widest text-[10px] border-green-200 text-green-700 hover:bg-green-50">
                    Recommend to HOD
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Review Decision Modal -->
<div id="review-modal" class="modal-overlay">
    <div class="modal animate-fade max-w-lg">
        <div class="modal-header">
            <h3 class="text-sm font-bold uppercase tracking-widest">Milestone adjudication</h3>
            <button class="btn btn-ghost" onclick="closeModal('review-modal')">&times;</button>
        </div>
        <form method="POST" action="<?= APP_URL ?>/supervisor/review">
            <?= \App\Core\Session::csrfField() ?>
            <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
            
            <div class="modal-body p-8 space-y-6">
                <div class="form-group">
                    <label class="form-label font-bold text-xs uppercase tracking-widest">Scientific Feedback</label>
                    <textarea name="comments" class="form-control p-3 border-2" rows="4" placeholder="Provide professional guidance or specify necessary corrections..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="submit" name="action" value="declined" class="btn btn-sm border-red-100 text-red-600 hover:bg-red-50 font-bold uppercase tracking-widest text-[10px]">
                        <i class="fa-solid fa-rotate mr-2"></i> Order Revisions
                    </button>
                    <button type="submit" name="action" value="accepted" class="btn btn-blue btn-sm font-bold uppercase tracking-widest text-[10px]">
                        <i class="fa-solid fa-circle-check mr-2"></i> Accept Artifact
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openReviewModal() { document.getElementById('review-modal').classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
</script>
