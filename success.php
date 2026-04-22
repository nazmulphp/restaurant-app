<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success | Cosmic Burger</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body style="background: var(--color-neutral-50);">
    <main class="main-content" style="padding-top:120px;padding-bottom:80px;">
        <div class="container">
            <div style="max-width:760px;margin:0 auto;background:#fff;border-radius:2rem;padding:3rem;box-shadow:0 10px 30px rgba(0,0,0,0.06);text-align:center;">
                <span class="section-subtitle">Order Confirmed</span>
                <h1 class="section-title text-display">Thank you for your order</h1>
                <p style="color:#666;margin-bottom:2rem;">Your payment has been completed and your kitchen team can now prepare the order.</p>
                <div style="display:grid;gap:1rem;max-width:420px;margin:0 auto 2rem;text-align:left;">
                    <div class="summary-row"><span>Order Number</span><strong id="success-order-number">-</strong></div>
                    <div class="summary-row"><span>Payment Method</span><strong id="success-payment-method">-</strong></div>
                    <div class="summary-row"><span>Status</span><strong>Preparing</strong></div>
                </div>
                <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                    <a href="menu.php" class="btn btn-outline">Back to Menu</a>
                    <a href="index.php" class="btn btn-primary">Go Home</a>
                </div>
            </div>
        </div>
    </main>
    <script>
        const params = new URLSearchParams(window.location.search);
        document.getElementById('success-order-number').textContent = params.get('order_number') || ('CB-' + String(params.get('order_id') || '').padStart(6,'0'));
        document.getElementById('success-payment-method').textContent = params.get('method') || 'Card';
    </script>
</body>
</html>
