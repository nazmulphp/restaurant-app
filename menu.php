<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Cosmic Burger</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        .tab-btn {
            background: none;
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.75rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: var(--transition-smooth);
        }
        .tab-btn.active {
            border-bottom-color: var(--color-primary);
            color: var(--color-primary);
        }
        .search-input {
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 9999px;
            border: 1px solid var(--color-neutral-200);
            font-family: var(--font-sans);
            outline: none;
            transition: var(--transition-smooth);
        }
        .search-input:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
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
                <div class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </div>
                <div class="nav-item">
                    <a href="menu.php" class="nav-link">Menu <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M6 9l6 6 6-6"/></svg></a>
                    <div class="dropdown">
                        <div class="dropdown-item">
                            <a href="menu.php?category=Burgers" class="dropdown-link">Burgers <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M9 18l6-6-6-6"/></svg></a>
                            <div class="dropdown-nested">
                                <a href="#" class="dropdown-link">Classic Burgers</a>
                                <a href="#" class="dropdown-link">Specialty Burgers</a>
                                <a href="#" class="dropdown-link">Veggie Options</a>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="menu.php?category=Sides" class="dropdown-link">Sides <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M9 18l6-6-6-6"/></svg></a>
                            <div class="dropdown-nested">
                                <a href="#" class="dropdown-link">Fries & Wedges</a>
                                <a href="#" class="dropdown-link">Wings & Strips</a>
                                <a href="#" class="dropdown-link">Salads</a>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="menu.php?category=Drinks" class="dropdown-link">Drinks <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M9 18l6-6-6-6"/></svg></a>
                            <div class="dropdown-nested">
                                <a href="#" class="dropdown-link">Milkshakes</a>
                                <a href="#" class="dropdown-link">Soft Drinks</a>
                                <a href="#" class="dropdown-link">Coffee & Tea</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-item">
                    <a href="index.php#story" class="nav-link">Our Story</a>
                </div>
                <div class="nav-item">
                    <a href="index.php#blog" class="nav-link">Chronicles <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M6 9l6 6 6-6"/></svg></a>
                    <div class="dropdown">
                        <div class="dropdown-item">
                            <a href="#" class="dropdown-link">Latest News</a>
                        </div>
                        <div class="dropdown-item">
                            <a href="#" class="dropdown-link">Recipes</a>
                        </div>
                        <div class="dropdown-item">
                            <a href="#" class="dropdown-link">Events</a>
                        </div>
                    </div>
                </div>
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

    <main class="main-content">
        <div class="container">
            <div style="text-align: center; margin-bottom: 5rem;">
                <span class="section-subtitle reveal">Fuel Your Journey</span>
                <h1 class="section-title text-display reveal" data-delay="100">The Cosmic Menu</h1>
            </div>

            <div class="reveal" data-delay="200" style="max-width: 700px; margin: 0 auto 4rem;">
                <input type="text" id="menu-search" class="search-input" placeholder="Search the multiverse for your favorite burger...">
            </div>

            <div role="tablist" aria-label="Menu Categories" class="reveal menu-tabs" data-delay="300">
                <button id="tab-all" role="tab" aria-selected="true" aria-controls="menu-grid" tabindex="0" class="tab-btn active" data-category="All">All Items</button>
                <button id="tab-burgers" role="tab" aria-selected="false" aria-controls="menu-grid" tabindex="-1" class="tab-btn" data-category="Burgers">Burgers</button>
                <button id="tab-sides" role="tab" aria-selected="false" aria-controls="menu-grid" tabindex="-1" class="tab-btn" data-category="Sides">Sides</button>
                <button id="tab-drinks" role="tab" aria-selected="false" aria-controls="menu-grid" tabindex="-1" class="tab-btn" data-category="Drinks">Drinks</button>
                <button id="tab-combos" role="tab" aria-selected="false" aria-controls="menu-grid" tabindex="-1" class="tab-btn" data-category="Combos">Combos</button>
                <button id="tab-sauces" role="tab" aria-selected="false" aria-controls="menu-grid" tabindex="-1" class="tab-btn" data-category="Sauces / add-ons">Sauces / add-ons</button>
            </div>

            <div id="menu-grid" role="tabpanel" aria-labelledby="tab-all" class="menu-grid">
                <!-- Dynamically populated by menu.js -->
            </div>
        </div>
    </main>

    <!-- Modal Structure -->
    <div id="menu-modal" class="modal-overlay">
        <div class="modal-container">
            <button class="modal-close" onclick="closeModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
            <img id="modal-img" src="" alt="" class="modal-image" referrerPolicy="no-referrer">
            <div class="modal-body">
                <span id="modal-category" class="section-subtitle" style="margin-bottom: 1rem;"></span>
                <h2 id="modal-title" class="text-display" style="font-size: 3rem; margin-bottom: 0.5rem;"></h2>
                <div id="modal-rating" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;"></div>
                <p id="modal-desc" style="color: #666; margin-bottom: 2rem; line-height: 1.6;"></p>
                <div id="modal-modifiers" style="margin-bottom: 2rem; padding: 1.5rem; background: var(--color-neutral-50); border-radius: 1rem; display: none;"></div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                    <span id="modal-price" style="font-size: 2rem; font-weight: 900; color: var(--color-primary);"></span>
                    <button id="modal-add-btn" class="btn btn-primary">Add to Order</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">COSMIC<span>BURGER</span></a>
                    <p class="footer-text"><span data-footer-text>Flipping the script on fast food since 2024. Join the revolution and taste the multiverse.</span></p>
                    <div class="footer-social">
                        <a href="#" class="social-icon" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                        <a href="#" class="social-icon" aria-label="Twitter">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                        </a>
                        <a href="#" class="social-icon" aria-label="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="order.php" class="footer-link">Order Now</a></li>
                        <li><a href="index.php#story" class="footer-link">Our Story</a></li>
                        <li><a href="#" class="footer-link">Locations</a></li>
                        <li><a href="#" class="footer-link">Franchise</a></li>
                        <li><a href="admin-login.php" class="footer-link" style="color: var(--color-primary); font-weight: 700;">Staff Login</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="footer-heading">Support</h5>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">Contact Us</a></li>
                        <li><a href="#" class="footer-link">FAQs</a></li>
                        <li><a href="#" class="footer-link">Privacy Policy</a></li>
                        <li><a href="#" class="footer-link">Terms of Service</a></li>
                    </ul>
                </div>

                <div class="footer-newsletter">
                    <h5 class="footer-heading">Newsletter</h5>
                    <p>Get celestial updates and exclusive offers delivered to your orbit.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault();">
                        <input type="email" class="newsletter-input" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.75rem;">Join</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Cosmic Burger. All rights reserved.</p>
                <p>Designed for the Multiverse</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>
    <script src="assets/js/menu.js"></script>
</body>
</html>
