<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmic Burger | Admin Signup</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--admin-bg);
            padding: 2rem;
        }
        .auth-card {
            background-color: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 24px;
            padding: 3rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }
        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .auth-header .logo {
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .auth-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .auth-subtitle {
            color: var(--admin-text-secondary);
            font-size: 0.9375rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--admin-text-secondary);
        }
        .form-group input {
            width: 100%;
            background-color: var(--admin-bg);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            color: white;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--admin-accent-blue);
        }
        .auth-btn {
            width: 100%;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 1rem;
            background-color: var(--admin-accent-blue);
            color: white;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .auth-btn:hover {
            transform: translateY(-2px);
        }
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9375rem;
            color: var(--admin-text-secondary);
        }
        .auth-footer a {
            color: var(--admin-accent-blue);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body class="admin-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">
                    <div class="logo-icon"></div>
                    <span class="logo-text">Cosmic Burger</span>
                </div>
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join the Cosmic Burger team</p>
            </div>

            <form id="signup-form">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" id="name" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="email" placeholder="john@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="auth-btn">Sign Up</button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="admin-login.php">Sign In</a>
                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border);">
                    <a href="index.php" style="color: var(--admin-text-secondary); font-size: 0.875rem;">← Back to Website</a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/admin-auth.js"></script>
</body>
</html>
