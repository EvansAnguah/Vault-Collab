<div class="mb-12 animate__animated animate__fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-4xl font-heading font-bold tracking-tight text-gray-900 mb-2 underline decoration-primary decoration-4 underline-offset-8">Administrative Command</h1>
            <p class="text-gray-400 font-medium tracking-widest text-[10px] uppercase mt-4 italic">Registry of Research & Academic Approval</p>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex -space-x-3">
                <!-- Sample team avatars -->
                <div class="w-10 h-10 rounded-full border-2 border-white bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-600">JS</div>
                <div class="w-10 h-10 rounded-full border-2 border-white bg-emerald-100 flex items-center justify-center text-[10px] font-bold text-emerald-600">RL</div>
                <div class="w-10 h-10 rounded-full border-2 border-white bg-amber-100 flex items-center justify-center text-[10px] font-bold text-amber-600">+9</div>
            </div>
            <div class="h-10 w-[1px] bg-gray-200"></div>
            <div class="text-right">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Faculty Status</div>
                <div class="text-xs font-bold text-gray-900">Department Lead</div>
            </div>
        </div>
    </div>
</div>

<!-- Registry Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16" data-aos="fade-up">
    <div class="card-premium relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-125 duration-700"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary shadow-lg shadow-primary/5">
                    <i class="fa-solid fa-people-group text-xl"></i>
                </div>
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full">Active</span>
            </div>
            <div class="text-4xl font-heading font-bold text-gray-900 mb-2"><?= $stats['total_groups'] ?? 0 ?></div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Research Teams Registry</div>
        </div>
    </div>

    <div class="card-premium relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-125 duration-700"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 shadow-lg shadow-amber-100/50">
                    <i class="fa-solid fa-hourglass-half text-xl animate-pulse"></i>
                </div>
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full">Pending</span>
            </div>
            <div class="text-4xl font-heading font-bold text-amber-600 mb-2"><?= $stats['pending_repos'] ?? 0 ?></div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">Proposals Awaiting Adjudication</div>
        </div>
    </div>

    <div class="card-premium relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-125 duration-700"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 shadow-lg shadow-emerald-100/50">
                    <i class="fa-solid fa-cloud-check text-xl"></i>
                </div>
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full">Sync</span>
            </div>
            <div class="text-4xl font-heading font-bold text-gray-900 mb-2"><?= $stats['total_repos'] ?? 0 ?></div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Active System Repositories</div>
        </div>
    </div>

    <div class="card-premium relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-125 duration-700"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 shadow-lg shadow-purple-100/50">
                    <i class="fa-solid fa-box-archive text-xl"></i>
                </div>
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full">Archive</span>
            </div>
            <div class="text-4xl font-heading font-bold text-gray-900 mb-2">126</div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">Total Historical Submissions</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Queue Monitor -->
    <div class="lg:col-span-2 space-y-12" data-aos="fade-right">
        <div class="card-premium p-0 overflow-hidden shadow-premium">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
                <h3 class="text-xl font-bold tracking-tight font-heading">Decision Queue / Proposal Manifest</h3>
                <a href="<?= APP_URL ?>/hod/repo-requests" class="text-[10px] font-bold text-primary uppercase tracking-[0.2em] hover:underline">Full Adjudication Hub</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Research Team</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Target Project Registry</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Operation Access</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if (empty($pendingRequests)): ?>
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-200">
                                        <i class="fa-solid fa-clipboard-check text-4xl"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-1">Queue Synchronized</h4>
                                    <p class="text-xs text-gray-400 italic">No pending project proposals require executive action.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pendingRequests as $req): ?>
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-primary/5 rounded-xl flex items-center justify-center text-primary font-bold shadow-soft">
                                                <?= strtoupper(substr($req['group_name'], 0, 1)) ?>
                                            </div>
                                            <div class="overflow-hidden">
                                                <div class="text-sm font-bold text-gray-900 truncate"><?= e($req['group_name']) ?></div>
                                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID: #<?= $req['id'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 max-w-xs">
                                        <div class="text-sm font-bold text-gray-700 line-clamp-1 mb-1"><?= e($req['title']) ?></div>
                                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter italic">Pending Repository Allocation</div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button onclick="window.location.href='<?= APP_URL ?>/hod/repo-requests'" class="px-6 py-2.5 bg-primary text-white rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all hover:shadow-lg shadow-primary/20 hover:-translate-y-0.5">
                                                Adjudicate Request
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-gray-50/50 border-t border-gray-50 text-center">
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.3em]">Institutional Review Board Protocol v3.1</span>
            </div>
        </div>

        <!-- Quick Manifest Tools -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="card-premium group hover:bg-primary transition-all duration-500 cursor-pointer border-none shadow-soft overflow-hidden relative">
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-12 h-12 bg-primary/10 group-hover:bg-white/20 rounded-2xl flex items-center justify-center text-primary group-hover:text-white mb-6 transition-colors duration-500">
                        <i class="fa-solid fa-file-import text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold mb-2 group-hover:text-white transition-colors duration-500 tracking-tight leading-tight">Student Manifest Sync</h4>
                    <p class="text-gray-400 group-hover:text-primary-100 text-xs font-medium leading-relaxed mb-10 transition-colors duration-500">Fast batch registration of research teams via CSV protocol.</p>
                    <a href="<?= APP_URL ?>/hod/upload-students" class="mt-auto px-6 py-3 bg-gray-50 group-hover:bg-white text-gray-900 rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] text-center transition-all duration-500 shadow-soft">Execute Batch Sync</a>
                </div>
            </div>

            <div class="card-premium group hover:bg-emerald-600 transition-all duration-500 cursor-pointer border-none shadow-soft overflow-hidden relative">
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-12 h-12 bg-emerald-50 group-hover:bg-white/20 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:text-white mb-6 transition-colors duration-500">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold mb-2 group-hover:text-white transition-colors duration-500 tracking-tight leading-tight">Archival Snapshot</h4>
                    <p class="text-gray-400 group-hover:text-emerald-100 text-xs font-medium leading-relaxed mb-10 transition-colors duration-500">Commit final academic artifacts once the research defense is finalized.</p>
                    <a href="<?= APP_URL ?>/hod/submissions" class="mt-auto px-6 py-3 bg-gray-50 group-hover:bg-white text-gray-900 rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] text-center transition-all duration-500 shadow-soft">Finalize Submissions</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar Core -->
    <div class="space-y-10" data-aos="fade-left">
        <!-- Faculty Pulse -->
        <div class="card-premium border-none shadow-premium relative group overflow-hidden bg-gray-900 border-gray-800">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="relative z-10">
                <h3 class="text-xs font-bold uppercase tracking-widest text-primary mb-10">Faculty Status Pulse</h3>
                <div class="space-y-10">
                    <div class="flex items-start gap-4">
                        <div class="w-1.5 h-10 bg-primary/30 rounded-full flex items-end"><div class="w-full h-2/3 bg-primary rounded-full animate-bounce"></div></div>
                        <div>
                            <div class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-1 leading-none">Repo Activity Delta</div>
                            <div class="text-xl font-bold text-white tracking-widest">+18.4%</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-1.5 h-10 bg-emerald-500/30 rounded-full flex items-end"><div class="w-full h-full bg-emerald-500 rounded-full"></div></div>
                        <div>
                            <div class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-1 leading-none">System Health Integrity</div>
                            <div class="text-xl font-bold text-white tracking-widest">99.98%</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-1.5 h-10 bg-amber-500/30 rounded-full flex items-end"><div class="w-full h-1/4 bg-amber-500 rounded-full"></div></div>
                        <div>
                            <div class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-1 leading-none">Registry Capacity Limit</div>
                            <div class="text-xl font-bold text-white tracking-widest">E84 / Q500</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supervisor Assignment Monitor -->
        <div class="card-premium p-8 shadow-soft border-gray-100 bg-white group hover:shadow-premium duration-500 transition-all">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-[1.5rem] flex items-center justify-center text-gray-400 mb-8 transition-transform group-hover:rotate-12 duration-500">
                    <i class="fa-solid fa-user-plus text-2xl"></i>
                </div>
                <h4 class="text-sm font-bold mb-4 tracking-tight leading-tight uppercase text-gray-400 tracking-widest text-[10px]">Academic Link Protocol</h4>
                <p class="text-xs text-gray-400 leading-relaxed italic mb-10">Ensure every research team has a dedicated mentor assigned to their repository.</p>
                <a href="<?= APP_URL ?>/hod/assign-supervisor" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 text-gray-900 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all hover:bg-gray-100 hover:-translate-y-1">Resource Assignments</a>
            </div>
        </div>

        <!-- System Message / Broadcast -->
        <div class="p-10 card-premium bg-gradient-to-br from-primary to-blue-700 border-none shadow-premium relative group overflow-hidden cursor-pointer active:scale-95 duration-200">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-white mb-6 backdrop-blur-md">
                    <i class="fa-solid fa-tower-broadcast text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-white mb-2 leading-tight tracking-tight">Faculty Broadcast</h4>
                <p class="text-primary-100 text-[10px] font-bold uppercase tracking-widest opacity-80 leading-relaxed italic">Transmit Directive to All Hub Repositories</p>
            </div>
        </div>
    </div>
</div>
