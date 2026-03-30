<div class="space-y-12 animate__animated animate__fadeIn">
    <div class="text-center">
        <h2 class="text-3xl font-heading font-bold text-gray-900 mb-3 tracking-tight italic uppercase">Identity Discovery</h2>
        <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.25em] leading-relaxed italic">Synchronize New Personnel Profile</p>
    </div>

    <form action="<?= APP_URL ?>/register" method="POST" class="space-y-8">
        <?= \App\Core\Session::csrfField() ?>
        
        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-4">
                <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest px-2">First Name</label>
                <input type="text" name="first_name" class="input-premium" placeholder="Given Identity" required autofocus>
            </div>
            <div class="space-y-4">
                <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest px-2">Last Name</label>
                <input type="text" name="last_name" class="input-premium" placeholder="Family Registry" required>
            </div>
        </div>

        <div class="space-y-4">
            <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest px-2">Institutional Email</label>
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors">
                    <i class="fa-solid fa-at text-lg"></i>
                </div>
                <input type="email" name="email" class="input-premium pl-12" placeholder="Official Access Email" required>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-4">
                <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest px-2">Access Key</label>
                <input type="password" name="password" class="input-premium" placeholder="Secret Token" required>
            </div>
            <div class="space-y-4">
                <label class="text-[9px] font-bold text-gray-400 uppercase tracking-widest px-2">Confirmation</label>
                <input type="password" name="password_confirmation" class="input-premium" placeholder="Re-Verify Key" required>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border border-gray-100 rounded-[2rem] flex flex-col items-center gap-6 group hover:border-primary/20 transition-all duration-500 shadow-soft">
            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-2 italic">Institutional Personnel Category</span>
            <div class="flex flex-wrap justify-center gap-8 px-4">
                <label class="flex flex-col items-center gap-3 cursor-pointer group active:scale-95 transition-transform duration-200">
                    <input type="radio" name="role" value="student" checked class="w-5 h-5 rounded-lg border-gray-200 text-primary">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-primary transition-colors">Student</span>
                </label>
                <label class="flex flex-col items-center gap-3 cursor-pointer group active:scale-95 transition-transform duration-200">
                    <input type="radio" name="role" value="supervisor" class="w-5 h-5 rounded-lg border-gray-200 text-emerald-600">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-emerald-600 transition-colors">Faculty</span>
                </label>
                <label class="flex flex-col items-center gap-3 cursor-pointer group active:scale-95 transition-transform duration-200">
                    <input type="radio" name="role" value="hod" class="w-5 h-5 rounded-lg border-gray-200 text-amber-600">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest group-hover:text-amber-600 transition-colors">HOD</span>
                </label>
            </div>
        </div>

        <button type="submit" class="w-full py-5 bg-primary text-white rounded-[2rem] font-bold shadow-xl shadow-primary/30 transition-all hover:shadow-2xl hover:-translate-y-1 active:translate-y-0 active:shadow-lg uppercase tracking-[0.2em] text-[11px] mb-8">
            Create Personnel Identity
        </button>
    </form>

    <div class="pt-10 border-t border-gray-50 text-center">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 italic leading-relaxed font-heading">Already Verified in the Hub Registry?</p>
        <a href="<?= APP_URL ?>/login" class="inline-flex items-center gap-3 px-10 py-4 bg-gray-100 border border-gray-100 text-gray-900 rounded-3xl font-bold text-[10px] uppercase tracking-widest hover:bg-white hover:border-primary/20 hover:-translate-y-1 shadow-soft transition-all active:translate-y-0">
            <i class="fa-solid fa-lock text-primary"></i> Proceed to Login
        </a>
    </div>
</div>
