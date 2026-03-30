<div class="space-y-10 animate__animated animate__fadeIn">
    <div class="text-center">
        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-3 tracking-tight italic uppercase">Personnel Access</h2>
        <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.25em] leading-relaxed italic">Enter Identity Credentials to Synchronize</p>
    </div>

    <form action="<?= APP_URL ?>/login" method="POST" class="space-y-8">
        <?= \App\Core\Session::csrfField() ?>
        
        <div class="space-y-4">
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors">
                    <i class="fa-solid fa-at text-lg"></i>
                </div>
                <input type="email" name="email" class="input-premium pl-12" placeholder="Official Institutional Email" required autofocus>
            </div>

            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors">
                    <i class="fa-solid fa-shield-halved text-lg"></i>
                </div>
                <input type="password" name="password" class="input-premium pl-12" placeholder="Secret Access Key" required>
            </div>
        </div>

        <div class="flex items-center justify-between px-2">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-gray-200 text-primary focus:ring-primary/20 transition-all">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest group-hover:text-gray-600 transition-colors">Persistent Session</span>
            </label>
            <a href="<?= APP_URL ?>/forgot-password" class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline decoration-2 underline-offset-4">Reset Key</a>
        </div>

        <button type="submit" class="w-full py-5 bg-primary text-white rounded-[2rem] font-bold shadow-xl shadow-primary/30 transition-all hover:shadow-2xl hover:-translate-y-1 active:translate-y-0 active:shadow-lg uppercase tracking-[0.2em] text-[11px]">
            Execute Authorization
        </button>
    </form>

    <div class="pt-10 border-t border-gray-50 text-center">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 italic leading-relaxed">Not Registered in the Registry Hub?</p>
        <a href="<?= APP_URL ?>/register" class="inline-flex items-center gap-3 px-10 py-4 bg-gray-50 border border-gray-100 text-gray-900 rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-white hover:border-primary/20 hover:-translate-y-1 shadow-soft transition-all active:translate-y-0">
            <i class="fa-solid fa-user-plus text-primary"></i> Create Personnel Identity
        </a>
    </div>
</div>
