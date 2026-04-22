<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmic Burger | Out of this World Flavor</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <!-- Header Section -->
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
            <li><a href="#story">Our Story</a></li>
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
                <a href="menu.php" class="btn btn-primary" style="text-align: center; display: block; padding: 0.8rem;">Order Now</a>
            </li>
        </ul>
    </nav>

    <header class="navbar">
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
                    <a href="#story" class="nav-link">Our Story</a>
                </div>
                <div class="nav-item">
                    <a href="#blog" class="nav-link">Chronicles <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M6 9l6 6 6-6"/></svg></a>
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