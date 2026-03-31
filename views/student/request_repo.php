<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-rocket text-ocean-500"></i> Request Project Repository</h1>
        <p>Propose your project title and objectives to the HOD for approval and supervisor assignment.</p>
    </div>
    <div class="header-actions">
        <a href="<?= APP_URL ?>/student/group" class="btn btn-ghost btn-sm"><i class="fa-solid fa-arrow-left"></i> Back to My Group</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate__animated animate__fadeInUp">
    <!-- Form Section -->
    <div class="md:col-span-2 card bg-slate-800/20 border-slate-700/50">
        <div class="card-body">
            <form method="POST" action="<?= APP_URL ?>/student/request-repo">
                <?= \App\Core\Session::csrfField() ?>
                
                <div class="form-group mb-6">
                    <label class="form-label font-bold text-slate-100">Project Title <span class="text-rose-500">*</span></label>
                    <div class="input-group">
                        <i class="fa-solid fa-heading input-icon"></i>
                        <input type="text" name="title" class="form-control" required placeholder="Ex: Development of an IoT-based Smart Grid for RMU">
                    </div>
                </div>

                <div class="form-group mb-6">
                    <label class="form-label font-bold text-slate-100">Project Description <span class="text-rose-500">*</span></label>
                    <textarea name="description" class="form-control" rows="5" required placeholder="Provide a detailed overview of your research problem and proposed solution."></textarea>
                </div>

                <div class="form-group mb-8">
                    <label class="form-label font-bold text-slate-100">Specific Objectives</label>
                    <textarea name="objectives" class="form-control" rows="4" placeholder="List the core goals of your project."></textarea>
                </div>

                <div class="bg-black/20 p-6 rounded-xl border border-slate-700/50 mb-8">
                    <div class="flex items-start gap-4">
                        <i class="fa-solid fa-circle-info text-ocean-400 mt-1"></i>
                        <div>
                            <h4 class="text-sm font-bold text-slate-100">HOD Review Process</h4>
                            <p class="text-xs text-slate-400 mt-1">Once submitted, your HOD will review your project title. If approved, a repository will be created and a Supervisor will be assigned to your group to guide you through the process.</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full py-4 text-base shadow-lg shadow-ocean-500/20">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Submit Proposal to HOD
                </button>
            </form>
        </div>
    </div>

    <!-- Instruction Column -->
    <div class="space-y-6">
        <div class="card border-amber-500/10 bg-amber-500/5">
            <div class="card-body">
                <h3 class="text-sm font-bold uppercase tracking-widest text-amber-400 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-lightbulb"></i> Pro Tip
                </h3>
                <p class="text-xs text-slate-400 leading-relaxed">Ensure your project title is clear and concise. A well-defined description significantly increases your chance of immediate approval without revisions.</p>
            </div>
        </div>

        <div class="card bg-slate-900 border-slate-800">
            <div class="card-body">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4">Phase Progress</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs">1</div>
                        <span class="text-xs text-slate-200">Form Group</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-ocean-500 flex items-center justify-center text-white text-bold animate-pulse shadow-glow">2</div>
                        <span class="text-xs text-slate-100 font-bold">Submit Proposal</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-600 text-xs">3</div>
                        <span class="text-xs text-slate-600">Supervisor Assignment</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-600 text-xs">4</div>
                        <span class="text-xs text-slate-600">Start Research</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
