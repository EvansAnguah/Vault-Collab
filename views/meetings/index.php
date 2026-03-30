<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>" class="text-slate-500 hover:text-ocean-400 transition-colors"><i class="fa-solid fa-arrow-left"></i> Workspace</a>
            <span class="text-slate-700">/</span>
            <span class="text-ocean-400 font-bold"><?= htmlspecialchars($repo['title']) ?> Meetings</span>
        </div>
        <h1><i class="fa-solid fa-video text-ocean-500"></i> Project Discussions</h1>
        <p>Schedule and join video meetings with your supervisor or group members.</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary btn-sm" onclick="openModal('schedule-meeting-modal')">
            <i class="fa-solid fa-calendar-plus"></i> Schedule Meeting
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp">
    <!-- Meeting List -->
    <div class="lg:col-span-2 space-y-6">
        <div class="card bg-slate-800/20 border-slate-700/50">
            <div class="card-body">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-6">Upcoming Meetings</h3>
                
                <?php if (empty($meetings)): ?>
                    <div class="p-12 text-center text-slate-600">
                        <p class="text-sm italic">No upcoming meetings scheduled.</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($meetings as $m): ?>
                            <div class="p-6 bg-slate-900/40 rounded-2xl border border-slate-800 flex items-center justify-between group hover:border-ocean-500/30 transition-all">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-xl bg-ocean-500/10 flex flex-col items-center justify-center border border-ocean-500/20">
                                        <span class="text-[10px] font-bold text-ocean-400"><?= date('M', strtotime($m['meeting_date'])) ?></span>
                                        <span class="text-lg font-bold text-ocean-500"><?= date('d', strtotime($m['meeting_date'])) ?></span>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-slate-100"><?= htmlspecialchars($m['title']) ?></h4>
                                        <div class="flex items-center gap-4 mt-1">
                                            <span class="text-[11px] text-slate-500 font-mono"><i class="fa-solid fa-clock mr-1"></i> <?= date('H:i', strtotime($m['meeting_time'])) ?></span>
                                            <span class="text-[11px] text-slate-500"><i class="fa-solid fa-user mr-1"></i> Hosted by <?= htmlspecialchars($m['scheduler_first']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <a href="https://meet.jit.si/<?= $m['jitsi_room_id'] ?>" target="_blank" class="btn btn-primary btn-sm px-6">
                                        <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Join Meeting
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Column: Info -->
    <div class="card border-ocean-500/10 bg-ocean-500/5">
        <div class="card-body">
            <h3 class="text-xs font-bold uppercase tracking-widest text-ocean-400 mb-6">About Virtual Meetings</h3>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-shield-halved text-ocean-500 mt-1"></i>
                    <p class="text-[11px] text-slate-400">All meetings are powered by Jitsi Meet, ensuring encrypted and secure discussions.</p>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-video-slash text-ocean-500 mt-1"></i>
                    <p class="text-[11px] text-slate-400">Stable internet connection is recommended for smooth video and screen sharing.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Modal -->
<div id="schedule-meeting-modal" class="modal-overlay">
    <div class="modal animate__animated animate__slideInDown max-w-lg">
        <div class="modal-header">
            <h3>Schedule Project Discussion</h3>
            <button class="btn btn-ghost" onclick="closeModal('schedule-meeting-modal')">&times;</button>
        </div>
        <div class="modal-body p-6">
            <form method="POST" action="<?= APP_URL ?>/meetings/schedule">
                <?= \App\Core\Session::csrfField() ?>
                <input type="hidden" name="repo_id" value="<?= $repo['id'] ?>">
                
                <div class="form-group mb-4">
                    <label class="form-label font-bold text-slate-100">Meeting Title</label>
                    <input type="text" name="title" class="form-control" required placeholder="Ex: Weekly Progress Review">
                </div>

                <div class="form-group mb-4">
                    <label class="form-label font-bold text-slate-100">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="What is the agenda?"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="form-group">
                        <label class="form-label font-bold text-slate-100">Date</label>
                        <input type="date" name="meeting_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label font-bold text-slate-100">Time</label>
                        <input type="time" name="meeting_time" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full py-4 shadow-lg shadow-ocean-500/20">
                    <i class="fa-solid fa-calendar-check mr-2"></i> Schedule Meeting
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
</script>
