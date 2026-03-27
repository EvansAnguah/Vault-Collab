/**
 * Auth Pages JavaScript
 * Registration validation, password strength, dynamic dropdowns
 */

document.addEventListener('DOMContentLoaded', () => {
    // Password visibility toggles
    initPasswordToggles();

    // Registration form
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        initRegistrationForm(registerForm);
    }

    // Login form
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        initLoginForm(loginForm);
    }

    // Forgot password form
    const forgotForm = document.getElementById('forgot-form');
    if (forgotForm) {
        initForgotForm(forgotForm);
    }

    // Reset password form
    const resetForm = document.getElementById('reset-form');
    if (resetForm) {
        initResetForm(resetForm);
    }

    // Verify account form
    const verifyForm = document.getElementById('verify-form');
    if (verifyForm) {
        initVerifyForm(verifyForm);
    }
});

/**
 * Password visibility toggles
 */
function initPasswordToggles() {
    document.querySelectorAll('.input-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('input');
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;
            } else {
                input.type = 'password';
                btn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
            }
        });
    });
}

/**
 * Registration Form
 */
function initRegistrationForm(form) {
    const emailInput = form.querySelector('#email');
    const passwordInput = form.querySelector('#password');
    const confirmInput = form.querySelector('#confirm_password');
    const departmentSelect = form.querySelector('#department_id');
    const programSelect = form.querySelector('#program_id');
    const termsCheck = form.querySelector('#accept_terms');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Email validation - force @st.rmu.edu.gh
    if (emailInput) {
        emailInput.addEventListener('blur', () => {
            const email = emailInput.value.trim();
            if (email && !email.endsWith('@st.rmu.edu.gh')) {
                showFieldError(emailInput, 'Email must end with @st.rmu.edu.gh');
            } else if (email && !isValidEmail(email)) {
                showFieldError(emailInput, 'Please enter a valid email address');
            } else {
                clearFieldError(emailInput);
            }
        });

        // Auto-suggest domain
        emailInput.addEventListener('input', () => {
            const val = emailInput.value;
            if (val.includes('@') && !val.includes('@st.rmu.edu.gh')) {
                const parts = val.split('@');
                const domain = parts[1] || '';
                if ('st.rmu.edu.gh'.startsWith(domain) && domain.length > 0) {
                    // Show suggestion
                }
            }
        });
    }

    // Password strength meter
    if (passwordInput) {
        passwordInput.addEventListener('input', () => {
            updatePasswordStrength(passwordInput.value);

            // Check confirm match
            if (confirmInput && confirmInput.value) {
                validatePasswordMatch(passwordInput, confirmInput);
            }
        });
    }

    // Confirm password match
    if (confirmInput) {
        confirmInput.addEventListener('input', () => {
            validatePasswordMatch(passwordInput, confirmInput);
        });
    }

    // Dynamic program dropdown based on department
    if (departmentSelect && programSelect) {
        departmentSelect.addEventListener('change', async () => {
            const deptId = departmentSelect.value;
            programSelect.innerHTML = '<option value="">Loading...</option>';
            programSelect.disabled = true;

            if (!deptId) {
                programSelect.innerHTML = '<option value="">Select Department first</option>';
                programSelect.disabled = true;
                return;
            }

            try {
                const appUrl = document.querySelector('meta[name="app-url"]')?.content || '';
                const response = await fetch(`${appUrl}/api/programs?department_id=${deptId}`);
                const data = await response.json();

                programSelect.innerHTML = '<option value="">Select Program</option>';
                if (data.programs && data.programs.length > 0) {
                    data.programs.forEach(program => {
                        const option = document.createElement('option');
                        option.value = program.id;
                        option.textContent = program.name;
                        programSelect.appendChild(option);
                    });
                } else {
                    programSelect.innerHTML = '<option value="">No programs found</option>';
                }
                programSelect.disabled = false;
            } catch (error) {
                programSelect.innerHTML = '<option value="">Error loading programs</option>';
                programSelect.disabled = false;
            }
        });
    }

    // Form submission validation
    form.addEventListener('submit', (e) => {
        let isValid = true;

        // Check required fields
        const required = form.querySelectorAll('[required]');
        required.forEach(field => {
            if (!field.value.trim()) {
                showFieldError(field, 'This field is required');
                isValid = false;
            }
        });

        // Check email
        if (emailInput && !emailInput.value.endsWith('@st.rmu.edu.gh')) {
            showFieldError(emailInput, 'Email must end with @st.rmu.edu.gh');
            isValid = false;
        }

        // Check password
        if (passwordInput && passwordInput.value.length < 8) {
            showFieldError(passwordInput, 'Password must be at least 8 characters');
            isValid = false;
        }

        // Check password match
        if (confirmInput && passwordInput.value !== confirmInput.value) {
            showFieldError(confirmInput, 'Passwords do not match');
            isValid = false;
        }

        // Check terms
        if (termsCheck && !termsCheck.checked) {
            showFieldError(termsCheck, 'You must accept the terms and conditions');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } else {
            // Show loading
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="btn-spinner"></span> Creating Account...';
            }
        }
    });
}

/**
 * Login Form
 */
function initLoginForm(form) {
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', (e) => {
        const email = form.querySelector('#email');
        const password = form.querySelector('#password');
        let isValid = true;

        if (!email.value.trim()) {
            showFieldError(email, 'Email is required');
            isValid = false;
        }
        if (!password.value.trim()) {
            showFieldError(password, 'Password is required');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        } else if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="btn-spinner"></span> Signing In...';
        }
    });
}

/**
 * Forgot Password Form
 */
function initForgotForm(form) {
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', (e) => {
        const email = form.querySelector('#email');
        if (!email.value.trim()) {
            showFieldError(email, 'Email is required');
            e.preventDefault();
        } else if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="btn-spinner"></span> Sending...';
        }
    });
}

/**
 * Reset Password Form
 */
function initResetForm(form) {
    const password = form.querySelector('#password');
    const confirm = form.querySelector('#confirm_password');
    const submitBtn = form.querySelector('button[type="submit"]');

    if (password) {
        password.addEventListener('input', () => {
            updatePasswordStrength(password.value);
        });
    }

    form.addEventListener('submit', (e) => {
        let isValid = true;

        if (password && password.value.length < 8) {
            showFieldError(password, 'Password must be at least 8 characters');
            isValid = false;
        }

        if (confirm && password.value !== confirm.value) {
            showFieldError(confirm, 'Passwords do not match');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        } else if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="btn-spinner"></span> Resetting...';
        }
    });
}

/**
 * Verify Account Form
 */
function initVerifyForm(form) {
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', (e) => {
        const email = form.querySelector('#email');
        const indexNo = form.querySelector('#index_number');
        let isValid = true;

        if (email && !email.value.trim()) {
            showFieldError(email, 'Email is required');
            isValid = false;
        }
        if (indexNo && !indexNo.value.trim()) {
            showFieldError(indexNo, 'Index number is required');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        } else if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="btn-spinner"></span> Verifying...';
        }
    });
}

/**
 * Password Strength Meter
 */
function updatePasswordStrength(password) {
    const strengthBar = document.querySelector('.strength-bar');
    const strengthText = document.querySelector('.strength-text');

    if (!strengthBar || !strengthText) return;

    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    // Remove all strength classes
    strengthBar.className = 'strength-bar';
    strengthText.className = 'strength-text';

    if (password.length === 0) {
        strengthText.textContent = '';
        return;
    }

    const labels = ['', 'Weak', 'Fair', 'Strong', 'Very Strong'];
    const classes = ['', 'weak', 'fair', 'strong', 'very-strong'];

    strengthBar.classList.add(`strength-${strength}`);
    strengthText.classList.add(classes[strength]);
    strengthText.textContent = labels[strength];
}

/**
 * Validate password match
 */
function validatePasswordMatch(passwordInput, confirmInput) {
    if (confirmInput.value && passwordInput.value !== confirmInput.value) {
        showFieldError(confirmInput, 'Passwords do not match');
    } else if (confirmInput.value) {
        clearFieldError(confirmInput);
        confirmInput.classList.add('is-valid');
    }
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    field.classList.add('is-invalid');
    field.classList.remove('is-valid');

    // Remove existing error
    const existing = field.parentElement.querySelector('.form-error');
    if (existing) existing.remove();

    const error = document.createElement('div');
    error.className = 'form-error';
    error.textContent = message;

    // Insert after the input or its parent (for input-group)
    const parent = field.closest('.input-group') || field;
    parent.parentElement.appendChild(error);

    // Clear on input
    field.addEventListener('input', () => {
        clearFieldError(field);
    }, { once: true });
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    field.classList.remove('is-invalid');
    const parent = field.closest('.form-group') || field.parentElement;
    const error = parent.querySelector('.form-error');
    if (error) error.remove();
}

/**
 * Email validation
 */
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
