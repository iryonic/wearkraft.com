/**
 * WearKraft.com - Authentication functionality
 */

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = loginForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = `<span class="animate-pulse">Verifying...</span>`;

            const formData = new FormData(this);
            formData.append('action', 'login');

            fetch('ajax/auth_handler.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect || 'index.php';
                    } else {
                        if (window.showToast) window.showToast(data.message, 'error');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Auth Error:', error);
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = registerForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = `<span class="animate-pulse">Creating...</span>`;

            const formData = new FormData(this);
            formData.append('action', 'register');

            fetch('ajax/auth_handler.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (window.showToast) window.showToast('Welcome to the crew! ⚡');
                        setTimeout(() => window.location.href = data.redirect || 'index.php', 1000);
                    } else {
                        if (window.showToast) window.showToast(data.message, 'error');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Auth Error:', error);
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        });
    }
});
