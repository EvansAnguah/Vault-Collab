<div class="mb-12 animate__animated animate__fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-heading font-bold tracking-tight text-gray-900 mb-2">Welcome back, <?= e($user['first_name']) ?>!</h1>
            <p class="text-gray-500 font-medium tracking-wide italic">Secure Collaboration Portal / Project Hub</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Session Protocol</div>
                <div class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full inline-block">Active Sync</div>
            </div>
            <div class="w-14 h-14 bg-white shadow-soft rounded-2xl flex items-center justify-center border border-gray-100 italic transition-transform hover:scale-105 duration-300">
                <span class="text-primary font-bold text-xl"><?= strtoupper(substr($user['first_name'], 0, 1)) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16" data-aos="fade-up">
    <div class="card-premium border-b-4 border-b-primary shadow-soft bg-white/50 backdrop-blur-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                <i class="fa-solid fa-users-viewfinder text-xl"></i>
            </div>
            <span class="text-xs font-bold text-gray-300 uppercase tracking-tighter">Registry</span>
        </div>
        <div class="text-3xl font-heading font-bold text-gray-900 mb-1"><?= $groupMembers ?? 0 ?> Members</div>
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Active Research Team</div>
    </div>

    <div class="card-premium border-b-4 border-b-emerald-500 shadow-soft bg-white/50 backdrop-blur-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600">
                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
            </div>
            <span class="text-xs font-bold text-gray-300 uppercase tracking-tighter">Sync</span>
        </div>
        <div class="text-3xl font-heading font-bold text-gray-900 mb-1"><?= $hasRepo ? 'Active' : 'N/A' ?></div>
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Repository Status</div>
    </div>

    <div class="card-premium border-b-4 border-b-amber-500 shadow-soft bg-white/50 backdrop-blur-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600">
                <i class="fa-solid fa-comments text-xl"></i>
            </div>
            <span class="text-xs font-bold text-gray-300 uppercase tracking-tighter">Comm</span>
        </div>
        <div class="text-3xl font-heading font-bold text-gray-900 mb-1"><?= $unreadMessages ?? 0 ?> Unread</div>
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Discussion Alerts</div>
    </div>

    <div class="card-premium border-b-4 border-b-purple-500 shadow-soft bg-white/50 backdrop-blur-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
            <span class="text-xs font-bold text-gray-300 uppercase tracking-tighter">Check</span>
        </div>
        <div class="text-3xl font-heading font-bold text-gray-900 mb-1"><?= $upcomingMeetings ?? 0 ?> Due</div>
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Upcoming Deadlines</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Project Monitor -->
    <div class="lg:col-span-2 space-y-12" data-aos="fade-right">
        <div class="card-premium p-0 overflow-hidden shadow-premium">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                <h3 class="text-xl font-bold tracking-tight font-heading">Current Research Focus</h3>
                <?php if ($hasRepo): ?>
                    <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase tracking-widest">Live Repository</span>
                <?php endif; ?>
            </div>
            
            <div class="p-8">
                <?php if ($hasRepo): ?>
                    <div class="flex flex-col md:flex-row gap-10">
                        <div class="w-24 h-24 bg-primary/10 rounded-[2rem] flex items-center justify-center text-primary text-4xl shadow-soft">
                            <i class="fa-solid fa-code-merge"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h4 class="text-2xl font-bold mb-4 leading-tight text-gray-900"><?= e($repo['title']) ?></h4>
                            <p class="text-gray-500 leading-relaxed max-w-xl mb-10 italic font-medium">"<?= e($repo['description'] ?? 'Establishing project framework and documentation objectives.') ?>"</p>
                            
                            <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                                <a href="<?= APP_URL ?>/workspace/<?= $repo['id'] ?>" class="group flex items-center gap-3 px-8 py-4 bg-primary text-white rounded-2xl font-bold transition-all shadow-lg shadow-primary/30 hover:-translate-y-1 active:translate-y-0">
                                    <i class="fa-solid fa-terminal text-lg group-hover:rotate-12 transition-transform"></i> Enter Technical Workspace
                                </a>
                                <a href="<?= APP_URL ?>/chat/<?= $repo['group_id'] ?>" class="flex items-center gap-3 px-8 py-4 bg-white border-2 border-gray-100 text-gray-700 rounded-2xl font-bold transition-all hover:bg-gray-50 hover:border-primary/20">
                                    <i class="fa-solid fa-comments text-primary"></i> Team Sync Lobby
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="py-20 flex flex-col items-center text-center">
                        <div class="w-28 h-28 bg-gray-50 rounded-full flex items-center justify-center mb-10 animate-pulse">
                            <i class="fa-solid fa-folder-plus text-5xl text-gray-200"></i>
                        </div>
                        <h4 class="text-2xl font-bold mb-3 text-gray-900 font-heading tracking-tight">Access Restricted / No Registry Found</h4>
                        <p class="text-gray-400 max-w-sm mb-12 italic">You must establish a validated research group or transmit a proposal manifest before technical access is granted.</p>
                        
                        <?php if (isset($group) && $group): ?>
                            <a href="<?= APP_URL ?>/student/request-repo" class="px-10 py-5 bg-primary text-white rounded-[2rem] font-bold shadow-lg shadow-primary/20 transition-all hover:-translate-y-1">
                                <i class="fa-solid fa-paper-plane mr-3 text-xl"></i> Transmit Project Proposal
                            </a>
                        <?php else: ?>
                            <a href="<?= APP_URL ?>/student/create-group" class="px-10 py-5 bg-white border-2 border-gray-100 text-gray-900 rounded-[2rem] font-bold shadow-soft transition-all hover:border-primary/50 hover:text-primary">
                                <i class="fa-solid fa-users-medical mr-3 text-xl"></i> Initialize Research Team
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="p-4 bg-gray-50/50 border-t border-gray-50 text-center">
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.3em]">Institutional Research Standard Tier Alpha</span>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="card-premium shadow-soft">
            <div class="flex justify-between items-center mb-10">
                <h3 class="text-lg font-bold tracking-tight font-heading uppercase text-gray-400 tracking-widest text-[10px]">Operation Logs</h3>
                <button class="text-xs font-bold text-primary hover:underline">Full System Logbook</button>
            </div>
            <div class="space-y-4">
                <?php for($i=0; $i<3; $i++): ?>
                    <div class="group p-4 bg-gray-50/30 rounded-2xl border border-transparent hover:border-gray-100 hover:bg-white transition-all duration-300 flex items-center gap-6">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-soft flex items-center justify-center text-primary group-hover:scale-110 duration-300">
                            <i class="fa-solid fa-code-commit"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900 leading-none mb-1">Technical Document Synchronized</p>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter italic">Source: Chapter One Overview</span>
                        </div>
                        <div class="text-[10px] font-bold text-gray-300 uppercase tracking-widest italic">2h Ago</div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Tools -->
    <div class="space-y-10" data-aos="fade-left">
        <!-- Resource Hub -->
        <div class="bg-primary p-12 rounded-[3.5rem] shadow-premium shadow-primary/30 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/10 rounded-3xl flex items-center justify-center text-white text-2xl mb-10 backdrop-blur-md border border-white/20">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h4 class="text-3xl font-bold text-white mb-4 font-heading leading-tight italic">Academy Knowledge Hub</h4>
                <p class="text-primary-100 text-xs font-medium leading-relaxed mb-10 opacity-80 uppercase tracking-widest">Access curated research protocols and technical cheat-sheets.</p>
                <div class="grid grid-cols-1 gap-4">
                    <a href="<?= APP_URL ?>/cheat-sheets" class="bg-white/10 hover:bg-white/20 text-white rounded-2xl py-4 flex items-center justify-center font-bold text-xs backdrop-blur-sm transition-all border border-white/5">Research Protocols</a>
                    <a href="<?= APP_URL ?>/learning" class="bg-white text-primary rounded-2xl py-4 flex items-center justify-center font-bold text-xs shadow-lg transition-all hover:scale-105 active:scale-100">Learning Center</a>
                </div>
            </div>
        </div>

        <!-- Supervisor Directives -->
        <?php if (!empty($notices)): ?>
            <div class="card-premium bg-amber-50 border-none shadow-premium shadow-amber-100/50">
                <div class="flex items-center gap-3 mb-8 border-b border-amber-200/50 pb-4">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                        <i class="fa-solid fa-bullhorn rotate-12"></i>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-amber-700">Academic Directive</h3>
                </div>
                <div class="space-y-6">
                    <?php foreach ($notices as $notice): ?>
                        <div class="relative pl-6 border-l-2 border-amber-300">
                            <p class="text-sm text-amber-900 font-bold mb-2 leading-relaxed italic"><?= e($notice['content']) ?></p>
                            <span class="text-[10px] font-bold text-amber-500 uppercase tracking-tighter">Transmission Source: Supervisor Official</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- System Health -->
        <div class="p-10 card-premium border-none bg-gray-50 flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-primary transition-colors">Hub Operations Sync</span>
            </div>
            <i class="fa-solid fa-shield-halved text-gray-200 text-2xl"></i>
        </div>
    </div>
</div>
