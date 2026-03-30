<div class="mb-12 animate__animated animate__fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 text-center md:text-left">
        <div>
            <div class="flex items-center gap-3 mb-4 justify-center md:justify-start">
                <a href="<?= APP_URL ?>/dashboard" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-primary transition-colors italic">Institutional Oversight</a>
                <span class="text-gray-200">/</span>
                <span class="text-primary text-[10px] font-bold uppercase tracking-widest">Repository Proposal Manifest</span>
            </div>
            <h1 class="text-4xl font-heading font-bold tracking-tight text-gray-900 leading-tight">Project Adjudication Queue</h1>
        </div>
        <div class="flex items-center gap-4 justify-center md:justify-end">
            <div class="text-right flex flex-col items-center md:items-end">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Queue Health</div>
                <div class="text-xs font-bold text-amber-600 bg-amber-50 px-4 py-1.5 rounded-2xl italic tracking-tight italic"><?= count($requests) ?> Decisions Pending</div>
            </div>
            <div class="w-14 h-14 bg-white shadow-soft rounded-2xl flex items-center justify-center border border-gray-100 font-heading text-xl font-bold text-primary italic transition-transform hover:scale-105 duration-300">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
        </div>
    </div>
</div>

<div class="space-y-12" data-aos="fade-up">
    <!-- Main Manifest Card -->
    <div class="card-premium p-0 overflow-hidden shadow-premium bg-white border-2 border-gray-50">
        <div class="p-10 border-b border-gray-50 flex flex-col md:flex-row justify-between items-center gap-6 bg-gray-50/20">
            <h3 class="text-xl font-bold tracking-tight font-heading border-l-4 border-primary pl-4">Institutional Proposal Registry</h3>
            <div class="flex gap-4">
                <div class="px-6 py-2 bg-white border border-gray-100 rounded-xl flex items-center gap-3 shadow-soft group cursor-pointer hover:border-primary/20 transition-all active:scale-95 duration-200">
                    <i class="fa-solid fa-filter text-gray-300 group-hover:text-primary transition-colors"></i>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Protocol Filter</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-10 py-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading">Source Ensemble</th>
                        <th class="px-10 py-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading">Research Title & Domain</th>
                        <th class="px-10 py-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading">Submission Clock</th>
                        <th class="px-10 py-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading text-right">Adjudication</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($requests)): ?>
                        <tr>
                            <td colspan="4" class="px-10 py-32 text-center">
                                <div class="w-24 h-24 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-gray-200 shadow-soft transition-transform hover:scale-110 duration-500">
                                    <i class="fa-solid fa-box-open text-5xl"></i>
                                </div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-2 font-heading tracking-tight italic uppercase">Queue Synchronized / Null</h4>
                                <p class="text-xs text-gray-400 font-medium italic opacity-80 uppercase tracking-widest">All repository proposals have been historically adjudicated.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($requests as $req): ?>
                            <tr class="hover:bg-gray-50/80 transition-all duration-300 group">
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-6">
                                        <div class="w-14 h-14 bg-primary/10 rounded-[1.25rem] flex items-center justify-center text-primary font-bold shadow-soft transition-transform group-hover:scale-110">
                                            <?= strtoupper(substr($req['group_name'], 0, 1)) ?>
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="text-sm font-bold text-gray-900 truncate tracking-tight"><?= e($req['group_name']) ?></div>
                                            <div class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.2em] italic">Registry ID: HUB-<?= $req['id'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8 max-w-sm">
                                    <div class="text-sm font-bold text-gray-700 leading-snug mb-3 italic">"<?= e($req['title']) ?>"</div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="px-4 py-1 bg-blue-50 text-blue-600 rounded-full text-[8px] font-bold uppercase tracking-widest border border-blue-100 italic transition-colors group-hover:bg-primary group-hover:text-white group-hover:border-transparent">Technical Thesis</span>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-gray-900 font-mono italic underline decoration-gray-100 decoration-4 underline-offset-4"><?= date('M d, Y', strtotime($req['created_at'])) ?></span>
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest italic"><?= date('H:i', strtotime($req['created_at'])) ?> HUB SYNC</span>
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                        <form method="POST" action="<?= APP_URL ?>/hod/review-request" class="inline">
                                            <?= \App\Core\Session::csrfField() ?>
                                            <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                                            <div class="flex gap-3">
                                                <button type="submit" name="action" value="declined" class="w-10 h-10 bg-white border border-rose-100 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-50 transition-all shadow-soft active:scale-90" title="Decline Proposal">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                                <button type="submit" name="action" value="accepted" class="px-8 py-3 bg-primary text-white rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all hover:shadow-lg shadow-primary/20 hover:-translate-y-0.5 active:translate-y-0">
                                                    Execute Approval
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-gray-50/50 border-t border-gray-100 text-center flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.4em] italic mb-0">Institutional Review Manifest Integrity Layer v4.0</p>
            <div class="flex items-center gap-3">
                <span class="text-[8px] font-bold text-emerald-500 uppercase tracking-widest italic flex items-center gap-2 underline decoration-emerald-100 underline-offset-4 decoration-2">Registry Live Integration <div class="w-1 h-1 rounded-full bg-emerald-500"></div></span>
            </div>
        </div>
    </div>

    <!-- Procedural Alert -->
    <div class="p-10 card-premium border-none bg-primary text-white shadow-premium relative overflow-hidden group">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-5"></div>
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-1000"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
            <div class="w-16 h-16 bg-white/10 rounded-[1.5rem] flex items-center justify-center text-white text-2xl backdrop-blur-md border border-white/20 shadow-lg group-hover:rotate-6 transition-transform">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h4 class="text-lg font-bold mb-2 tracking-tight italic uppercase font-heading tracking-widest">Adjudication Protocol Alert</h4>
                <p class="text-primary-100 text-[10px] font-bold uppercase tracking-widest opacity-80 leading-relaxed italic border-l-2 border-white/20 pl-6 px-4">Repository approval automatically initializes the technical workspace and assigns academic credentials to the research ensemble. Exercise institutional diligence during adjudication.</p>
            </div>
        </div>
    </div>
</div>
