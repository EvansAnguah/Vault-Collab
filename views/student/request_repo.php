<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-paper-plane mr-3 text-blue-600"></i> Project Repository Proposal</h1>
    <div class="flex gap-2">
        <a href="<?= APP_URL ?>/student/group" class="btn btn-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Group
        </a>
    </div>
</div>

<div class="grid grid-cols-3 gap-8 animate-fade">
    <!-- Main Selection: Project Proposal Form -->
    <div class="col-span-2">
        <div class="card">
            <div class="card-header bg-gray-50/50">
                <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">Research Specifications</h3>
            </div>
            <div class="card-body p-8">
                <form method="POST" action="<?= APP_URL ?>/student/request-repo">
                    <?= \App\Core\Session::csrfField() ?>
                    
                    <div class="form-group mb-6">
                        <label class="form-label font-bold text-xs uppercase tracking-widest">Scientific Project Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" class="form-control p-3 border-2 focus:border-blue-600 focus:shadow-none" required placeholder="Ex: Machine Learning Applications in Maritime Logistics Optimization">
                    </div>

                    <div class="form-group mb-6">
                        <label class="form-label font-bold text-xs uppercase tracking-widest">Research Synopsis <span class="text-red-500">*</span></label>
                        <textarea name="description" class="form-control p-3 border-2 focus:border-blue-600 focus:shadow-none" rows="6" required placeholder="Provide a comprehensive abstract of your project objectives and technical approach."></textarea>
                    </div>

                    <div class="form-group mb-8">
                        <label class="form-label font-bold text-xs uppercase tracking-widest">Core Technical Objectives</label>
                        <textarea name="objectives" class="form-control p-3 border-2 focus:border-blue-600 focus:shadow-none" rows="4" placeholder="Highlight the primary goals of this research..."></textarea>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 p-6 rounded mb-8 flex items-start gap-4">
                        <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
                        <p class="text-[11px] text-blue-900 leading-relaxed">
                            <strong>Submission Notice:</strong> Your HOD will review this proposal. If approved, an academic supervisor will be assigned to your group and your technical repository will be initialized immediately.
                        </p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-blue w-full p-4 font-bold uppercase tracking-widest text-[11px]">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Transmit Proposal to Department Hub
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar: Guidelines & Progress -->
    <div class="space-y-6">
        <div class="card p-6 border-amber-100 bg-amber-50/20">
            <h4 class="text-[10px] font-bold uppercase text-amber-600 tracking-widest mb-4 flex items-center gap-2">
                <i class="fa-solid fa-lightbulb"></i> Strategic Advice
            </h4>
            <p class="text-xs text-gray-500 leading-relaxed italic">
                "Keep your title concise and focused. A well-articulated synopsis speeds up HOD approval times."
            </p>
        </div>

        <div class="card p-6">
            <h4 class="text-[10px] font-bold uppercase text-gray-400 tracking-widest mb-8">Academic Roadmap</h4>
            <div class="space-y-6 relative">
                <!-- Timeline Line -->
                <div class="absolute left-[13px] top-6 bottom-6 w-[2px] bg-gray-100"></div>
                
                <div class="relative flex items-center gap-4">
                    <div class="w-7 h-7 rounded-full bg-green-500 flex items-center justify-center text-white z-10">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-gray-900">Group Formation</span>
                        <span class="text-[9px] text-green-600 font-bold uppercase">Completed</span>
                    </div>
                </div>

                <div class="relative flex items-center gap-4">
                    <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-white z-10 shadow-lg shadow-blue-200">
                        <span class="text-[10px] font-bold">02</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-gray-900">Proposal Submission</span>
                        <span class="text-[9px] text-blue-600 font-bold uppercase animate-pulse">In Progress</span>
                    </div>
                </div>

                <div class="relative flex items-center gap-4 opacity-50">
                    <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 z-10">
                        <span class="text-[10px] font-bold">03</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-gray-800">Supervisor Assignment</span>
                        <span class="text-[9px] text-gray-400 font-bold uppercase">Pending</span>
                    </div>
                </div>

                <div class="relative flex items-center gap-4 opacity-50">
                    <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 z-10">
                        <span class="text-[10px] font-bold">04</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-gray-800">IDE Initialized</span>
                        <span class="text-[9px] text-gray-400 font-bold uppercase">Locked</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
