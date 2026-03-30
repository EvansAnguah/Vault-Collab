<div class="mb-12 animate__animated animate__fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 text-center md:text-left">
        <div>
            <div class="flex items-center gap-3 mb-4 justify-center md:justify-start">
                <a href="<?= APP_URL ?>/dashboard" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-primary transition-colors">Registry Hub</a>
                <span class="text-gray-200">/</span>
                <span class="text-primary text-[10px] font-bold uppercase tracking-widest">Platform Identity Protocols</span>
            </div>
            <h1 class="text-4xl font-heading font-bold tracking-tight text-gray-900 leading-tight">System Preferences</h1>
        </div>
        <div class="w-14 h-14 bg-white shadow-soft rounded-2xl flex items-center justify-center border border-gray-100 font-heading text-xl font-bold text-primary italic transition-transform hover:scale-105 duration-300 mx-auto md:mx-0">
            <i class="fa-solid fa-sliders"></i>
        </div>
    </div>
</div>

<div class="max-w-2xl mx-auto space-y-12" data-aos="fade-up">
    <!-- Configuration Core -->
    <div class="card-premium p-0 overflow-hidden shadow-premium bg-white border-none group relative">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full group-hover:scale-125 transition-transform duration-1000"></div>
        
        <div class="p-10 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
            <h3 class="text-xs font-bold uppercase tracking-[0.25em] text-gray-400 font-heading">Institutional Configuration Schema</h3>
            <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest border border-emerald-100 px-3 py-1 rounded-full bg-emerald-50 animate-pulse">Sync Active</span>
        </div>

        <form action="<?= APP_URL ?>/settings/update" method="POST">
            <?= \App\Core\Session::csrfField() ?>
            <div class="p-10 space-y-10 relative z-10">
                
                <!-- Communications Protocol -->
                <section class="space-y-8">
                    <h4 class="text-[10px] font-bold uppercase text-primary tracking-[0.3em] mb-6 border-b border-gray-50 pb-5 italic">Communications Layer</h4>
                    
                    <div class="flex items-center justify-between gap-10">
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-gray-900 mb-1 font-heading tracking-tight">Institutional Email Dispatch</h5>
                            <p class="text-xs text-gray-400 font-medium italic opacity-80 leading-relaxed uppercase tracking-tighter">Receive automated sync alerts for project status changes and mentorship assignments.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer group/toggle">
                            <input type="checkbox" name="email_notifications" value="1" <?= ($settings['email_notifications'] == '1') ? 'checked' : '' ?> class="sr-only peer">
                            <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary shadow-soft group-hover/toggle:scale-105 duration-200"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between gap-10 opacity-60 grayscale group/disabled cursor-not-allowed">
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-gray-900 mb-1 font-heading tracking-tight">Real-Time Hub Pings</h5>
                            <p class="text-xs text-gray-400 font-medium italic opacity-80 leading-relaxed uppercase tracking-tighter">Live interface notifications for incoming collaborative discussion artifacts.</p>
                        </div>
                        <div class="w-14 h-8 bg-gray-100 rounded-full relative shadow-inner">
                            <div class="absolute top-[4px] left-[4px] bg-white border border-gray-200 rounded-full h-6 w-6"></div>
                        </div>
                    </div>
                </section>

                <div class="h-px bg-gradient-to-r from-transparent via-gray-100 to-transparent"></div>

                <!-- Academic Presence -->
                <section class="space-y-8">
                    <h4 class="text-[10px] font-bold uppercase text-gray-400 tracking-[0.3em] mb-6 border-b border-gray-50 pb-5 italic">Institutional Visibility</h4>
                    
                    <div class="flex items-center justify-between gap-10">
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-gray-900 mb-1 font-heading tracking-tight">Hub Registry Discovery</h5>
                            <p class="text-xs text-gray-400 font-medium italic opacity-80 leading-relaxed uppercase tracking-tighter">Expose your institutional identity credentials in group search registries for team building.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer group/toggle">
                            <input type="checkbox" name="show_email_to_students" value="1" <?= ($settings['show_email_to_students'] == '1') ? 'checked' : '' ?> class="sr-only peer">
                            <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500 shadow-soft group-hover/toggle:scale-105 duration-200"></div>
                        </label>
                    </div>
                </section>

                <div class="h-px bg-gradient-to-r from-transparent via-gray-100 to-transparent"></div>

                <!-- System Interface -->
                <section class="space-y-8">
                    <h4 class="text-[10px] font-bold uppercase text-gray-400 tracking-[0.3em] mb-6 border-b border-gray-50 pb-5 italic">Tactical Interface</h4>
                    
                    <div class="flex items-center justify-between gap-10">
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-gray-900 mb-1 font-heading tracking-tight">High Contrast Integrity</h5>
                            <p class="text-xs text-gray-400 font-medium italic opacity-80 leading-relaxed uppercase tracking-tighter">Force maximum fidelity and accessibility protocols across all platform dashboard modules.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer group/toggle">
                            <input type="checkbox" name="dark_mode" value="1" <?= ($settings['dark_mode'] == '1') ? 'checked' : '' ?> class="sr-only peer">
                            <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-amber-500 shadow-soft group-hover/toggle:scale-105 duration-200"></div>
                        </label>
                    </div>
                </section>

                <div class="pt-10 flex flex-col items-center">
                    <button type="submit" class="w-full py-5 bg-gray-900 border border-gray-800 text-white rounded-[2.5rem] text-[11px] font-bold uppercase tracking-[0.25em] transition-all hover:bg-primary shadow-xl hover:shadow-primary/30 active:scale-95 duration-200">
                        Commit Global Preferences
                    </button>
                    <p class="mt-8 text-[9px] text-gray-400 font-bold uppercase tracking-widest text-center">Version: 1.2.0-STABLE | Node Registry: RMU-HUB-01-SYNC</p>
                </div>
            </div>
        </form>
    </div>

    <!-- Security Overlay -->
    <div class="p-10 card-premium border-none bg-emerald-50 flex items-center justify-between group active:scale-95 transition-transform cursor-pointer shadow-premium shadow-emerald-500/5">
        <div class="flex items-center gap-6">
            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-emerald-500 shadow-soft transition-transform group-hover:rotate-12">
                <i class="fa-solid fa-key text-xl"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-700 block mb-1">Encrypted Identity Sync</span>
                <p class="text-[9px] text-emerald-600 font-medium italic opacity-70 uppercase tracking-tighter">Last Synchronization: Today 18:42:01 MS-UTC</p>
            </div>
        </div>
        <i class="fa-solid fa-fingerprint text-emerald-200 text-4xl opacity-50"></i>
    </div>
</div>
