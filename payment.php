<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | Cosmic Burger</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        .payment-card {
            background: white;
            padding: 3rem;
            border-radius: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 0 auto;
        }
        .payment-method {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            border: 2px solid var(--color-neutral-100);
            border-radius: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: var(--transition-smooth);
        }
        .payment-method:hover {
            border-color: var(--color-primary);
            background: rgba(234, 88, 12, 0.05);
        }
        .payment-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--color-neutral-50);
            border-radius: 50%;
            color: var(--color-primary);
        }
    </style>
</head>
<body style="background: var(--color-neutral-50);">

    <header class="navbar scrolled">
        <div class="container">
            <a href="index.php" class="logo"><span data-site-name>COSMIC Burger</span></a>
            <a href="admin-login.php" class="header-login" title="Staff Login" style="margin-left: auto;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </a>
        </div>
    </header>

    <main class="main-content" style="padding-top: 120px; padding-bottom: 80px;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 class="section-title text-display">Secure Payment</h1>
                <p style="color: #666;">Choose your preferred payment method to finalize your order.</p>
            </div>

            <div class="payment-card">
                <div style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--color-neutral-100);">
                    <div style="display: flex; justify-content: space-between; font-weight: 900; font-size: 1.25rem;">
                        <span>Total Amount</span>
                        <span id="payment-total">$0.00</span>
                    </div>
                </div>

                <div onclick="processPayment('Stripe')" class="payment-method">
                    <div class="payment-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    </div>
                    <div>
                        <h4 style="font-weight: 800;">Credit / Debit Card</h4>
                        <p style="font-size: 0.75rem; color: #666;">Powered by Stripe</p>
                    </div>
                </div>

                <div onclick="processPayment('PayPal')" class="payment-method">
                    <div class="payment-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div>
                        <h4 style="font-weight: 800;">PayPal</h4>
                        <p style="font-size: 0.75rem; color: #666;">Fast and secure checkout</p>
                    </div>
                </div>

                <div onclick="processPayment('Apple Pay')" class="payment-method">
                    <div class="payment-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M5 12h14"></path></svg>
                    </div>
                    <div>
                        <h4 style="font-weight: 800;">Apple Pay</h4>
                        <p style="font-size: 0.75rem; color: #666;">One-tap payment</p>
                    </div>
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
        const urlParams = new URLSearchParams(window.location.search);
        const orderId = urlParams.get('order_id');
        const pendingOrder = JSON.parse(sessionStorage.getItem('cosmic_pending_order') || 'null');

        async function loadPaymentSummary() {
            if (pendingOrder && String(pendingOrder.orderId) === String(orderId || pendingOrder.orderId)) {
                document.getElementById('payment-total').textContent = `$${Number(pendingOrder.total_amount || 0).toFixed(2)}`;
                return;
            }
            if (!orderId) {
                alert('No order data found. Redirecting to menu.');
                window.location.href = 'menu.php';
                return;
            }
            try {
                const response = await fetch(`php-backend/get_order.php?order_id=${encodeURIComponent(orderId)}`);
                const data = await response.json();
                if (!data.success) throw new Error(data.message || 'Order not found');
                document.getElementById('payment-total').textContent = `$${Number(data.order.total_amount || 0).toFixed(2)}`;
            } catch (error) {
                alert('Unable to load order. Redirecting to menu.');
                window.location.href = 'menu.php';
            }
        }

        async function processPayment(method) {
            if (!orderId && !(pendingOrder && pendingOrder.orderId)) return;
            const realOrderId = orderId || pendingOrder.orderId;
            try {
                const response = await fetch('php-backend/complete_payment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_id: realOrderId, payment_method: method })
                });
                const result = await response.json();
                if (!result.success) {
                    alert(result.message || 'Payment failed');
                    return;
                }
                sessionStorage.removeItem('cosmic_cart');
                sessionStorage.removeItem('cosmic_pending_order');
                window.location.href = `success.php?order_id=${encodeURIComponent(realOrderId)}&order_number=${encodeURIComponent(result.order_number)}&method=${encodeURIComponent(method)}`;
            } catch (error) {
                alert('Payment failed. Please try again.');
            }
        }

        loadPaymentSummary();
    </script>
</body>
</html>
