<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Online | Cosmic Burger</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        .checkout-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 3rem;
            align-items: start;
        }
        @media (max-width: 992px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
        }
        .checkout-card {
            background: white;
            padding: 2.5rem;
            border-radius: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        @media (max-width: 768px) {
            .checkout-card {
                padding: 1.5rem;
                border-radius: 1.5rem;
            }
            .section-title {
                font-size: 2.25rem !important;
            }
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
            color: var(--color-neutral-800);
        }
        .form-control {
            width: 100%;
            padding: 1rem;
            border-radius: 0.75rem;
            border: 1px solid var(--color-neutral-200);
            font-family: var(--font-sans);
            outline: none;
            transition: var(--transition-smooth);
        }
        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
        }
        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--color-neutral-100);
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item-img {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            object-fit: cover;
        }
        .cart-item-info {
            flex: 1;
        }
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }
        .qty-btn {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 1px solid var(--color-neutral-200);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
        }
        .delivery-option {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .delivery-btn {
            flex: 1;
            padding: 1rem;
            border-radius: 1rem;
            border: 2px solid var(--color-neutral-100);
            background: white;
            cursor: pointer;
            text-align: center;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.75rem;
            transition: var(--transition-smooth);
        }
        .delivery-btn.active {
            border-color: var(--color-primary);
            background: rgba(234, 88, 12, 0.05);
            color: var(--color-primary);
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }
        .summary-total {
            border-top: 2px solid var(--color-neutral-100);
            margin-top: 1rem;
            padding-top: 1rem;
            font-weight: 900;
            font-size: 1.25rem;
        }
    </style>
</head>
<body style="background: var(--color-neutral-50);">

    <!-- Mobile Menu Elements (Outside navbar to avoid stacking context issues) -->
    <input type="checkbox" id="menu-toggle" class="menu-checkbox">
    <div class="menu-overlay"></div>
    <nav class="menu" aria-label="Mobile menu">
        <label class="menu-back" for="menu-toggle">← Close</label>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li>
                <input type="checkbox" id="m-menu" class="menu-checkbox">
                <label for="m-menu" class="has-submenu">Menu</label>
                <div class="submenu">
                    <label class="menu-back" for="m-menu">← Back</label>
                    <ul>
                        <li><a href="menu.php?category=Burgers">Burgers</a></li>
                        <li><a href="menu.php?category=Sides">Sides</a></li>
                        <li><a href="menu.php?category=Drinks">Drinks</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="index.php#story">Our Story</a></li>
            <li>
                <input type="checkbox" id="m-chronicles" class="menu-checkbox">
                <label for="m-chronicles" class="has-submenu">Chronicles</label>
                <div class="submenu">
                    <label class="menu-back" for="m-chronicles">← Back</label>
                    <ul>
                        <li><a href="#">Latest News</a></li>
                        <li><a href="#">Recipes</a></li>
                        <li><a href="#">Events</a></li>
                    </ul>
                </div>
            </li>
            <li style="padding: 10px 20px; border-bottom: none;">
                <a href="order.php" class="btn btn-primary" style="text-align: center; display: block; padding: 0.8rem;">Order Now</a>
            </li>
        </ul>
    </nav>

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
            <!-- Mobile Hamburger -->
            <label for="menu-toggle" class="mobile-menu-btn" aria-label="Open menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
            </label>
        </div>
    </header>

    <main class="main-content" style="padding-top: 120px; padding-bottom: 80px;">
        <div class="container">
            <div style="margin-bottom: 3rem;">
                <span class="section-subtitle">Final Step</span>
                <h1 class="section-title text-display" style="font-size: 3rem;">Checkout</h1>
            </div>

            <div id="empty-cart-msg" style="display: none; text-align: center; padding: 5rem 0;">
                <h2 class="text-display">Your cart is empty</h2>
                <p style="margin: 1.5rem 0; color: #666;">Looks like you haven't added any cosmic fuel yet.</p>
                <a href="menu.php" class="btn btn-primary">Go to Menu</a>
            </div>

            <div id="checkout-content" class="checkout-grid">
                <!-- Left Side: Form -->
                <div class="checkout-card">
                    <h3 class="text-display" style="margin-bottom: 2rem; font-size: 1.5rem;">Customer Information</h3>
                    
                    <div class="delivery-option">
                        <button type="button" class="delivery-btn active" data-type="pickup">Store Pickup</button>
                        <button type="button" class="delivery-btn" data-type="delivery">Home Delivery</button>
                    </div>

                    <form id="checkout-form">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone / WhatsApp</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+1 (555) 000-0000" required>
                        </div>
                        <div id="address-fields" style="display: none;">
                            <div class="form-group">
                                <label>Shipping Address</label>
                                <input type="text" name="address" class="form-control" placeholder="123 Nebula Way">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control" placeholder="Star City">
                                </div>
                                <div class="form-group">
                                    <label>Zip / Postal Code</label>
                                    <input type="text" name="zip" id="zip-code" class="form-control" placeholder="A1B 2C3">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label>Province / State</label>
                                    <select name="state" id="province-select" class="form-control">
                                        <option value="ON">Ontario</option>
                                        <option value="QC">Quebec</option>
                                        <option value="BC">British Columbia</option>
                                        <option value="AB">Alberta</option>
                                        <option value="MB">Manitoba</option>
                                        <option value="SK">Saskatchewan</option>
                                        <option value="NS">Nova Scotia</option>
                                        <option value="NB">New Brunswick</option>
                                        <option value="NL">Newfoundland and Labrador</option>
                                        <option value="PE">Prince Edward Island</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" name="country" class="form-control" value="Canada" readonly>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Confirm Order</button>
                    </form>
                </div>

                <!-- Right Side: Order Summary -->
                <div class="checkout-card">
                    <h3 class="text-display" style="margin-bottom: 2rem; font-size: 1.5rem;">Order Details</h3>
                    <div id="cart-items-list">
                        <!-- Cart items will be injected here -->
                    </div>

                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid var(--color-neutral-100);">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="summary-subtotal">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>VAT / TAX (<span id="tax-rate-label">13</span>%)</span>
                            <span id="summary-tax">$0.00</span>
                        </div>
                        <div class="summary-row" id="delivery-fee-row" style="display: none;">
                            <span>Delivery Fee</span>
                            <span id="summary-delivery">$5.00</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Total</span>
                            <span id="summary-total">$0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">COSMIC<span>BURGER</span></a>
                    <p class="footer-text"><span data-footer-text>Flipping the script on fast food since 2024. Join the revolution and taste the multiverse.</span></p>
                </div>
                <div>
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="menu.php" class="footer-link">The Menu</a></li>
                        <li><a href="index.php#story" class="footer-link">Our Story</a></li>
                        <li><a href="order.php" class="footer-link">Order Now</a></li>
                        <li><a href="admin-login.php" class="footer-link" style="color: var(--color-primary); font-weight: 700;">Staff Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Cosmic Burger. All rights reserved.</p>
                <p>Designed for the Multiverse</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>
