<h2 class="text-lg font-bold mb-6 text-center">Reset your password</h2>

<p class="text-sm text-gray-600 mb-8 text-center leading-relaxed">
    Enter your registered student email address and we will send you a reset link.
</p>

<form method="POST" action="<?= APP_URL ?>/forgot-password">
    <?= \App\Core\Session::csrfField() ?>
    
    <div class="form-group">
        <label class="form-label text-sm">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="index@st.rmu.edu.gh" required autofocus>
    </div>

    <button type="submit" class="btn btn-primary w-full mt-4">
        Send Reset Link
    </button>
</form>

<div class="mt-8 pt-4 border-t border-gray-100 text-center">
    <p class="text-xs text-gray-500">
        Changed your mind? <a href="<?= APP_URL ?>/login" class="text-blue-600 font-bold hover:underline">Return to Login</a>
    </p>
</div>
