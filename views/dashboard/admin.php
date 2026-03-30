<div class="mb-12 animate__animated animate__fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-4xl font-heading font-bold tracking-tight text-gray-900 mb-2">Central Authority Hub</h1>
            <p class="text-gray-400 font-medium tracking-widest text-[10px] uppercase mt-4 italic">Security, Identity & Faculty Governance</p>
        </div>
        <div class="flex items-center gap-6">
            <div class="h-10 w-[1px] bg-gray-200"></div>
            <div class="text-right">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Root Authority</div>
                <div class="text-xs font-bold text-primary bg-primary/5 px-4 py-1.5 rounded-2xl italic tracking-tight italic">System Root Layer</div>
            </div>
            <div class="w-14 h-14 bg-white shadow-soft rounded-2xl flex items-center justify-center border border-gray-100 font-heading text-xl font-bold text-gray-300 italic transition-transform hover:rotate-6 duration-300">
                <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
            </div>
        </div>
    </div>
</div>

<!-- Authority Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16" data-aos="fade-up">
    <div class="card-premium border-l-4 border-l-primary flex flex-col justify-between group overflow-hidden relative shadow-premium shadow-primary/5">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary shadow-soft">
                <i class="fa-solid fa-users-cog text-xl"></i>
            </div>
            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full">Identities</span>
        </div>
        <div>
            <div class="text-3xl font-heading font-bold text-gray-900 mb-1"><?= $stats['total_users'] ?? 0 ?></div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">Total System Personnels</div>
        </div>
    </div>

    <div class="card-premium border-l-4 border-l-emerald-500 flex flex-col justify-between group overflow-hidden relative shadow-premium shadow-emerald-500/5">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 shadow-soft">
                <i class="fa-solid fa-sitemap text-xl"></i>
            </div>
            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full">Faculty</span>
        </div>
        <div>
            <div class="text-3xl font-heading font-bold text-gray-900 mb-1"><?= $stats['total_departments'] ?? 0 ?></div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">Active Faculty Divisions</div>
        </div>
    </div>

    <div class="card-premium border-l-4 border-l-amber-500 flex flex-col justify-between group overflow-hidden relative shadow-premium shadow-amber-500/5">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-amber-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 shadow-soft">
                <i class="fa-solid fa-server text-xl"></i>
            </div>
            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full">Integrity</span>
        </div>
        <div>
            <div class="text-3xl font-heading font-bold text-gray-900 mb-1">99.9%</div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">System Performance Health</div>
        </div>
    </div>

    <div class="card-premium border-l-4 border-l-purple-500 flex flex-col justify-between group overflow-hidden relative shadow-premium shadow-purple-500/5">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-purple-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 shadow-soft">
                <i class="fa-solid fa-shield-halved text-xl animate-pulse"></i>
            </div>
            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full">Security</span>
        </div>
        <div>
            <div class="text-3xl font-heading font-bold text-gray-900 mb-1">EAL-4+</div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">Identity Assurance Layer</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- User Registry monitor -->
    <div class="lg:col-span-2 space-y-12" data-aos="fade-right">
        <div class="card-premium p-0 overflow-hidden shadow-premium bg-white">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
                <h3 class="text-xl font-bold tracking-tight font-heading">Recent Identity Protocols</h3>
                <a href="<?= APP_URL ?>/admin/users" class="text-[10px] font-bold text-primary uppercase tracking-[0.25em] hover:underline">Manage All Personnel</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading">Full Identity</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading text-center">Protocol Level</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading text-right">Synchronization</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if (empty($recentUsers)): ?>
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-200">
                                        <i class="fa-solid fa-users-slash text-4xl"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-1 font-heading uppercase tracking-widest">Registry Synchronized</h4>
                                    <p class="text-xs text-gray-400 italic font-medium leading-relaxed">No new personnel identities have recent protocol changes.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentUsers as $ru): ?>
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-primary/5 rounded-xl flex items-center justify-center text-primary font-bold shadow-soft group-hover:scale-110 transition-transform">
                                                <?= strtoupper(substr($ru['first_name'], 0, 1)) ?>
                                            </div>
                                            <div class="overflow-hidden">
                                                <div class="text-sm font-bold text-gray-900 truncate"><?= e($ru['first_name'] . ' ' . $ru['last_name']) ?></div>
                                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest truncate max-w-[150px] italic"><?= e($ru['email']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <?php 
                                            $roleClass = match($ru['role']) {
                                                'admin' => 'bg-purple-100 text-purple-700',
                                                'hod' => 'bg-primary text-white shadow-lg shadow-primary/20',
                                                'supervisor' => 'bg-emerald-100 text-emerald-700',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        ?>
                                        <span class="inline-block px-4 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest <?= $roleClass ?> transition-transform group-hover:translate-x-1">
                                            <?= $ru['role'] ?>
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest italic"><?= date('M d, Y', strtotime($ru['created_at'])) ?></div>
                                        <div class="text-[9px] font-bold text-emerald-500 uppercase tracking-tighter">Verified Integration</div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-gray-50/50 border-t border-gray-50 text-center">
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.5em]">Identity Control Protocol Layer Seven v1.0.1</span>
            </div>
        </div>
    </div>

    <!-- Right Sidebar Core Authority Tools -->
    <div class="space-y-10" data-aos="fade-left">
        <!-- Faculty Hub Governance -->
        <div class="p-10 card-premium bg-primary text-white border-none shadow-premium shadow-primary/30 relative group overflow-hidden active:scale-95 duration-200">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700 shadow-premium"></div>
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-white/20 rounded-[2rem] flex items-center justify-center text-white text-3xl mb-10 backdrop-blur-md border border-white/20 shadow-lg group-hover:rotate-12 duration-500">
                    <i class="fa-solid fa-sitemap"></i>
                </div>
                <h4 class="text-2xl font-bold mb-3 font-heading leading-tight italic tracking-tight">Faculty Architecture</h4>
                <p class="text-primary-100 text-[10px] font-bold uppercase tracking-widest opacity-80 leading-relaxed italic mb-10">Restructure Academic Divisions & Registry Clusters</p>
                <a href="<?= APP_URL ?>/admin/departments" class="w-full py-4 bg-white text-primary rounded-2xl text-[10px] font-bold uppercase tracking-[0.3em] transition-all hover:shadow-xl hover:translate-y-[-2px] active:translate-y-0">Execute Governance Hub</a>
            </div>
        </div>

        <!-- Global Directive Sync -->
        <div class="card-premium p-8 shadow-soft border-gray-100 bg-white group hover:shadow-premium duration-500 transition-all border-2">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-[1.5rem] flex items-center justify-center text-gray-400 mb-8 transition-transform group-hover:scale-110 group-hover:rotate-6 duration-500">
                    <i class="fa-solid fa-sliders text-2xl"></i>
                </div>
                <h4 class="text-sm font-bold mb-4 tracking-tight leading-tight uppercase text-gray-900 tracking-widest text-[10px] font-heading">Core System Schema</h4>
                <p class="text-xs text-gray-400 leading-relaxed italic mb-10 px-4">Modify institutional parameters, SMTP endpoints, and global archival snapshots.</p>
                <a href="<?= APP_URL ?>/admin/settings" class="w-full px-6 py-4 bg-gray-900 text-white rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all hover:bg-primary shadow-lg shadow-gray-200">Platform Synchronicity</a>
            </div>
        </div>

        <!-- System Intelligence monitor -->
        <div class="card-premium p-0 border-none bg-gray-50 shadow-soft overflow-hidden group">
            <div class="p-4 bg-gray-100/50 flex items-center justify-between">
                <span class="text-[9px] font-bold uppercase tracking-widest text-gray-400">Hub Intelligence Pulse</span>
                <i class="fa-solid fa-circle-nodes text-gray-200 group-hover:text-primary transition-colors"></i>
            </div>
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Network Throughput</span>
                    <span class="text-xs font-bold font-mono text-emerald-500 flex items-center gap-2 italic">Optimal <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></div></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Identity Sync Delay</span>
                    <span class="text-xs font-bold font-mono text-gray-900">0.08ms</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Data Integrity Check</span>
                    <span class="text-xs font-bold font-mono text-gray-900">Pass (SHA-256)</span>
                </div>
            </div>
        </div>
    </div>
</div>
