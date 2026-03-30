<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-file-import mr-3 text-blue-600"></i> Student Manifest Import</h1>
    <div class="flex gap-2">
        <a href="<?= APP_URL ?>/hod/groups" class="btn btn-sm">
            <i class="fa-solid fa-arrow-left mr-2 font-bold text-blue-600"></i> Return to Registry
        </a>
    </div>
</div>

<div class="max-w-md mx-auto animate-fade">
    <div class="card">
        <div class="card-header bg-gray-50/50">
            <h3 class="card-title text-sm uppercase text-gray-400 tracking-widest font-bold">Synchronize Registry</h3>
        </div>
        <div class="card-body p-8">
            <p class="text-xs text-gray-400 mb-8 leading-relaxed">
                Upload a structured CSV file to bulk-register students for the current academic session. 
                Accounts will be staged for activation and validation.
            </p>

            <form action="<?= APP_URL ?>/hod/upload-students" method="POST" enctype="multipart/form-data">
                <?= \App\Core\Session::csrfField() ?>
                
                <div class="border-2 border-dashed border-gray-100 rounded-lg p-10 text-center mb-8 bg-gray-50/30 hover:border-blue-300 hover:bg-blue-50 transition-all cursor-pointer group" onclick="document.getElementById('csv_file').click()">
                    <i class="fa-solid fa-cloud-arrow-up text-5xl text-gray-200 mb-4 group-hover:text-blue-600 transition-colors"></i>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-widest" id="file-label">Select Source Manifest</div>
                    <div class="text-[9px] text-gray-400 mt-2 font-mono italic">Expected: First Name, Last Name, Email, Index Number</div>
                    <input type="file" name="csv_file" id="csv_file" class="hidden" accept=".csv" onchange="updateLabel(this)">
                </div>

                <div class="bg-blue-50 border border-blue-100 p-4 rounded mb-8 flex items-start gap-4">
                    <i class="fa-solid fa-circle-info text-blue-600"></i>
                    <p class="text-[10px] text-blue-900 leading-tight">
                        <strong>Formatting Protocol:</strong> Ensure column headers match precisely. You may download our <a href="#" class="text-blue-600 font-bold hover:underline">Official CSV Template</a> for reference.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn btn-blue w-full p-3 font-bold uppercase tracking-widest text-[11px]">
                        Execute Batch Import
                    </button>
                    <a href="<?= APP_URL ?>/hod/groups" class="btn w-full p-3 font-bold uppercase tracking-widest text-[11px]">Discard Hub Action</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateLabel(input) {
    const label = document.getElementById('file-label');
    if (input.files.length > 0) {
        label.textContent = 'Ready: ' + input.files[0].name;
        label.classList.add('text-blue-600');
    } else {
        label.textContent = 'Select Source Manifest';
        label.classList.remove('text-blue-600');
    }
}
</script>
