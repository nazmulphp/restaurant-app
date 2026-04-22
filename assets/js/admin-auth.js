// admin-auth.js - Authentication logic for Cosmic Burger Admin

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const googleLoginBtn = document.getElementById('google-login-btn');

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            console.log('Attempting login with:', email);
            try {
                const response = await fetch('php-backend/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();
                console.log('Login response:', data);

                if (response.ok && data.success !== false && !data.error) {
                    console.log('Login successful, storing token and user data');
                    localStorage.setItem('cosmic_token', data.token);
                    localStorage.setItem('cosmic_user', JSON.stringify(data.user));
                    window.location.href = 'admin-dashboard.php';
                } else {
                    console.error('Login failed:', data.error);
                    alert(data.message || data.error || 'Login failed');
                }
            } catch (error) {
                console.error('Login error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    }

    if (signupForm) {
        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('php-backend/signup.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, email, password })
                });

                const data = await response.json();

                if (response.ok && data.success !== false && !data.error) {
                    alert('Account created successfully! Please log in.');
                    window.location.href = 'admin-login.php';
                } else {
                    alert(data.message || data.error || 'Signup failed');
                }
            } catch (error) {
                console.error('Signup error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    }

    if (googleLoginBtn) {
        googleLoginBtn.addEventListener('click', () => {
            alert('Google Login setup will be added later.');
        });
    }
});

// Helper to check if user is logged in
window.checkAuth = () => {
    const token = localStorage.getItem('cosmic_token');
    if (!token) {
        window.location.href = 'admin-login.php';
    }
    return token;
};

// Helper to logout
window.logout = () => {
    localStorage.removeItem('cosmic_token');
    localStorage.removeItem('cosmic_user');
    window.location.href = 'admin-login.php';
};
