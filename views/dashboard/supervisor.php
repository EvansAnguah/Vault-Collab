<div class="mb-12 animate__animated animate__fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-4xl font-heading font-bold tracking-tight text-gray-900 mb-2">Faculty Mentorship Hub</h1>
            <p class="text-gray-400 font-medium tracking-widest text-[10px] uppercase mt-4 italic">Academic Oversight & Progress Synchronicity</p>
        </div>
        <div class="flex items-center gap-6">
            <div class="h-10 w-[1px] bg-gray-200"></div>
            <div class="text-right">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Mentor Registry</div>
                <div class="text-xs font-bold text-primary bg-primary/5 px-4 py-1.5 rounded-2xl italic tracking-tight italic">Assigned Lead</div>
            </div>
            <div class="w-14 h-14 bg-white shadow-soft rounded-2xl flex items-center justify-center border border-gray-100 font-heading text-xl font-bold text-gray-300 italic transition-transform hover:rotate-6 duration-300">
                <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
            </div>
        </div>
    </div>
</div>

<!-- Mentor Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16" data-aos="fade-up">
    <div class="card-premium border-l-4 border-l-primary flex items-center gap-6">
        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary shadow-lg shadow-primary/5">
            <i class="fa-solid fa-folder-tree text-2xl"></i>
        </div>
        <div>
            <div class="text-3xl font-heading font-bold text-gray-900"><?= count($groups) ?></div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Active Research Teams</div>
        </div>
    </div>

    <div class="card-premium border-l-4 border-l-emerald-500 flex items-center gap-6">
        <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 shadow-lg shadow-emerald-100/50">
            <i class="fa-solid fa-file-export text-2xl"></i>
        </div>
        <div>
            <div class="text-3xl font-heading font-bold text-gray-900">03</div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pending Milestone Reviews</div>
        </div>
    </div>

    <div class="card-premium border-l-4 border-l-amber-500 flex items-center gap-6">
        <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 shadow-lg shadow-amber-100/50">
            <i class="fa-solid fa-calendar-day text-2xl"></i>
        </div>
        <div>
            <div class="text-3xl font-heading font-bold text-gray-900">01</div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Scheduled Defense Hubs</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Assigned Teams Monitor -->
    <div class="lg:col-span-2 space-y-12" data-aos="fade-right">
        <div class="card-premium p-0 overflow-hidden shadow-premium bg-white">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
                <h3 class="text-xl font-bold tracking-tight font-heading">Mentorship Portfolio</h3>
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest">Last Sync: Today 14:24</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Research Group</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Project Assignment</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Health Delta</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Operation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if (empty($groups)): ?>
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-200">
                                        <i class="fa-solid fa-chalkboard-user text-4xl"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-1 font-heading">No Assignments Allocated</h4>
                                    <p class="text-xs text-gray-400 italic">No project repositories have been designated to your portfolio by the HOD.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($groups as $group): ?>
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-primary/20 transition-transform group-hover:scale-110">
                                                <?= strtoupper(substr($group['name'], 0, 1)) ?>
                                            </div>
                                            <div class="overflow-hidden">
                                                <div class="text-sm font-bold text-gray-900 truncate"><?= e($group['name']) ?></div>
                                                <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Registry ID: #<?= $group['id'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 max-w-xs">
                                        <div class="text-sm font-bold text-gray-700 line-clamp-1 mb-1 italic"><?= e($group['title'] ?? 'Untitled Research Component') ?></div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                            <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest">Active Collaboration</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col gap-1">
                                            <div class="w-16 h-1 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: 65%;"></div>
                                            </div>
                                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">65% Progress</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="<?= APP_URL ?>/supervisor/review/<?= $group['repo_id'] ?>" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border-2 border-gray-100 text-gray-900 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all hover:border-primary/50 hover:text-primary">
                                            Review Artifacts <i class="fa-solid fa-arrow-right text-[8px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-gray-50/50 border-t border-gray-50 text-center">
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.4em]">Faculty Mentor Audit Mode Alpha-2</span>
            </div>
        </div>
    </div>

    <!-- Right Sidebar Mentorship Tools -->
    <div class="space-y-10" data-aos="fade-left">
        <!-- Directives Console -->
        <div class="card-premium border-none shadow-premium bg-gray-900 p-8">
            <h3 class="text-xs font-bold uppercase tracking-widest text-primary mb-8 underline decoration-primary decoration-2 underline-offset-4">Directive Console</h3>
            <form action="<?= APP_URL ?>/supervisor/broadcast" method="POST" class="space-y-6">
                <div class="space-y-4">
                    <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest px-1">Target Repository Hub</label>
                    <select name="repo_id" class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-4 py-3 text-white text-xs outline-none focus:border-primary transition-all">
                        <option value="">Select Research Team...</option>
                        <?php foreach($groups as $g): ?>
                            <option value="<?= $g['repo_id'] ?>"><?= e($g['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-4">
                    <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest px-1">Academic Directive</label>
                    <textarea name="content" class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-4 py-3 text-white text-xs outline-none focus:border-primary transition-all h-24 italic" placeholder="Transmit instruction to the group..."></textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-primary text-white rounded-2xl text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg shadow-primary/20 transition-all hover:-translate-y-1">Execute Transmission</button>
            </form>
        </div>

        <!-- Sync Center -->
        <div class="card-premium group hover:shadow-premium transition-all duration-500 bg-white border-2 border-gray-50 relative overflow-hidden">
            <div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
            <div class="flex flex-col items-center text-center py-4">
                <div class="w-20 h-20 bg-emerald-50 rounded-[2rem] flex items-center justify-center text-emerald-500 mb-8 transition-transform group-hover:scale-110 duration-500 shadow-soft">
                    <i class="fa-solid fa-video text-3xl animate-pulse"></i>
                </div>
                <h4 class="text-lg font-bold mb-3 font-heading tracking-tight">Virtual Defense Sync</h4>
                <p class="text-[10px] text-gray-400 font-medium px-4 mb-10 uppercase tracking-widest leading-relaxed">Initiate real-time technical review session with selected researchers.</p>
                <a href="<?= APP_URL ?>/meetings" class="w-full py-4 bg-gray-50 text-gray-900 rounded-2xl text-[10px] font-bold uppercase tracking-[0.3em] transition-all hover:bg-gray-100">Establish Link</a>
            </div>
        </div>

        <!-- Mentorship Policy -->
        <div class="p-8 card-premium border-none bg-gray-50/50 flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-shield-halved text-gray-200"></i>
                <span class="text-[9px] font-bold uppercase tracking-widest text-gray-400">Institutional Integrity Protocol</span>
            </div>
            <p class="text-[10px] text-gray-400 leading-relaxed italic">"Mentorship is the cornerstone of academic research. Maintain professional boundaries and offer constructive scientific guidance at all project stages."</p>
        </div>
    </div>
</div>
