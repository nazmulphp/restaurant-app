<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Your Way | Cosmic Burger</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        .order-option {
            background: var(--color-white);
            border-radius: 2rem;
            padding: 3rem;
            text-align: center;
            transition: var(--transition-smooth);
            border: 1px solid var(--color-neutral-100);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            cursor: pointer;
        }
        .order-option:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: var(--color-primary);
        }
        .order-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--color-neutral-50);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body style="background: var(--color-neutral-50);">

    <header class="navbar scrolled">
        <div class="container">
            <a href="index.php" class="logo"><span data-site-name>COSMIC Burger</span></a>
            <nav class="nav-links">
                <a href="index.php" class="nav-link">Home</a>
                <a href="menu.php" class="nav-link">Menu</a>
                <a href="index.php#story" class="nav-link">Our Story</a>
                <a href="order.php" class="btn btn-primary" style="padding: 0.5rem 1.5rem; font-size: 0.7rem;">Order Now</a>
                <a href="admin-login.php" class="header-login" title="Staff Login">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </a>
                <button id="header-cart" class="header-cart" onclick="showCartFeedback()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span class="cart-badge">0</span>
                </button>
            </nav>
        </div>
    </header>

    <main class="main-content" style="padding-top: 120px; padding-bottom: 80px;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 5rem;">
                <span class="section-subtitle">Almost There</span>
                <h1 class="section-title text-display">Order Your Way</h1>
                <p style="color: #666; max-width: 600px; margin: 0 auto;">Choose how you'd like to finalize your cosmic feast.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem;">
                <!-- Direct Order -->
                <div onclick="handleDirectOrder()" class="order-option">
                    <div class="order-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    </div>
                    <h3 class="text-display" style="font-size: 1.5rem;">Order Now</h3>
                    <p style="color: #666; font-size: 0.875rem;">Pay directly on our secure platform and get your food faster.</p>
                    <span class="btn btn-primary" style="width: 100%;">Proceed to Payment</span>
                </div>

                <!-- Uber Eats -->
                <div onclick="handleThirdParty('Uber Eats', 'https://www.ubereats.com')" class="order-option">
                    <div class="order-icon" style="background: #E8F5E9; color: #06C167;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <h3 class="text-display" style="font-size: 1.5rem;">Uber Eats</h3>
                    <p style="color: #666; font-size: 0.875rem;">Redirect to Uber Eats with your order details pre-filled.</p>
                    <span class="btn" style="width: 100%; background: #06C167; color: white;">Order with Uber</span>
                </div>

                <!-- Rappi -->
                <div onclick="handleThirdParty('Rappi', 'https://www.rappi.com')" class="order-option">
                    <div class="order-icon" style="background: #FFF3E0; color: #FF441F;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    </div>
                    <h3 class="text-display" style="font-size: 1.5rem;">Rappi</h3>
                    <p style="color: #666; font-size: 0.875rem;">Redirect to Rappi for lightning-fast delivery across the galaxy.</p>
                    <span class="btn" style="width: 100%; background: #FF441F; color: white;">Order with Rappi</span>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2024 Cosmic Burger. All rights reserved.</p>
                <p><a href="admin-login.php" style="color: var(--color-primary); font-weight: 700; text-decoration: none;">Staff Login</a></p>
            </div>
        </div>
    </footer>

    <script>
        function getOrderData() {
            const pending = JSON.parse(sessionStorage.getItem('cosmic_pending_order') || 'null');
            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('order_id');
            if (pending && (!orderId || String(pending.orderId) === String(orderId))) return pending;
            return orderId ? { orderId } : null;
        }

        function handleDirectOrder() {
            const orderData = getOrderData();
            if (!orderData) return alert('No order data found');
            
            // Construct query string
            const params = new URLSearchParams();
            params.append('order', JSON.stringify(orderData));
            
            params.append('order_id', orderData.orderId);
            window.location.href = 'payment.php?' + params.toString();
        }

        function handleThirdParty(platform, baseUrl) {
            const orderData = getOrderData();
            if (!orderData) return alert('No order data found');

            // Construct query string for third party
            const params = new URLSearchParams();
            params.append('platform', platform);
            params.append('customer_name', orderData.customer.name);
            params.append('order_total', orderData.totals.total);
            params.append('items', orderData.items.map(i => `${i.quantity}x ${i.name}`).join(', '));

            // Clear session storage as requested
            sessionStorage.removeItem('cosmic_cart');
            sessionStorage.removeItem('cosmic_pending_order');

            // Redirect
            window.location.href = baseUrl + '?' + params.toString();
        }
    </script>
</body>
</html>
