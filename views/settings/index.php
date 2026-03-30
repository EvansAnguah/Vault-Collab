<style>
.settings-container {
    max-width: 800px;
    margin: 0 auto;
}

.settings-card {
    background: #fff;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid var(--navy-100);
}

.settings-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--navy-100);
}

.settings-header h1 {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--navy-900);
    margin: 0;
}

.settings-group {
    margin-bottom: 2rem;
}

.settings-group h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--navy-800);
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.2rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.setting-item:last-child {
    border-bottom: none;
}

.setting-info h4 {
    margin: 0 0 0.3rem 0;
    font-size: 1.1rem;
    color: var(--navy-900);
    font-weight: 600;
}

.setting-info p {
    margin: 0;
    color: var(--navy-500);
    font-size: 0.9rem;
}

/* Custom Toggle Switch */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input { 
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e1;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

input:checked + .slider {
    background-color: var(--teal);
}

input:focus + .slider {
    box-shadow: 0 0 1px var(--teal);
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>

<div class="settings-container">
    <div class="settings-card">
        <div class="settings-header">
            <h1><i class="fa-solid fa-gear"></i> Preferences</h1>
            <p class="text-muted" style="margin-top: 0.5rem;">Customize your Hub experience.</p>
        </div>

        <form action="<?= APP_URL ?>/settings/update" method="POST">
            <?= csrf_field() ?>

            <!-- Notifications -->
            <div class="settings-group">
                <h3><i class="fa-solid fa-bell"></i> Notifications</h3>
                
                <div class="setting-item">
                    <div class="setting-info">
                        <h4>Email Alerts</h4>
                        <p>Receive emails when added to a group or assigned a task.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="email_notifications" value="1" <?= ($settings['email_notifications'] == '1') ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <!-- Appearance -->
            <div class="settings-group">
                <h3><i class="fa-solid fa-palette"></i> Appearance</h3>
                
                <div class="setting-item">
                    <div class="setting-info">
                        <h4>Dark Mode</h4>
                        <p>Toggle system theme (Note: implementation may require a page reload).</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="dark_mode" value="1" <?= ($settings['dark_mode'] == '1') ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <!-- Privacy -->
            <div class="settings-group">
                <h3><i class="fa-solid fa-shield-halved"></i> Privacy</h3>
                
                <div class="setting-item">
                    <div class="setting-info">
                        <h4>Directory Visibility</h4>
                        <p>Allow other students to see your email in the student lookup directory.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="show_email_to_students" value="1" <?= ($settings['show_email_to_students'] == '1') ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <div style="margin-top: 3rem; text-align: right; border-top: 1px solid #f1f5f9; padding-top: 1.5rem;">
                <button type="submit" class="btn btn-primary btn-lg" style="padding: 12px 30px;">
                    <i class="fa-solid fa-save"></i> Save Preferences
                </button>
            </div>
        </form>
    </div>
</div>
