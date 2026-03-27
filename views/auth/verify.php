<div class="auth-form-header">
    <h2>Verify Your Account</h2>
    <p>For students whose information was uploaded by Admin or HOD</p>
</div>

<div class="verify-steps">
    <div class="verify-step <?= isset($step) && $step >= 1 ? 'active' : '' ?> <?= isset($step) && $step > 1 ? 'completed' : '' ?>">
        1. Verify Identity
    </div>
    <div class="verify-step <?= isset($step) && $step >= 2 ? 'active' : '' ?>">
        2. Create Password
    </div>
</div>

<?php if (!isset($step) || $step === 1): ?>
<!-- Step 1: Verify Identity -->
<form id="verify-form" method="POST" action="<?= APP_URL ?>/verify-account">
    <?= \App\Core\Session::csrfField() ?>
    <input type="hidden" name="step" value="1">

    <div class="form-group">
        <label class="form-label" for="email">Email Address <span class="required">*</span></label>
        <div class="input-group">
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control" 
                placeholder="your.name@st.rmu.edu.gh"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                required
            >
            <span class="input-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </span>
        </div>
    </div>

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

    <button type="submit" class="btn btn-primary btn-lg btn-block">
        Verify Identity
    </button>
</form>

<?php else: ?>
<!-- Step 2: Create Password -->
<form id="verify-form" method="POST" action="<?= APP_URL ?>/verify-account">
    <?= \App\Core\Session::csrfField() ?>
    <input type="hidden" name="step" value="2">
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($verifiedUser['id'] ?? '') ?>">

    <div class="alert alert-success">
        <span>✓</span>
        <span>Identity verified! Welcome, <strong><?= htmlspecialchars(($verifiedUser['first_name'] ?? '') . ' ' . ($verifiedUser['last_name'] ?? '')) ?></strong>. Create your password below.</span>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">New Password <span class="required">*</span></label>
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
            <button type="button" class="input-toggle">
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
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg btn-block">
        Set Password & Activate Account
    </button>
</form>
<?php endif; ?>

<div class="auth-form-footer">
    <p>Already have a password? <a href="<?= APP_URL ?>/login">Sign In</a></p>
</div>
