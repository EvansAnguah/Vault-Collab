<div class="auth-form-header">
    <h2>Create Account</h2>
    <p>Join the project collaboration platform</p>
</div>

<form id="register-form" method="POST" action="<?= APP_URL ?>/register">
    <?= \App\Core\Session::csrfField() ?>

    <!-- Name Row -->
    <div class="form-row">
        <div class="form-group">
            <label class="form-label" for="first_name">First Name <span class="required">*</span></label>
            <input 
                type="text" 
                id="first_name" 
                name="first_name" 
                class="form-control" 
                placeholder="e.g. Kwame"
                value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"
                required
            >
        </div>
        <div class="form-group">
            <label class="form-label" for="last_name">Last Name <span class="required">*</span></label>
            <input 
                type="text" 
                id="last_name" 
                name="last_name" 
                class="form-control" 
                placeholder="e.g. Mensah"
                value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"
                required
            >
        </div>
    </div>

    <!-- Email (forced @st.rmu.edu.gh) -->
    <div class="form-group">
        <label class="form-label" for="email_username">Email Address <span class="required">*</span></label>
        <div class="email-forced-group">
            <div class="input-group" style="flex:1;">
                <input 
                    type="text" 
                    id="email_username" 
                    class="form-control" 
                    placeholder="e.g. kwame.mensah"
                    value="<?= htmlspecialchars(str_replace('@st.rmu.edu.gh', '', $_POST['email'] ?? '')) ?>"
                    required
                    autocomplete="username"
                >
                <span class="input-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </span>
            </div>
            <span class="email-domain">@st.rmu.edu.gh</span>
        </div>
        <input type="hidden" id="email" name="email" value="">
    </div>

    <!-- Index Number -->
    <div class="form-group">
        <label class="form-label" for="index_number">Index Number <span class="required">*</span></label>
        <div class="input-group">
            <input 
                type="text" 
                id="index_number" 
                name="index_number" 
                class="form-control" 
                placeholder="e.g. RMU/BSC/22/0001"
                value="<?= htmlspecialchars($_POST['index_number'] ?? '') ?>"
                required
            >
            <span class="input-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3"/><path d="M9 20h6"/><path d="M12 4v16"/></svg>
            </span>
        </div>
    </div>

    <!-- Department & Program -->
    <div class="form-row">
        <div class="form-group">
            <label class="form-label" for="department_id">Department <span class="required">*</span></label>
            <select id="department_id" name="department_id" class="form-control" required>
                <option value="">Select Department</option>
                <?php if (isset($departments) && is_array($departments)): ?>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>" <?= (isset($_POST['department_id']) && $_POST['department_id'] == $dept['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['name']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label" for="program_id">Program <span class="required">*</span></label>
            <select id="program_id" name="program_id" class="form-control" required disabled>
                <option value="">Select Department first</option>
            </select>
        </div>
    </div>

    <!-- Phone -->
    <div class="form-group">
        <label class="form-label" for="phone">Phone Number <span class="required">*</span></label>
        <div class="input-group">
            <input 
                type="tel" 
                id="phone" 
                name="phone" 
                class="form-control" 
                placeholder="e.g. 0241234567"
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                required
            >
            <span class="input-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </span>
        </div>
    </div>

    <!-- Password -->
    <div class="form-group">
        <label class="form-label" for="password">Password <span class="required">*</span></label>
        <div class="input-group">
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control" 
                placeholder="Minimum 8 characters"
                required
                minlength="8"
            >
            <span class="input-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </span>
            <button type="button" class="input-toggle" aria-label="Toggle password visibility">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
        <div class="password-strength">
            <div class="strength-bar">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <span class="strength-text"></span>
        </div>
    </div>

    <!-- Confirm Password -->
    <div class="form-group">
        <label class="form-label" for="confirm_password">Confirm Password <span class="required">*</span></label>
        <div class="input-group">
            <input 
                type="password" 
                id="confirm_password" 
                name="confirm_password" 
                class="form-control" 
                placeholder="Re-enter your password"
                required
            >
            <span class="input-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <button type="button" class="input-toggle" aria-label="Toggle password visibility">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
    </div>

    <!-- Terms & Conditions -->
    <div class="form-group terms-check">
        <div class="form-check">
            <input type="checkbox" id="accept_terms" name="accept_terms" value="1" required>
            <label for="accept_terms">
                I agree to the <a href="#" data-modal="terms-modal">Terms & Conditions</a>
            </label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg btn-block">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
        Create Account
    </button>

    <div class="auth-form-footer">
        <p>Already have an account? <a href="<?= APP_URL ?>/login">Sign In</a></p>
    </div>
</form>
