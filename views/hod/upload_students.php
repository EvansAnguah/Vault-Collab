<div class="dashboard-header animate__animated animate__fadeIn">
    <div>
        <h1><i class="fa-solid fa-file-csv text-ocean-500"></i> Bulk Student Upload</h1>
        <p>Register multiple students for your department at once by uploading a CSV file.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp">
    <div class="lg:col-span-2 card bg-slate-800/20 border-slate-700/50">
        <div class="card-body">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-6">Select Student CSV</h3>
            
            <form method="POST" action="<?= APP_URL ?>/hod/upload-students" enctype="multipart/form-data">
                <?= \App\Core\Session::csrfField() ?>
                
                <div class="file-upload-dropzone p-12 border-2 border-dashed border-slate-700 rounded-3xl text-center mb-8 bg-black/20 hover:border-ocean-500/50 transition-all cursor-pointer">
                    <input type="file" name="csv_file" class="hidden" id="student_csv" required accept=".csv">
                    <label for="student_csv">
                        <i class="fa-solid fa-cloud-arrow-up text-5xl text-ocean-400 mb-4 block"></i>
                        <span class="text-sm text-slate-300 font-bold block mb-1">Click to Upload or Drag and Drop CSV</span>
                        <span class="text-[10px] text-slate-500 block">Required format: first_name, last_name, email, index_number</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn btn-primary px-8">Process Upload</button>
                    <a href="<?= APP_URL ?>/hod/groups" class="btn btn-ghost px-8">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-ocean-500/10 bg-ocean-500/5">
        <div class="card-body">
            <h3 class="text-xs font-bold uppercase tracking-widest text-ocean-400 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-info"></i> Format Guide
            </h3>
            <p class="text-[11px] text-slate-500 mb-4 leading-relaxed">
                The CSV file should not contain a header row. Each line must follow this exact order:
            </p>
            <div class="p-3 bg-black/40 rounded-xl border border-white/5 font-mono text-[10px] text-slate-300 mb-6">
                John,Doe,john@example.com,2024001<br>
                Jane,Smith,jane@example.com,2024002
            </div>
            <ul class="text-[10px] text-slate-500 space-y-3">
                <li class="flex items-center gap-2 italic"><i class="fa-solid fa-circle-check text-ocean-400"></i> Index numbers must be unique.</li>
                <li class="flex items-center gap-2 italic"><i class="fa-solid fa-circle-check text-ocean-400"></i> Students will be automatically assigned to your department.</li>
            </ul>
        </div>
    </div>
</div>

<script>
const fileInput = document.getElementById('student_csv');
const dropzone = document.querySelector('.file-upload-dropzone');

fileInput.onchange = () => {
    if(fileInput.files.length) {
        dropzone.classList.add('border-ocean-400', 'bg-ocean-400/5');
        dropzone.querySelector('span.text-sm').textContent = fileInput.files[0].name;
    }
}
</script>
