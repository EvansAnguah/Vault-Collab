<div class="mb-12 animate__animated animate__fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <a href="<?= APP_URL ?>/dashboard" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-primary transition-colors">Registry Hub</a>
                <span class="text-gray-200">/</span>
                <span class="text-primary text-[10px] font-bold uppercase tracking-widest">Research Team Management</span>
            </div>
            <h1 class="text-4xl font-heading font-bold tracking-tight text-gray-900 leading-tight">Project Group Registry</h1>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Status Protocol</div>
                <div class="text-xs font-bold text-emerald-600 bg-emerald-50 px-4 py-1.5 rounded-2xl italic tracking-tight italic">Verified Ensemble</div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Group Details -->
    <div class="lg:col-span-2 space-y-12" data-aos="fade-right">
        <div class="card-premium p-0 overflow-hidden shadow-premium bg-white">
            <div class="p-10 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-primary text-white rounded-[1.5rem] flex items-center justify-center text-2xl font-bold shadow-lg shadow-primary/20">
                        <?= strtoupper(substr($group['name'], 0, 1)) ?>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight font-heading text-gray-900 leading-tight"><?= e($group['name']) ?></h2>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.25em] italic leading-relaxed">Registry ID: HUB-<?= $group['id'] ?>-SYNC</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-lg font-bold text-gray-900 mb-1"><?= count($members) ?> / 4</div>
                    <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none">Unit Capacity</div>
                </div>
            </div>
            
            <div class="p-10">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-10 border-b border-gray-50 pb-4 italic">Active Research Personnel</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($members as $member): ?>
                        <div class="p-6 bg-gray-50/50 border-2 border-transparent hover:border-primary/10 hover:bg-white rounded-[2rem] transition-all duration-300 group flex items-center gap-6">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-primary font-bold shadow-soft group-hover:scale-110 transition-transform">
                                <?= strtoupper(substr($member['first_name'], 0, 1)) ?>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <p class="text-sm font-bold text-gray-900 truncate leading-none mb-1"><?= e($member['first_name'] . ' ' . $member['last_name']) ?></p>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest italic"><?= e($member['role'] == 'leader' ? 'Tactical Lead' : 'Research Associate') ?></span>
                            </div>
                            <?php if ($member['role'] == 'leader'): ?>
                                <i class="fa-solid fa-shield-halved text-emerald-500 text-sm"></i>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (count($members) < 4): ?>
                        <div class="p-6 border-2 border-dashed border-gray-100 rounded-[2rem] flex items-center justify-center group hover:bg-gray-50 transition-all duration-300 cursor-pointer">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-300 group-hover:text-primary mb-3 transition-colors">
                                    <i class="fa-solid fa-user-plus text-sm"></i>
                                </div>
                                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest group-hover:text-gray-400 font-heading">Slot Pending Allocation</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="px-10 py-6 bg-gray-50/50 border-t border-gray-50 flex justify-between items-center font-heading">
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.3em]">Operational Readiness Check: Optimal</span>
                <span class="text-[10px] font-bold text-primary italic uppercase tracking-widest underline decoration-2 underline-offset-4 cursor-pointer hover:text-blue-700">Invite Personnel</span>
            </div>
        </div>

        <!-- Project Repository Link (If requested) -->
        <?php if ($hasRepoRequest): ?>
            <div class="card-premium p-10 shadow-premium border-none relative overflow-hidden bg-primary text-white scale-[1.02] group">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                    <div class="w-20 h-20 bg-white/10 rounded-[2rem] flex items-center justify-center text-white text-3xl backdrop-blur-md border border-white/20 shadow-lg group-hover:rotate-12 duration-500">
                        <i class="fa-solid fa-code-pull-request"></i>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-xl font-bold mb-2 tracking-tight italic">Hub Repository Proposal Active</h4>
                        <p class="text-primary-100 text-[10px] font-bold uppercase tracking-widest opacity-80 leading-relaxed mb-6">"<?= e($repoProposal['title']) ?>"</p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4">
                            <span class="px-6 py-2 bg-white/10 rounded-full text-[9px] font-bold uppercase tracking-widest border border-white/10">Status: Awaiting HOD Adjudication</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Sidebar Governance Tools -->
    <div class="space-y-10" data-aos="fade-left">
        <!-- Team Directive console -->
        <div class="card-premium border-none shadow-premium bg-gray-900 p-8 group overflow-hidden relative">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-5"></div>
            <div class="relative z-10">
                <h3 class="text-xs font-bold uppercase tracking-widest text-primary mb-8 underline decoration-primary decoration-2 underline-offset-4 italic font-heading tracking-tight">Team Protocol Hub</h3>
                <div class="space-y-8">
                    <button class="w-full p-4 bg-gray-800 border-2 border-transparent hover:border-primary/30 transition-all rounded-2xl flex items-center gap-4 text-left group/btn active:scale-95 duration-200">
                        <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center text-primary group-hover/btn:scale-110">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-white uppercase tracking-widest">Authority Transfer</div>
                            <span class="text-[9px] text-gray-500 font-bold uppercase italic">Re-designate Tactical Lead</span>
                        </div>
                    </button>

                    <button class="w-full p-4 bg-gray-800 border-2 border-transparent hover:border-rose-500/30 transition-all rounded-2xl flex items-center gap-4 text-left group/btn active:scale-95 duration-200">
                        <div class="w-10 h-10 bg-rose-500/20 rounded-xl flex items-center justify-center text-rose-500 group-hover/btn:scale-110">
                            <i class="fa-solid fa-person-walking-dashed-line text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-white uppercase tracking-widest">Dissolve Registry</div>
                            <span class="text-[9px] text-gray-500 font-bold uppercase italic">Terminate Hub Ensemble</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sync Center -->
        <div class="card-premium p-10 text-center flex flex-col items-center shadow-soft group hover:shadow-premium duration-500 transition-all cursor-help relative overflow-hidden bg-white">
            <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="w-16 h-16 bg-primary/10 rounded-[1.5rem] flex items-center justify-center text-primary mb-8 shadow-soft transition-transform group-hover:rotate-12 duration-500">
                <i class="fa-solid fa-network-wired text-2xl"></i>
            </div>
            <h4 class="text-sm font-bold mb-4 tracking-tight leading-tight uppercase text-gray-900 tracking-widest text-[10px] font-heading underline decoration-gray-100 decoration-4 underline-offset-8">Inter-Departmental Sync</h4>
            <p class="text-xs text-gray-400 leading-relaxed italic mb-10 px-4">Research groups are limited to four (4) active personnel identities to maintain operational efficiency and academic check-balance.</p>
            <div class="w-full h-2 bg-gray-50 rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full" style="width: 75%;"></div>
            </div>
            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest mt-3">Registry Capacity Limit</span>
        </div>

        <!-- Integrity Check -->
        <div class="p-8 card-premium border-none bg-emerald-50 flex items-center justify-between group active:scale-95 transition-transform cursor-pointer shadow-premium shadow-emerald-500/5">
            <div class="flex items-center gap-4">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-700 group-hover:text-primary transition-colors italic">Team Integrity Verified</span>
            </div>
            <i class="fa-solid fa-fingerprint text-emerald-200 text-3xl"></i>
        </div>
    </div>
</div>
