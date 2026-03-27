<div class="auth-form-header">
    <h2>Welcome Back</h2>
    <p>Sign in to continue to your workspace</p>
</div>

<form id="login-form" method="POST" action="<?= APP_URL ?>/login">
    <?= \App\Core\Session::csrfField() ?>

    <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <div class="input-group">
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control" 
                placeholder="your.name@st.rmu.edu.gh"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                required
                autocomplete="email"
            >
            <span class="input-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </span>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-group">
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control" 
                placeholder="Enter your password"
                required
                autocomplete="current-password"
            >
            <span class="input-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </span>
            <button type="button" class="input-toggle" aria-label="Toggle password visibility">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
    </div>

    <div class="auth-form-actions">
        <div class="form-check">
            <input type="checkbox" id="remember" name="remember" value="1">
            <label for="remember">Remember me</label>
        </div>
        <a href="<?= APP_URL ?>/forgot-password">Forgot password?</a>
    </div>

    <button type="submit" class="btn btn-primary btn-lg btn-block">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Sign In
    </button>

    <div class="divider">or</div>

    <a href="<?= APP_URL ?>/verify-account" class="btn btn-outline btn-block">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
        Uploaded Student? Verify Account
    </a>

    <div class="auth-form-footer">
        <p>Don't have an account? <a href="<?= APP_URL ?>/register">Create Account</a></p>
    </div>
</form>
