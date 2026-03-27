/**
 * Project Vault & Collaboration Hub
 * Global JavaScript
 */

const App = {
    // Base URL for AJAX
    baseUrl: document.querySelector('meta[name="app-url"]')?.content || '',

    // CSRF Token
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.content || '',

    /**
     * Initialize global functionality
     */
    init() {
        this.initAlerts();
        this.initModals();
        this.initDropdowns();
        this.initTooltips();
        this.initAnimations();
    },

    /**
     * Auto-dismiss alerts after 5 seconds
     */
    initAlerts() {
        document.querySelectorAll('.alert').forEach(alert => {
            // Close button
            const closeBtn = alert.querySelector('.alert-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    alert.classList.add('animate__animated', 'animate__fadeOutUp');
                    setTimeout(() => alert.remove(), 400);
                });
            }

            // Auto dismiss after 5s
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.classList.add('animate__animated', 'animate__fadeOutUp');
                    setTimeout(() => alert.remove(), 400);
                }
            }, 5000);
        });
    },

    /**
     * Modal handling
     */
    initModals() {
        // Open modal triggers
        document.querySelectorAll('[data-modal]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = trigger.getAttribute('data-modal');
                this.openModal(modalId);
            });
        });

        // Close modal triggers
        document.querySelectorAll('.modal-close, [data-modal-close]').forEach(btn => {
            btn.addEventListener('click', () => {
                const overlay = btn.closest('.modal-overlay');
                if (overlay) this.closeModal(overlay.id);
            });
        });

        // Close on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    this.closeModal(overlay.id);
                }
            });
        });

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                    this.closeModal(modal.id);
                });
            }
        });
    },

    openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    },

    closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    },

    /**
     * Dropdown menus
     */
    initDropdowns() {
        document.querySelectorAll('[data-dropdown]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                const dropdown = trigger.nextElementSibling;
                if (dropdown) {
                    dropdown.classList.toggle('active');
                }
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-menu.active').forEach(d => {
                d.classList.remove('active');
            });
        });
    },

    /**
     * Tooltip initialization (for dynamic elements)
     */
    initTooltips() {
        // CSS handles tooltips via [data-tooltip] attribute
    },

    /**
     * Animate elements on scroll
     */
    initAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', entry.target.dataset.animate || 'animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-animate]').forEach(el => {
            observer.observe(el);
        });
    },

    /**
     * AJAX Helper
     */
    async fetch(url, options = {}) {
        const defaults = {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
        };

        if (options.body && !(options.body instanceof FormData)) {
            options.body = JSON.stringify(options.body);
        } else if (options.body instanceof FormData) {
            delete defaults.headers['Content-Type'];
        }

        const config = { ...defaults, ...options };
        config.headers = { ...defaults.headers, ...options.headers };

        try {
            const response = await fetch(this.baseUrl + url, config);
            const data = await response.json();
            return { ok: response.ok, status: response.status, data };
        } catch (error) {
            console.error('Fetch error:', error);
            return { ok: false, status: 0, data: { message: 'Network error' } };
        }
    },

    /**
     * Show toast notification
     */
    toast(message, type = 'info', duration = 4000) {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;max-width:380px;';
            document.body.appendChild(container);
        }

        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };

        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'error' ? 'error' : type} animate__animated animate__fadeInRight`;
        toast.innerHTML = `
            <span style="font-size:16px;">${icons[type] || icons.info}</span>
            <span style="flex:1;">${message}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">×</button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('animate__fadeInRight');
            toast.classList.add('animate__fadeOutRight');
            setTimeout(() => toast.remove(), 400);
        }, duration);
    },

    /**
     * Format date
     */
    formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    },

    /**
     * Time ago
     */
    timeAgo(dateStr) {
        const seconds = Math.floor((new Date() - new Date(dateStr)) / 1000);
        if (seconds < 60) return 'Just now';
        if (seconds < 3600) return Math.floor(seconds / 60) + 'm ago';
        if (seconds < 86400) return Math.floor(seconds / 3600) + 'h ago';
        if (seconds < 604800) return Math.floor(seconds / 86400) + 'd ago';
        return this.formatDate(dateStr);
    },

    /**
     * Debounce function
     */
    debounce(func, wait = 300) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    /**
     * Confirm dialog
     */
    confirm(message, onConfirm, onCancel) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay active';
        overlay.style.zIndex = '9999';
        overlay.innerHTML = `
            <div class="modal" style="max-width:400px;">
                <div class="modal-header">
                    <h3>Confirm Action</h3>
                </div>
                <div class="modal-body">
                    <p>${message}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="confirm-cancel">Cancel</button>
                    <button class="btn btn-danger" id="confirm-ok">Confirm</button>
                </div>
            </div>
        `;

        document.body.appendChild(overlay);
        document.body.style.overflow = 'hidden';

        overlay.querySelector('#confirm-ok').addEventListener('click', () => {
            overlay.remove();
            document.body.style.overflow = '';
            if (onConfirm) onConfirm();
        });

        overlay.querySelector('#confirm-cancel').addEventListener('click', () => {
            overlay.remove();
            document.body.style.overflow = '';
            if (onCancel) onCancel();
        });

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.remove();
                document.body.style.overflow = '';
                if (onCancel) onCancel();
            }
        });
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => App.init());
