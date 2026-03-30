<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-user-circle mr-3 text-blue-600"></i> My Academic Profile</h1>
</div>

<div class="grid grid-cols-3 gap-8 animate-fade">
    <!-- Left: Identity Overview -->
    <div class="col-span-1 space-y-6">
        <div class="card p-8 text-center pt-12">
            <form action="<?= APP_URL ?>/profile/upload-photo" method="POST" enctype="multipart/form-data" id="photo-form">
                <?= \App\Core\Session::csrfField() ?>
                <div class="relative w-32 h-32 mx-auto mb-6 group">
                    <?php if ($user['profile_photo']): ?>
                        <img src="<?= APP_URL ?>/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Profile Photo" class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg shadow-gray-200">
                    <?php else: ?>
                        <div class="w-full h-full rounded-full bg-blue-600 flex items-center justify-center text-4xl font-bold text-white shadow-lg">
                            <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    
                    <label for="photo-upload" class="absolute bottom-1 right-1 w-8 h-8 bg-white rounded-full border border-gray-200 flex items-center justify-center cursor-pointer hover:bg-gray-50 shadow-sm transition-all">
                        <i class="fa-solid fa-camera text-blue-600 text-xs"></i>
                    </label>
                    <input type="file" id="photo-upload" name="photo" accept="image/*" class="hidden" onchange="document.getElementById('photo-form').submit();">
                </div>
            </form>

            <h2 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h2>
            <div class="badge badge-info uppercase text-[10px] mt-2 border-transparent font-bold tracking-widest"><?= htmlspecialchars($user['role']) ?></div>
            
            <div class="mt-8 pt-8 border-t border-gray-50 text-left space-y-3">
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <i class="fa-solid fa-envelope w-4 text-blue-300"></i>
                    <span><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <?php if ($user['index_number']): ?>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <i class="fa-solid fa-id-card w-4 text-blue-300"></i>
                    <span><?= htmlspecialchars($user['index_number']) ?></span>
                </div>
                <?php endif; ?>
                <?php if ($user['department_id']): ?>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <i class="fa-solid fa-building-columns w-4 text-blue-300"></i>
                    <span><?= htmlspecialchars($departmentName ?? 'Department assigned') ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card p-6 border-blue-50 bg-blue-50/20">
            <h4 class="text-[10px] font-bold uppercase text-gray-400 tracking-widest mb-4">Account Integrity</h4>
            <div class="flex gap-3">
                <i class="fa-solid fa-shield-check text-green-600 text-sm mt-0.5"></i>
                <p class="text-[11px] text-gray-600 leading-relaxed">Your account is active and verified within the Regional Maritime University project directory.</p>
            </div>
        </div>
    </div>

    <!-- Right: Management Panels -->
    <div class="col-span-2 space-y-8">
        <div class="card">
            <div class="card-header flex bg-gray-50/50 p-0">
                <button class="px-8 py-4 text-xs font-bold uppercase tracking-widest border-b-2 border-blue-600 text-blue-600" id="tab-btn-personal" onclick="switchTab('personal')">Identity Details</button>
                <button class="px-8 py-4 text-xs font-bold uppercase tracking-widest border-b-2 border-transparent text-gray-400 hover:text-gray-900 transition-colors" id="tab-btn-security" onclick="switchTab('security')">Platform Security</button>
            </div>
            
            <!-- Personal Panel -->
            <div class="card-body p-8" id="panel-personal">
                <div class="bg-blue-50 border border-blue-100 p-4 rounded mb-8 flex gap-4">
                    <i class="fa-solid fa-circle-info text-blue-500"></i>
                    <p class="text-[11px] text-blue-900 leading-relaxed">
                        Core academic data as registered in the university system cannot be edited here. For corrections, please contact the Registry.
                    </p>
                </div>

                <form action="<?= APP_URL ?>/profile/update" method="POST" class="space-y-6">
                    <?= \App\Core\Session::csrfField() ?>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label font-bold text-xs">First Name</label>
                            <input type="text" class="form-control bg-gray-50 cursor-not-allowed" value="<?= htmlspecialchars($user['first_name']) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label font-bold text-xs">Last Name</label>
                            <input type="text" class="form-control bg-gray-50 cursor-not-allowed" value="<?= htmlspecialchars($user['last_name']) ?>" readonly>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label font-bold text-xs">Institutional Email</label>
                            <input type="email" class="form-control bg-gray-50 cursor-not-allowed" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label font-bold text-xs">Student Index Number</label>
                            <input type="text" class="form-control bg-gray-50 cursor-not-allowed" value="<?= htmlspecialchars($user['index_number'] ?? 'N/A') ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group max-w-sm pt-4 border-t border-gray-50">
                        <label class="form-label font-bold text-xs">Communication Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="+233 ...">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-blue px-10 font-bold uppercase tracking-widest text-[10px]">Update Profile</button>
                    </div>
                </form>
            </div>

            <!-- Security Panel (Hidden by default) -->
            <div class="card-body p-8 hidden" id="panel-security">
                <div class="max-w-md">
                    <h3 class="text-sm font-bold text-gray-900 mb-6">Modify Credentials</h3>
                    <form action="<?= APP_URL ?>/profile/change-password" method="POST" class="space-y-4">
                        <?= \App\Core\Session::csrfField() ?>
                        
                        <div class="form-group">
                            <label class="form-label font-bold text-xs">Current Secret Key</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label font-bold text-xs">New Secure Password</label>
                            <input type="password" name="new_password" class="form-control" required minlength="8">
                            <p class="text-[9px] text-gray-400 mt-2 font-bold uppercase">Requirement: Minimum 8 characters</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label font-bold text-xs">Confirm New Secret Key</label>
                            <input type="password" name="confirm_password" class="form-control" required minlength="8">
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="btn btn-primary px-8 font-bold uppercase tracking-widest text-[10px]">Update Security Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabId) {
    // Hide all
    document.getElementById('panel-personal').classList.add('hidden');
    document.getElementById('panel-security').classList.add('hidden');
    document.getElementById('tab-btn-personal').classList.remove('border-blue-600', 'text-blue-600');
    document.getElementById('tab-btn-security').classList.remove('border-blue-600', 'text-blue-600');
    document.getElementById('tab-btn-personal').classList.add('border-transparent', 'text-gray-400');
    document.getElementById('tab-btn-security').classList.add('border-transparent', 'text-gray-400');

    // Show select
    document.getElementById('panel-' + tabId).classList.remove('hidden');
    document.getElementById('tab-btn-' + tabId).classList.add('border-blue-600', 'text-blue-600');
    document.getElementById('tab-btn-' + tabId).classList.remove('border-transparent', 'text-gray-400');
}
</script>
