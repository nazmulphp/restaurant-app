<?php include 'header.php'?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg">
           <!-- <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&amp;fit=crop&amp;q=80&amp;w=1920" alt="Hero Background" referrerpolicy="no-referrer"> -->
            <img src="assets/img/bg-image.jpeg" alt="Hero Background" referrerpolicy="no-referrer">
        </div>
        <div class="container">
            <div class="hero-wrapper">
                <div class="hero-content">
                    <span class="section-subtitle reveal" style="color: var(--color-white); opacity: 0.8;">Est. 2024 • Galactic Standard</span>
                    <h1 id="hero-title-dynamic" class="hero-title text-display reveal" data-delay="100">Taste the<br><span style="color: var(--color-primary)">Multiverse</span></h1>
                    <p id="hero-text-dynamic" class="reveal" data-delay="200" style="color: var(--color-neutral-100); font-size: 1.25rem; margin-bottom: 3rem; max-width: 600px; opacity: 0.8;">
                        We're not just flipping burgers; we're warping reality. Experience the crunch that echoed through the nebula.
                    </p>
                    <div class="reveal hero-btns" data-delay="300">
                        <a href="order.php" class="btn btn-primary">Order Now</a>
                        <a href="menu.php" class="btn btn-outline">Explore Menu</a>
                    </div>
                </div>
                <div class="hero-visual reveal" data-delay="400">
                    <div class="burger-3d-container">
                        <!-- <img src="https://pngimg.com/uploads/burger_sandwich/burger_sandwich_PNG4135.png" alt="3D Burger" class="burger-3d"> -->
                        <img src="assets/img/burger-image.png" alt="3D Burger" class="burger-3d">
                        <div class="burger-glow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promotions Section -->
    <section class="promotions">
        <div class="container">
            <div class="promo-grid">
                <div class="promo-card reveal" data-delay="100" style="background: linear-gradient(135deg, var(--color-primary) 0%, #9a3412 100%); padding: 2.5rem;">
                    <span style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; opacity: 0.8;">Limited Time</span>
                    <h3 class="text-display" style="font-size: 2.5rem; margin: 1rem 0; line-height: 1.1;">Launch Special</h3>
                    <p style="margin-bottom: 2rem; opacity: 0.9; font-size: 1.1rem;">Get 20% off your first order with code <strong id="promo-code-dynamic" style="color: white;">COSMIC20</strong></p>
                    <a href="order.php" class="btn" style="background: white; color: var(--color-neutral-900); padding: 0.75rem 2rem; font-weight: 900; border-radius: 9999px; text-decoration: none; display: inline-block;">Claim Now</a>
                </div>
                <div class="promo-card reveal" data-delay="200" style="background: linear-gradient(135deg, #171717 0%, #000000 100%); border: 1px solid var(--glass-border); padding: 2.5rem;">
                    <span style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; opacity: 0.8;">Night Owls</span>
                    <h3 class="text-display" style="font-size: 2.5rem; margin: 1rem 0; line-height: 1.1;">Midnight Snack</h3>
                    <p style="margin-bottom: 2rem; opacity: 0.9; font-size: 1.1rem;">Free Galactic Shake with any burger after 10 PM</p>
                    <a href="order.php" class="btn btn-primary">Order Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" style="background: var(--color-neutral-900); color: white; padding: 5rem 0;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <span class="section-subtitle reveal" style="color: var(--color-primary);">Cosmic Impact</span>
                <h2 class="section-title reveal" data-delay="100" style="color: white;">By the Numbers</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-item reveal">
                    <div id="stat-total-menu-items" class="stat-number">0</div>
                    <div class="stat-label">Menu Items</div>
                </div>
                <div class="stat-item reveal" data-delay="100">
                    <div id="stat-orders-today" class="stat-number">0</div>
                    <div class="stat-label">Orders Today</div>
                </div>
                <div class="stat-item reveal" data-delay="200">
                    <div id="stat-total-orders" class="stat-number">0</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-item reveal" data-delay="300">
                    <div id="stat-total-sales" class="stat-number">$0.00</div>
                    <div class="stat-label">Paid Sales</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Combos Section -->
    <section id="combos" style="background: var(--color-neutral-50); position: relative; overflow: hidden;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span class="section-subtitle reveal">Value Deals</span>
                <h2 class="section-title reveal" data-delay="100">Galactic Combos</h2>
            </div>
            
            <div class="combo-slider-wrapper">
                <button class="slider-nav prev" aria-label="Previous Combo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                
                <div class="combo-slider" id="combo-slider">
                    <!-- Combo 1 -->
                    <div class="combo-slide">
                        <div class="menu-card reveal" data-delay="100">
                            <img src="https://images.unsplash.com/photo-1551782450-a2132b4ba21d?auto=format&fit=crop&q=80&w=800" alt="Galaxy Combo" class="menu-card-img" referrerPolicy="no-referrer">
                            <div style="padding: 0.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
                                    <h4 class="text-display" style="font-size: 1.25rem;">Galaxy Combo</h4>
                                    <span style="color: var(--color-primary); font-weight: 900; font-size: 1.1rem;">$19.99</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem;">
                                    <div style="display: flex; color: #FFB800;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    </div>
                                    <span style="font-size: 0.75rem; color: #999;">(542)</span>
                                </div>
                                <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem; line-height: 1.4;">
                                    Any burger + Stardust Fries + Plasma Punch. The ultimate survival kit.
                                </p>
                                <a href="menu.php?category=Combos" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.75rem; text-align: center;">View Combos</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Combo 2 -->
                    <div class="combo-slide">
                        <div class="menu-card reveal" data-delay="200">
                            <img src="https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?auto=format&fit=crop&q=80&w=800" alt="Nebula Feast" class="menu-card-img" referrerPolicy="no-referrer">
                            <div style="padding: 0.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
                                    <h4 class="text-display" style="font-size: 1.25rem;">Nebula Feast</h4>
                                    <span style="color: var(--color-primary); font-weight: 900; font-size: 1.1rem;">$24.99</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem;">
                                    <div style="display: flex; color: #FFB800;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    </div>
                                    <span style="font-size: 0.75rem; color: #999;">(215)</span>
                                </div>
                                <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem; line-height: 1.4;">
                                    Double Supernova + Meteor Wings + 2 Galactic Shakes. Perfect for pairs.
                                </p>
                                <a href="menu.php?category=Combos" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.75rem; text-align: center;">View Combos</a>
                            </div>
                        </div>
                    </div>

                    <!-- Combo 3 -->
                    <div class="combo-slide">
                        <div class="menu-card reveal" data-delay="300">
                            <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&q=80&w=800" alt="Solar Flare Pack" class="menu-card-img" referrerPolicy="no-referrer">
                            <div style="padding: 0.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
                                    <h4 class="text-display" style="font-size: 1.25rem;">Solar Flare Pack</h4>
                                    <span style="color: var(--color-primary); font-weight: 900; font-size: 1.1rem;">$17.99</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem;">
                                    <div style="display: flex; color: #FFB800;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    </div>
                                    <span style="font-size: 0.75rem; color: #999;">(186)</span>
                                </div>
                                <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem; line-height: 1.4;">
                                    Solar Flare Spicy + Comet Rings + Plasma Punch. Heat for the journey.
                                </p>
                                <a href="menu.php?category=Combos" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.75rem; text-align: center;">View Combos</a>
                            </div>
                        </div>
                    </div>

                    <!-- Combo 4 -->
                    <div class="combo-slide">
                        <div class="menu-card reveal" data-delay="400">
                            <img src="https://images.unsplash.com/photo-1562967914-608f82629710?auto=format&fit=crop&q=80&w=800" alt="Asteroid Box" class="menu-card-img" referrerPolicy="no-referrer">
                            <div style="padding: 0.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
                                    <h4 class="text-display" style="font-size: 1.25rem;">Asteroid Box</h4>
                                    <span style="color: var(--color-primary); font-weight: 900; font-size: 1.1rem;">$15.99</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem;">
                                    <div style="display: flex; color: #FFB800;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    </div>
                                    <span style="font-size: 0.75rem; color: #999;">(142)</span>
                                </div>
                                <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem; line-height: 1.4;">
                                    Asteroid Nuggets + Stardust Fries + Void Coffee. Quick cosmic energy.
                                </p>
                                <a href="menu.php?category=Combos" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.75rem; text-align: center;">View Combos</a>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="slider-nav next" aria-label="Next Combo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>
    </section>

    <section id="featured-home" style="background: var(--color-neutral-50);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span class="section-subtitle reveal">Fresh from the Kitchen</span>
                <h2 class="section-title reveal" data-delay="100">Featured Menu</h2>
            </div>
            <div id="featured-menu-grid" class="menu-grid"></div>
        </div>
    </section>

    <!-- Order Hub Section -->
    <section id="order-hub" style="background: var(--color-white);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span class="section-subtitle reveal">Ready to Eat?</span>
                <h2 class="section-title reveal" data-delay="100">Order Your Way</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <a href="order.php" class="promo-card reveal" data-delay="100" style="background: var(--color-neutral-900); text-decoration: none; text-align: center; padding: 3rem;">
                    <h3 class="text-display" style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Direct Order</h3>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.875rem; margin-bottom: 2rem;">Order directly from our kitchen for the fastest pickup.</p>
                    <span class="btn btn-primary">Order Now</span>
                </a>
                <a href="https://www.ubereats.com" target="_blank" class="promo-card reveal" data-delay="200" style="background: #06C167; text-decoration: none; text-align: center; padding: 3rem;">
                    <h3 class="text-display" style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Uber Eats</h3>
                    <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin-bottom: 2rem;">Get your cosmic fix delivered right to your door.</p>
                    <span class="btn" style="background: white; color: #06C167;">Open App</span>
                </a>
                <a href="https://www.rappi.com" target="_blank" class="promo-card reveal" data-delay="300" style="background: #FF441F; text-decoration: none; text-align: center; padding: 3rem;">
                    <h3 class="text-display" style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Rappi</h3>
                    <p style="color: rgba(255,255,255,0.9); font-size: 0.875rem; margin-bottom: 2rem;">Fast delivery across the galaxy with Rappi.</p>
                    <span class="btn" style="background: white; color: #FF441F;">Open App</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Visit Us Section -->
    <section id="visit" style="background: var(--color-neutral-50);">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 4rem; align-items: center;">
                <div class="reveal">
                    <span class="section-subtitle">Find Us</span>
                    <h2 class="section-title">Visit the Station</h2>
                    <div style="margin-bottom: 2rem;">
                        <h4 style="font-family: var(--font-display); margin-bottom: 0.5rem; color: var(--color-primary);">Location</h4>
                        <p style="color: #666;">123 Nebula Way, Star City, GX 90210</p>
                    </div>
                    <div style="margin-bottom: 2rem;">
                        <h4 style="font-family: var(--font-display); margin-bottom: 0.5rem; color: var(--color-primary);">Hours</h4>
                        <p style="color: #666;">Mon - Thu: 11:00 AM - 11:00 PM</p>
                        <p style="color: #666;">Fri - Sun: 11:00 AM - 02:00 AM</p>
                    </div>
                    <a href="https://maps.google.com" target="_blank" class="btn btn-outline" style="border-color: var(--color-neutral-900); color: var(--color-neutral-900);">Get Directions</a>
                </div>
                <div class="reveal" data-delay="200" style="height: 400px; border-radius: 2rem; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                    <!-- Placeholder for Map -->
                    <div style="width: 100%; height: 100%; background: #eee; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #999;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 1rem;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <p>Interactive Map Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Items Section -->
    <section id="popular" style="background: var(--color-white);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span class="section-subtitle reveal">Fan Favorites</span>
                <h2 class="section-title reveal" data-delay="100">Most Wanted Burgers</h2>
            </div>
            <div class="popular-grid">
                <div class="menu-card reveal" data-delay="100">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&q=80&w=800" alt="Supernova" class="menu-card-img" referrerPolicy="no-referrer">
                    <div style="padding: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
                            <h4 class="text-display" style="font-size: 1.25rem;">The Supernova</h4>
                            <span style="color: var(--color-primary); font-weight: 900; font-size: 1.1rem;">$14.99</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem;">
                            <div style="display: flex; color: #FFB800;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            </div>
                            <span style="font-size: 0.75rem; color: #999;">(128)</span>
                        </div>
                        <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem; line-height: 1.4;">
                            Our signature double-patty beast with stardust seasoning and nebula mayo.
                        </p>
                        <button class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.75rem;" onclick="openModal(1)">View Details</button>
                    </div>
                </div>
                <div class="menu-card reveal" data-delay="200">
                    <img src="https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?auto=format&fit=crop&q=80&w=800" alt="Black Hole" class="menu-card-img" referrerPolicy="no-referrer">
                    <div style="padding: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
                            <h4 class="text-display" style="font-size: 1.25rem;">Black Hole BBQ</h4>
                            <span style="color: var(--color-primary); font-weight: 900; font-size: 1.1rem;">$15.99</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem;">
                            <div style="display: flex; color: #FFB800;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            </div>
                            <span style="font-size: 0.75rem; color: #999;">(210)</span>
                        </div>
                        <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem; line-height: 1.4;">
                            Deep, dark BBQ sauce with crispy onion rings that pull you in.
                        </p>
                        <button class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.75rem;" onclick="openModal(3)">View Details</button>
                    </div>
                </div>
                <div class="menu-card reveal" data-delay="300">
                    <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&q=80&w=800" alt="Nebula" class="menu-card-img" referrerPolicy="no-referrer">
                    <div style="padding: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
                            <h4 class="text-display" style="font-size: 1.25rem;">Nebula Veggie</h4>
                            <span style="color: var(--color-primary); font-weight: 900; font-size: 1.1rem;">$12.99</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem;">
                            <div style="display: flex; color: #FFB800;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            </div>
                            <span style="font-size: 0.75rem; color: #999;">(85)</span>
                        </div>
                        <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem; line-height: 1.4;">
                            A plant-based masterpiece that tastes like it was grown in a celestial garden.
                        </p>
                        <button class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.75rem;" onclick="openModal(2)">View Details</button>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 4rem;">
                <a href="menu.php" class="btn" style="border: 2px solid var(--color-neutral-900);">View Full Menu</a>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section id="story" style="background: var(--color-neutral-50);">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 6rem; align-items: center;">
                <div class="reveal">
                    <img src="https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?auto=format&fit=crop&q=80&w=1000" alt="Chef" style="width: 100%; border-radius: 4rem; box-shadow: 0 40px 80px rgba(0,0,0,0.1);" referrerPolicy="no-referrer">
                </div>
                <div class="reveal" data-delay="200">
                    <span class="section-subtitle">Our Origin Story</span>
                    <h2 class="section-title text-display" style="margin-bottom: 2rem;">Born in the<br><span style="color: var(--color-primary)">Heart of a Star</span></h2>
                    <p style="font-size: 1.125rem; color: #555; margin-bottom: 2rem;">
                        It started with a simple question: Why does fast food feel so... terrestrial? We spent years in our orbital kitchen, perfecting the art of the vacuum-sealed sear and the zero-gravity flip.
                    </p>
                    <p style="font-size: 1.125rem; color: #555; margin-bottom: 3rem;">
                        Today, Cosmic Burger is more than a restaurant. It's a portal to a dimension where flavor knows no bounds and every bite is a supernova of satisfaction.
                    </p>
                    <a href="menu.php" class="btn btn-primary">Meet the Crew</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials">
        <div class="container">
            <div style="text-align: center; margin-bottom: 5rem;">
                <span class="section-subtitle">Transmission Received</span>
                <h2 class="section-title text-display">What the Galaxy Says</h2>
            </div>
            <div class="testimonial-grid">
                <div class="testimonial-card reveal">
                    <p class="testimonial-text">"The Supernova burger literally changed my molecular structure. Best meal in this quadrant."</p>
                    <div class="testimonial-author">
                        <img src="https://i.pravatar.cc/150?u=1" alt="User" class="author-img" referrerPolicy="no-referrer">
                        <div>
                            <h5 style="font-weight: 800;">Commander Zara</h5>
                            <span style="font-size: 0.75rem; opacity: 0.6;">Alpha Centauri Explorer</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card reveal" data-delay="100">
                    <p class="testimonial-text">"I've eaten at every diner from Earth to Mars. Nothing compares to the Stardust Fries."</p>
                    <div class="testimonial-author">
                        <img src="https://i.pravatar.cc/150?u=2" alt="User" class="author-img" referrerPolicy="no-referrer">
                        <div>
                            <h5 style="font-weight: 800;">Jax Orbit</h5>
                            <span style="font-size: 0.75rem; opacity: 0.6;">Freelance Pilot</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card reveal" data-delay="200">
                    <p class="testimonial-text">"Fast, hot, and absolutely out of this world. The delivery drone arrived before I even finished ordering!"</p>
                    <div class="testimonial-author">
                        <img src="https://i.pravatar.cc/150?u=3" alt="User" class="author-img" referrerPolicy="no-referrer">
                        <div>
                            <h5 style="font-weight: 800;">Luna Ray</h5>
                            <span style="font-size: 0.75rem; opacity: 0.6;">Tech Visionary</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" style="background: var(--color-neutral-50);">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 4rem; align-items: start;">
                <div class="reveal">
                    <span class="section-subtitle">Get in Touch</span>
                    <h2 class="section-title text-display">Contact the Base</h2>
                    <p style="margin-bottom: 2rem; color: #666;">Have a question about our galactic menu or want to book a private docking bay? Send us a transmission.</p>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 48px; height: 48px; background: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <div>
                                <h5 style="font-weight: 800;">Subspace Comms</h5>
                                <p style="font-size: 0.875rem; color: #666;"><span data-site-phone>+1 (555) COSMIC-1</span></p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 48px; height: 48px; background: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                            <div>
                                <h5 style="font-weight: 800;">Data Stream</h5>
                                <p style="font-size: 0.875rem; color: #666;"><span data-site-email>hello@cosmicburger.space</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reveal" data-delay="200" style="background: white; padding: 3rem; border-radius: 3rem; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
                    <form id="contact-form" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;">Pilot Name</label>
                            <input type="text" name="name" placeholder="Your name" style="padding: 1rem; border-radius: 1rem; border: 1px solid var(--color-neutral-200); outline: none;" required>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;">Frequency</label>
                            <input type="email" name="email" placeholder="Your email" style="padding: 1rem; border-radius: 1rem; border: 1px solid var(--color-neutral-200); outline: none;" required>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;">Transmission</label>
                            <textarea name="message" placeholder="Your message" rows="4" style="padding: 1rem; border-radius: 1rem; border: 1px solid var(--color-neutral-200); outline: none; resize: none;" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
                        <p id="contact-form-status" style="margin:0;font-size:0.875rem;"></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span class="section-subtitle reveal">Latest from the Kitchen</span>
                <h2 class="section-title reveal" data-delay="100">Cosmic Chronicles</h2>
            </div>
            
            <div class="blog-grid">
                <article class="blog-card reveal" data-delay="100">
                    <img src="https://images.unsplash.com/photo-1551782450-a2132b4ba21d?auto=format&fit=crop&q=80&w=800" alt="Blog" class="blog-img" referrerPolicy="no-referrer">
                    <div class="blog-content">
                        <h4 style="font-family: var(--font-display); margin-bottom: 0.5rem;">Top 5 Cosmic Toppings</h4>
                        <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem;">From stardust spices to nebula mayo, these are the toppings you need...</p>
                        <a href="#" style="color: var(--color-primary); font-weight: 800; text-decoration: none; font-size: 0.75rem; text-transform: uppercase;">Read More →</a>
                    </div>
                </article>
                <article class="blog-card reveal" data-delay="200">
                    <img src="https://images.unsplash.com/photo-1514327605112-b887c0e61c0a?auto=format&fit=crop&q=80&w=800" alt="Blog" class="blog-img" referrerPolicy="no-referrer">
                    <div class="blog-content">
                        <h4 style="font-family: var(--font-display); margin-bottom: 0.5rem;">The Zero-G Flip Secret</h4>
                        <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem;">How we achieve the perfect sear without the interference of gravity...</p>
                        <a href="#" style="color: var(--color-primary); font-weight: 800; text-decoration: none; font-size: 0.75rem; text-transform: uppercase;">Read More →</a>
                    </div>
                </article>
                <article class="blog-card reveal" data-delay="300">
                    <img src="https://images.unsplash.com/photo-1533603303155-75ec2f2b2f33?auto=format&fit=crop&q=80&w=800" alt="Blog" class="blog-img" referrerPolicy="no-referrer">
                    <div class="blog-content">
                        <h4 style="font-family: var(--font-display); margin-bottom: 0.5rem;">New Nebula Shakes</h4>
                        <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem;">Introducing our latest frozen delights inspired by the Orion Nebula...</p>
                        <a href="#" style="color: var(--color-primary); font-weight: 800; text-decoration: none; font-size: 0.75rem; text-transform: uppercase;">Read More →</a>
                    </div>
                </article>
                <article class="blog-card reveal" data-delay="400">
                    <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&q=80&w=800" alt="Blog" class="blog-img" referrerPolicy="no-referrer">
                    <div class="blog-content">
                        <h4 style="font-family: var(--font-display); margin-bottom: 0.5rem;">Sustainable Star-Farming</h4>
                        <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem;">Our commitment to sourcing ingredients from eco-friendly celestial bodies...</p>
                        <a href="#" style="color: var(--color-primary); font-weight: 800; text-decoration: none; font-size: 0.75rem; text-transform: uppercase;">Read More →</a>
                    </div>
                </article>
            </div>

            <div style="text-align: center; margin-top: 4rem;">
                <a href="#" class="btn" style="border: 2px solid var(--color-neutral-900);">View All Chronicles</a>
            </div>
        </div>
    </section>

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
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                    <span id="modal-price" style="font-size: 2rem; font-weight: 900; color: var(--color-primary);"></span>
                    <button id="modal-add-btn" class="btn btn-primary">Add to Order</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'?>