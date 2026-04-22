-- Database Schema for Cosmic Burger

-- 1. Users table with roles
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Super Admin', 'Admin', 'Manager', 'Vendor', 'Customer', 'Store Manager', 'Kitchen Admin') DEFAULT 'Customer',
    profile_pic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Menu Categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Menu Items
CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    is_available BOOLEAN DEFAULT TRUE,
    rating DECIMAL(2, 1) DEFAULT 4.5,
    reviews INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- 4. Orders
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    customer_name VARCHAR(100),
    customer_email VARCHAR(100),
    customer_phone VARCHAR(20),
    delivery_address TEXT,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('New', 'Preparing', 'Ready', 'Delivered', 'Cancelled') DEFAULT 'New',
    source ENUM('Web', 'UberEats', 'Rappi', 'WhatsApp', 'POS') DEFAULT 'Web',
    payment_status ENUM('Paid', 'Pending') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id)
);

-- 5. Order Items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    menu_item_id INT,
    quantity INT NOT NULL,
    price_at_time DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);

-- 6. Inventory
CREATE TABLE IF NOT EXISTS inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    current_stock INT NOT NULL,
    min_stock INT NOT NULL,
    unit VARCHAR(20) NOT NULL,
    status ENUM('OK', 'LOW', 'CRITICAL') DEFAULT 'OK',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 7. Suppliers
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact_person VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    category VARCHAR(100),
    status ENUM('ACTIVE', 'DELAYED', 'INACTIVE') DEFAULT 'ACTIVE',
    delivery_days VARCHAR(100)
);

-- 8. Purchase Orders
CREATE TABLE IF NOT EXISTS purchase_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT,
    po_number VARCHAR(20) UNIQUE NOT NULL,
    items TEXT,
    total_amount DECIMAL(10, 2),
    status ENUM('DRAFT', 'SENT', 'CONFIRMED', 'RECEIVED') DEFAULT 'DRAFT',
    eta DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- 9. Site Settings
CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Initial Data
INSERT IGNORE INTO categories (name) VALUES ('Burgers'), ('Sides'), ('Drinks'), ('Combos'), ('Sauces / add-ons');

-- Default Super Admin (password: admin123)
INSERT IGNORE INTO users (name, email, password, role) VALUES ('Super Admin', 'dsitbd90@gmail.com', '0192023a7bbd73250516f069df18b500', 'Super Admin');

-- Sample Inventory
INSERT IGNORE INTO inventory (item_name, current_stock, min_stock, unit, status) VALUES 
('Bread Buns', 45, 100, 'units', 'LOW'),
('Beef Patties', 220, 80, 'units', 'OK'),
('Cheddar Cheese', 12, 50, 'kg', 'CRITICAL'),
('Vegetables', 180, 60, 'kg', 'OK'),
('Fries', 35, 20, 'kg', 'OK'),
('Packaging', 28, 50, 'units', 'LOW');

-- Sample Suppliers
INSERT IGNORE INTO suppliers (name, category, status, delivery_days) VALUES 
('FreshFarms Co.', 'Vegetables, Lettuce, Tomato', 'DELAYED', 'Tue/Thu'),
('Prime Meats LLC', 'Beef Patties, Bacon', 'ACTIVE', 'Mon/Wed/Fri'),
('Baker\'s Best', 'Bread Buns, Brioche', 'ACTIVE', 'Daily'),
('DairyCraft', 'Cheese, Sauces', 'ACTIVE', 'Tue/Fri');

-- Sample Menu Items
INSERT IGNORE INTO menu_items (category_id, name, description, price, image_url, rating, reviews) VALUES 
(1, 'Nebula Smash', 'Our signature double-patty beast with stardust seasoning.', 14.99, 'https://picsum.photos/seed/burger1/400/300', 4.9, 87),
(1, 'Galaxy Double', 'Extra cheesy burger from the Milky Way.', 17.99, 'https://picsum.photos/seed/burger2/400/300', 4.8, 54),
(2, 'Cosmic Fries', 'Golden crispy fries with space salt.', 5.99, 'https://picsum.photos/seed/fries/400/300', 4.7, 102),
(3, 'Milky Way Shake', 'A swirling mix of cosmic flavors.', 7.99, 'https://picsum.photos/seed/shake/400/300', 4.9, 43);

-- Sample Orders
INSERT IGNORE INTO orders (customer_name, customer_email, customer_phone, delivery_address, total_amount, status, source, payment_status) VALUES 
('Marcus Whitfield', 'marcus@example.com', '123456789', '123 Star Lane', 25.98, 'New', 'UberEats', 'Paid'),
('Diana Prescott', 'diana@example.com', '987654321', '456 Galaxy Rd', 15.99, 'New', 'Rappi', 'Paid'),
('Roberto Sandoval', 'roberto@example.com', '555666777', '789 Comet St', 32.50, 'Preparing', 'Web', 'Paid'),
('Walk-in Customer', 'pos@example.com', '000000000', 'In-store', 12.50, 'Preparing', 'POS', 'Paid'),
('Carla Fuentes', 'carla@example.com', '111222333', '101 Moon Blvd', 45.00, 'New', 'WhatsApp', 'Pending'),
('Terrence Nakamura', 'terrence@example.com', '444555666', '202 Sun Ave', 22.99, 'Ready', 'UberEats', 'Paid'),
('Lena Morales', 'lena@example.com', '777888999', '303 Mars Ct', 18.50, 'Preparing', 'Rappi', 'Paid'),
('Jason Whitmore', 'jason@example.com', '222333444', '404 Jupiter Dr', 14.99, 'Ready', 'Web', 'Paid');


-- 10. Contact messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('New', 'Read', 'Replied') DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 11. Newsletter subscribers
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default site settings
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'Cosmic Burger'),
('site_tagline', 'Flipping the script on fast food.'),
('contact_phone', '+1 (555) COSMIC 1'),
('contact_email', 'hello@cosmicburger.space'),
('contact_address', '123 Orbit Avenue, Star City'),
('hero_title', 'Taste the Multiverse'),
('hero_text', 'Fresh burgers, fast checkout, and a smooth online order flow powered by your own database.'),
('hero_button_text', 'Order Now'),
('promo_code', 'COSMIC20'),
('currency_symbol', '$'),
('footer_text', 'Flipping the script on fast food since 2024. Join the revolution and taste the multiverse.'),
('instagram_url', '#'),
('facebook_url', '#'),
('twitter_url', '#'),
('business_hours', 'Daily 10:00 AM to 11:00 PM')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

-- Extended dynamic backend tables
CREATE TABLE IF NOT EXISTS product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS wishlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_wishlist (user_id, menu_item_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS product_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_item_id INT NOT NULL,
    user_id INT NULL,
    customer_name VARCHAR(150) NOT NULL,
    customer_email VARCHAR(150) NOT NULL,
    rating INT NOT NULL,
    review_text TEXT,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(80) NOT NULL UNIQUE,
    title VARCHAR(150) NOT NULL,
    discount_type ENUM('fixed', 'percent') DEFAULT 'fixed',
    discount_value DECIMAL(10,2) NOT NULL DEFAULT 0,
    min_order_amount DECIMAL(10,2) DEFAULT 0,
    max_uses INT DEFAULT NULL,
    used_count INT NOT NULL DEFAULT 0,
    starts_at DATETIME NULL,
    expires_at DATETIME NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS coupon_usages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    coupon_id INT NOT NULL,
    order_id INT NOT NULL,
    user_id INT NULL,
    amount_saved DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_time TIME NOT NULL,
    guest_count INT NOT NULL,
    special_note TEXT,
    status ENUM('Pending','Confirmed','Seated','Completed','Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL UNIQUE,
    slug VARCHAR(160) NOT NULL UNIQUE,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT,
    content LONGTEXT,
    image_url VARCHAR(255),
    status ENUM('draft','published') DEFAULT 'draft',
    is_featured TINYINT(1) DEFAULT 0,
    seo_title VARCHAR(255),
    seo_description TEXT,
    published_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(150) NOT NULL,
    customer_role VARCHAR(150),
    rating INT NOT NULL DEFAULT 5,
    testimonial_text TEXT NOT NULL,
    image_url VARCHAR(255),
    status ENUM('Pending','Published','Hidden') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    faq_group VARCHAR(100) DEFAULT 'General',
    sort_order INT DEFAULT 0,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS gallery_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    item_type ENUM('image','video') DEFAULT 'image',
    media_url VARCHAR(255) NOT NULL,
    category VARCHAR(100) DEFAULT 'General',
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    subtitle VARCHAR(255),
    button_text VARCHAR(100),
    button_url VARCHAR(255),
    image_url VARCHAR(255),
    banner_group VARCHAR(100) DEFAULT 'homepage',
    sort_order INT DEFAULT 0,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS delivery_zones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    zone_name VARCHAR(150) NOT NULL,
    postal_prefix VARCHAR(20),
    delivery_fee DECIMAL(10,2) NOT NULL DEFAULT 0,
    free_delivery_amount DECIMAL(10,2) DEFAULT NULL,
    estimated_time VARCHAR(100),
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(120) NOT NULL UNIQUE,
    page_title VARCHAR(200) NOT NULL,
    content LONGTEXT,
    seo_title VARCHAR(255),
    seo_description TEXT,
    status TINYINT(1) DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS payment_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    payment_method VARCHAR(80) NOT NULL,
    transaction_ref VARCHAR(150),
    amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('Pending','Paid','Failed','Refunded') DEFAULT 'Pending',
    payload_json JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_status_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    old_status VARCHAR(50),
    new_status VARCHAR(50) NOT NULL,
    note TEXT,
    changed_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (changed_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS seo_meta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    route_key VARCHAR(150) NOT NULL UNIQUE,
    meta_title VARCHAR(255),
    meta_description TEXT,
    canonical_url VARCHAR(255),
    og_title VARCHAR(255),
    og_description TEXT,
    og_image VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT IGNORE INTO blog_categories (name, slug) VALUES ('News','news'),('Offers','offers'),('Stories','stories');
INSERT IGNORE INTO pages (page_key, page_title, content) VALUES ('about','About Us','Tell your burger story here'),('contact','Contact','Contact us any time'),('privacy','Privacy Policy','Your privacy text'),('terms','Terms and Conditions','Your terms text');
INSERT IGNORE INTO delivery_zones (zone_name, postal_prefix, delivery_fee, free_delivery_amount, estimated_time) VALUES ('Central City','10',5.00,35.00,'25 to 35 minutes'),('North Side','20',7.00,50.00,'35 to 45 minutes');
INSERT IGNORE INTO banners (id, title, subtitle, button_text, button_url, image_url, banner_group, sort_order, status) VALUES (1,'Taste the Multiverse','Fresh and hot every day','Order Now','menu.php','https://picsum.photos/seed/hero/1200/700','homepage',1,1);
