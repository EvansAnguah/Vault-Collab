<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-file-csv text-ocean-500"></i> Bulk Student Upload</h1>
        <p>Register multiple students at once by uploading a formatted CSV file.</p>
    </div>
    <div class="header-actions">
        <a href="<?= APP_URL ?>/admin/users?role=student" class="btn btn-ghost btn-sm"><i class="fa-solid fa-arrow-left"></i> Back to Students</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate__animated animate__fadeInUp">
    <!-- Upload Section -->
    <div class="card bg-slate-800/20 border-slate-700/50">
        <div class="card-body">
            <h3 class="text-lg font-bold text-slate-100 flex items-center gap-2 mb-6">
                <i class="fa-solid fa-upload text-ocean-400"></i> Upload CSV File
            </h3>
            
            <form method="POST" action="<?= APP_URL ?>/admin/upload-students" enctype="multipart/form-data">
                <?= \App\Core\Session::csrfField() ?>
                
                <div class="upload-zone border-2 border-dashed border-slate-700 rounded-xl p-8 text-center transition-all hover:border-ocean-500/50 hover:bg-slate-800/10 cursor-pointer mb-6"
                     onclick="document.getElementById('csv-input').click()">
                    <i class="fa-solid fa-cloud-arrow-up text-5xl text-slate-600 mb-4 transition-colors"></i>
                    <p class="text-sm text-slate-400 mb-2">Click to browse or drag and drop your CSV file here.</p>
                    <p class="text-[10px] text-slate-600 uppercase tracking-widest font-bold">Max Size: 5MB</p>
                    <input type="file" id="csv-input" name="student_csv" class="hidden" accept=".csv" onchange="updateFileName(this)">
                    <div id="file-name" class="mt-4 text-xs font-bold text-ocean-400"></div>
                </div>

                <button type="submit" class="btn btn-primary w-full py-4 shadow-lg shadow-ocean-500/20">
                    <i class="fa-solid fa-bolt"></i> Process Batch Upload
                </button>
            </form>
        </div>
    </div>

    <!-- Instructions Section -->
    <div class="card bg-slate-900/40 border-slate-800">
        <div class="card-body">
            <h3 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-ocean-400"></i> CSV Format Instructions
            </h3>
            
            <p class="text-sm text-slate-400 mb-6 font-medium leading-relaxed">Your CSV file must follow a specific column order to be correctly processed. If a department code does not match a system code (e.g. CS, EE, MS), the student will be skipped.</p>

            <div class="bg-black/40 rounded-lg p-4 font-mono text-[11px] text-slate-500 border border-slate-800 mb-6 overflow-x-auto whitespace-nowrap">
                <span class="text-ocean-400 font-bold uppercase tracking-tighter">first_name, last_name, email, index_number, department_code</span><br>
                John,Doe,jdoe123@rmu.edu.gh,20231234,CS<br>
                Jane,Smith,jsmith456@rmu.edu.gh,20235678,EE
            </div>

            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Required Data Columns:</h4>
            <ul class="space-y-3">
                <li class="flex items-start gap-2 text-sm text-slate-400">
                    <i class="fa-solid fa-check text-ocean-500 mt-1"></i>
                    <span><strong>first_name & last_name</strong>: Required for identity.</span>
                </li>
                <li class="flex items-start gap-2 text-sm text-slate-400">
                    <i class="fa-solid fa-check text-ocean-500 mt-1"></i>
                    <span><strong>email</strong>: Must be unique and a valid RMU institutional email.</span>
                </li>
                <li class="flex items-start gap-2 text-sm text-slate-400">
                    <i class="fa-solid fa-check text-ocean-500 mt-1"></i>
                    <span><strong>index_number</strong>: Numeric ID from the university database.</span>
                </li>
                <li class="flex items-start gap-2 text-sm text-slate-400">
                    <i class="fa-solid fa-check text-ocean-500 mt-1"></i>
                    <span><strong>department_code</strong>: Use the short system codes (e.g. CS, EE, MAR, LA).</span>
                </li>
            </ul>

            <div class="mt-8 pt-4 border-t border-slate-800">
                <a href="#" class="text-xs font-bold text-ocean-400 flex items-center gap-2 hover:translate-x-1 transition-transform">
                    <i class="fa-solid fa-download"></i> Download Sample CSV Template
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileNameDiv = document.getElementById('file-name');
    if (input.files.length > 0) {
        fileNameDiv.innerHTML = '<i class="fa-solid fa-file-circle-check"></i> ' + input.files[0].name;
    }
}
</script>

<style>
.upload-zone:hover i {
    color: var(--ocean-400);
}
</style>
