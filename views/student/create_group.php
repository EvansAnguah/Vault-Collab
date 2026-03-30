<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-plus-circle mr-3 text-blue-600"></i> Form Research Group</h1>
    <div class="flex gap-2">
        <a href="<?= APP_URL ?>/student/group" class="btn btn-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> Cancel
        </a>
    </div>
</div>

<div class="max-w-md mx-auto animate-fade">
    <div class="card">
        <div class="card-header bg-gray-50/50">
            <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">New Identity</h3>
        </div>
        <div class="card-body p-8">
            <form method="POST" action="<?= APP_URL ?>/student/create-group">
                <?= \App\Core\Session::csrfField() ?>
                
                <div class="form-group mb-8">
                    <label class="form-label font-bold text-xs uppercase tracking-widest">Project Group Nomenclature <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="form-control p-3 border-2 focus:border-blue-600 focus:shadow-none" required placeholder="Ex: Maritime Logistics IoT Hub">
                    <p class="text-[10px] text-gray-400 mt-2 italic">You can refine this name during the research phase.</p>
                </div>

                <div class="bg-blue-50 border border-blue-100 p-4 rounded-lg mb-8 flex items-start gap-4">
                    <i class="fa-solid fa-crown text-amber-500 text-lg"></i>
                    <div>
                        <h4 class="text-xs font-bold text-blue-900 uppercase tracking-widest">Leadership Mandate</h4>
                        <p class="text-[10px] text-blue-800 leading-relaxed mt-1">
                            By initiating this group, you are assuming the role of **Principal Investigator (Leader)**. You will hold the exclusive authority to manage members and submit repository requests.
                        </p>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn btn-blue w-full p-3 font-bold uppercase tracking-widest text-[11px]">
                        <i class="fa-solid fa-check-circle mr-2"></i> Authorize Group Formation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
