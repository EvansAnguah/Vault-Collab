<style>
/* Profile Layout Styles */
.profile-container {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
    align-items: start;
}

@media (max-width: 900px) {
    .profile-container {
        grid-template-columns: 1fr;
    }
}

.profile-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid var(--navy-100);
}

.profile-avatar-wrapper {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 1.5rem;
}

.profile-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.profile-avatar-placeholder {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: var(--ocean-blue);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    font-weight: 700;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.camera-btn-wrapper {
    position: absolute;
    bottom: 5px;
    right: 5px;
}

.camera-btn {
    background: var(--teal);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(20, 184, 166, 0.4);
    transition: transform 0.2s ease;
    border: 2px solid white;
}

.camera-btn:hover {
    transform: scale(1.1);
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--navy-900);
    margin-bottom: 0.5rem;
}

.profile-role {
    display: inline-block;
    padding: 6px 16px;
    background: var(--navy-100);
    color: var(--navy-700);
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.profile-details-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid var(--navy-100);
    overflow: hidden;
}

.nav-tabs {
    display: flex;
    background: #f8fafc;
    border-bottom: 1px solid var(--navy-100);
}

.nav-tab {
    padding: 1rem 2rem;
    font-weight: 600;
    color: var(--navy-600);
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.nav-tab.active {
    color: var(--ocean-blue);
    border-bottom-color: var(--ocean-blue);
    background: #fff;
}

.tab-pane {
    display: none;
    padding: 2rem;
}

.tab-pane.active {
    display: block;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

@media (max-width: 600px) {
    .form-row { grid-template-columns: 1fr; }
}

.readonly-input {
    background-color: #f1f5f9;
    cursor: not-allowed;
    color: #64748b;
}

.alert-info-box {
    background: #e0f2fe;
    border-left: 4px solid #0284c7;
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 4px;
    color: #0369a1;
    font-size: 0.9rem;
}
</style>

<div class="profile-container">
    
    <!-- LEFT SIDE: Photo & Bio -->
    <div class="profile-card">
        <form action="<?= APP_URL ?>/profile/upload-photo" method="POST" enctype="multipart/form-data" id="photo-form">
            <?= csrf_field() ?>
            <div class="profile-avatar-wrapper">
                <?php if ($user['profile_photo']): ?>
                    <img src="<?= APP_URL ?>/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Profile Photo" class="profile-avatar">
                <?php else: ?>
                    <div class="profile-avatar-placeholder">
                        <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
                    </div>
                <?php endif; ?>
                
                <label for="photo-upload" class="camera-btn-wrapper">
                    <div class="camera-btn" title="Change Photo">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </label>
                <input type="file" id="photo-upload" name="photo" accept="image/*" style="display: none;" onchange="document.getElementById('photo-form').submit();">
            </div>
        </form>

        <h2 class="profile-name"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h2>
        <div class="profile-role"><?= htmlspecialchars($user['role']) ?></div>
        
        <div style="margin-top: 2rem; text-align: left;">
            <p style="color: var(--navy-600); margin-bottom: 0.8rem;">
                <i class="fa-solid fa-envelope" style="width: 20px; color: var(--navy-400);"></i> 
                <?= htmlspecialchars($user['email']) ?>
            </p>
            <?php if ($user['index_number']): ?>
            <p style="color: var(--navy-600); margin-bottom: 0.8rem;">
                <i class="fa-solid fa-id-card" style="width: 20px; color: var(--navy-400);"></i> 
                <?= htmlspecialchars($user['index_number']) ?>
            </p>
            <?php endif; ?>
            <?php if ($user['department_id']): ?>
            <p style="color: var(--navy-600); margin-bottom: 0.8rem;">
                <i class="fa-solid fa-building" style="width: 20px; color: var(--navy-400);"></i> 
                <?= htmlspecialchars($departmentName) ?>
            </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- RIGHT SIDE: Forms -->
    <div class="profile-details-card">
        <div class="nav-tabs">
            <div class="nav-tab active" onclick="switchTab('personal', this)">Personal Info</div>
            <div class="nav-tab" onclick="switchTab('security', this)"><i class="fa-solid fa-lock"></i> Security</div>
        </div>

        <!-- Personal Info Tab -->
        <div id="tab-personal" class="tab-pane active">
            <div class="alert-info-box">
                <i class="fa-solid fa-circle-info"></i> Standard demographic fields (Name, Email, Student ID) are synchronized with the university registry and cannot be altered here.
            </div>

            <form action="<?= APP_URL ?>/profile/update" method="POST">
                <?= csrf_field() ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control readonly-input" value="<?= htmlspecialchars($user['first_name']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control readonly-input" value="<?= htmlspecialchars($user['last_name']) ?>" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>University Email</label>
                        <input type="email" class="form-control readonly-input" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Index Number</label>
                        <input type="text" class="form-control readonly-input" value="<?= htmlspecialchars($user['index_number'] ?? 'N/A') ?>" readonly>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--navy-100); margin: 2rem 0;">

                <div class="form-group" style="max-width: 50%;">
                    <label>Phone Number (Editable)</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="+233 ...">
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>

        <!-- Security Tab -->
        <div id="tab-security" class="tab-pane">
            <h3 style="margin-bottom: 1.5rem; color: var(--navy-800);">Change Password</h3>
            
            <form action="<?= APP_URL ?>/profile/change-password" method="POST">
                <?= csrf_field() ?>
                
                <div class="form-group" style="max-width: 400px;">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                
                <div class="form-group" style="max-width: 400px;">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" required minlength="8">
                    <small class="text-muted">Must be at least 8 characters.</small>
                </div>
                
                <div class="form-group" style="max-width: 400px;">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required minlength="8">
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-key"></i> Update Password</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function switchTab(tabId, element) {
    // Hide all tabs
    document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.nav-tab').forEach(nav => nav.classList.remove('active'));
    
    // Show selected
    document.getElementById('tab-' + tabId).classList.add('active');
    element.classList.add('active');
}
</script>
