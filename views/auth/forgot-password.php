<div class="auth-form-header">
    <h2>Forgot Password?</h2>
    <p>Enter your email and we'll send you a reset link</p>
</div>

<form id="forgot-form" method="POST" action="<?= APP_URL ?>/forgot-password">
    <?= \App\Core\Session::csrfField() ?>

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

    <button type="submit" class="btn btn-primary btn-lg btn-block">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        Send Reset Link
    </button>

    <div class="auth-form-footer">
        <p>Remember your password? <a href="<?= APP_URL ?>/login">Sign In</a></p>
    </div>
</form>
