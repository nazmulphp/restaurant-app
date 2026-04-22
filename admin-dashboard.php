<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmic Burger | Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="admin-body">
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon"></div>
                    <span class="logo-text">Cosmic Burger</span>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="#" class="nav-item active" data-page="dashboard"><i data-lucide="layout-dashboard"></i><span>Dashboard</span></a>
                <a href="#" class="nav-item" data-page="orders"><i data-lucide="shopping-bag"></i><span>Orders</span><span class="badge badge-green" id="badge-orders">0</span></a>
                <a href="#" class="nav-item" data-page="menu"><i data-lucide="utensils-crossed"></i><span>Menu</span></a>
                <a href="#" class="nav-item" data-page="inventory"><i data-lucide="package"></i><span>Inventory</span><span class="badge badge-red" id="badge-inventory">0</span></a>
                <a href="#" class="nav-item" data-page="suppliers"><i data-lucide="users"></i><span>Suppliers</span></a>
                <a href="#" class="nav-item" data-page="users"><i data-lucide="user-cog"></i><span>Users</span></a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <div class="location-selector">
                        <i data-lucide="map-pin"></i>
                        <span>Downtown Location</span>
                        <i data-lucide="chevron-down"></i>
                    </div>
                </div>
                <div class="header-right">
                    <div class="date-time">
                        <i data-lucide="clock"></i>
                        <span id="current-time">Tue, Jun 10 - 2:34 PM</span>
                        <span class="status-pill">LIVE</span>
                    </div>
                    <div class="header-actions">
                        <button class="icon-btn" id="refresh-dashboard-btn" title="Refresh"><i data-lucide="refresh-cw"></i></button>
                        <button class="btn btn-green page-action-btn" data-target-page="orders">New Order</button>
                        <button class="btn btn-blue page-action-btn" data-target-page="menu">Add Menu Item</button>
                        <button class="btn btn-purple" id="logout-btn">Logout</button>
                        <div class="user-profile"><span class="user-initials">CB</span></div>
                    </div>
                </div>
            </header>

            <div class="content-area page-panel is-active" id="dashboard-page">
                <div class="stats-grid">
                    <div class="stat-card"><div class="stat-header"><span class="stat-label">Sales Today</span><span class="stat-trend trend-up">Live</span></div><div class="stat-value" id="stat-sales">$0</div></div>
                    <div class="stat-card"><div class="stat-header"><span class="stat-label">Active Orders</span><span class="stat-icon icon-purple"><i data-lucide="shopping-cart"></i></span></div><div class="stat-value" id="stat-orders">0</div><div class="stat-sub" id="stat-orders-sub">0 new</div></div>
                    <div class="stat-card"><div class="stat-header"><span class="stat-label">Low Stock Alerts</span><span class="stat-icon icon-red"><i data-lucide="alert-triangle"></i></span></div><div class="stat-value" id="stat-low-stock">0</div><div class="stat-sub text-red">Inventory items below target</div></div>
                    <div class="stat-card"><div class="stat-header"><span class="stat-label">Top Selling</span><span class="stat-icon icon-orange"><i data-lucide="flame"></i></span></div><div class="stat-value" id="stat-top-selling">N A</div><div class="stat-sub">By reviews</div></div>
                    <div class="stat-card"><div class="stat-header"><span class="stat-label">Users</span><span class="stat-icon icon-yellow"><i data-lucide="users"></i></span></div><div class="stat-value" id="stat-users">0</div><div class="stat-sub">Admin and customer accounts</div></div>
                </div>

                <div class="dashboard-grid">
                    <div class="card orders-hub">
                        <div class="card-header">
                            <div class="header-title"><h3>Orders Hub</h3><span class="live-indicator">LIVE</span></div>
                            <div class="header-filters">
                                <button class="filter-btn active" data-order-filter="all">All</button>
                                <button class="filter-btn" data-order-filter="New">New</button>
                                <button class="filter-btn" data-order-filter="Preparing">Preparing</button>
                                <button class="filter-btn" data-order-filter="Ready">Ready</button>
                            </div>
                        </div>
                        <div class="orders-grid" id="orders-hub-grid"></div>
                    </div>

                    <div class="dashboard-sidebar">
                        <div class="card suppliers-card">
                            <div class="card-header"><h3>Suppliers</h3><a href="#" class="view-all" data-target-page="suppliers">All →</a></div>
                            <div class="suppliers-list" id="suppliers-list"></div>
                        </div>
                        <div class="card po-card">
                            <div class="card-header"><h3>Quick Actions</h3><a href="#" class="view-all" data-target-page="users">Open →</a></div>
                            <div class="po-list quick-links">
                                <button class="btn btn-gray-outline wide-btn page-action-btn" data-target-page="users">Manage Users</button>
                                <button class="btn btn-gray-outline wide-btn page-action-btn" data-target-page="inventory">Manage Inventory</button>
                                <button class="btn btn-gray-outline wide-btn page-action-btn" data-target-page="menu">Manage Menu</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-bottom-grid">
                    <div class="card inventory-card">
                        <div class="card-header"><h3>Inventory Overview</h3><a href="#" class="view-all" data-target-page="inventory">View All →</a></div>
                        <div class="inventory-list" id="inventory-list"></div>
                    </div>
                    <div class="card sales-chart-card">
                        <div class="card-header"><h3>Sales This Week</h3><span class="view-all">Updated now</span></div>
                        <div class="chart-container"><canvas id="sales-chart"></canvas></div>
                    </div>
                    <div class="card top-menu-card">
                        <div class="card-header"><h3>Top Menu Items</h3><a href="#" class="view-all" data-target-page="menu">Full Menu →</a></div>
                        <div class="top-menu-list" id="top-menu-list"></div>
                    </div>
                </div>
            </div>

            <div class="content-area page-panel" id="orders-page">
                <div class="card">
                    <div class="card-header"><h3>Orders CRUD</h3><button class="btn btn-blue" data-action="open-modal" data-entity="order">Add Order</button></div>
                    <div class="table-responsive"><table class="admin-table"><thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Payment</th><th>Source</th><th>Created</th><th>Actions</th></tr></thead><tbody id="orders-table-body"></tbody></table></div>
                </div>
            </div>

            <div class="content-area page-panel" id="menu-page">
                <div class="card stack-card">
                    <div class="card-header"><h3>Categories CRUD</h3><button class="btn btn-blue" data-action="open-modal" data-entity="category">Add Category</button></div>
                    <div class="table-responsive"><table class="admin-table"><thead><tr><th>ID</th><th>Name</th><th>Slug</th><th>Status</th><th>Actions</th></tr></thead><tbody id="categories-table-body"></tbody></table></div>
                </div>
                <div class="card">
                    <div class="card-header"><h3>Menu CRUD</h3><button class="btn btn-blue" data-action="open-modal" data-entity="menu">Add Menu Item</button></div>
                    <div class="table-responsive"><table class="admin-table"><thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead><tbody id="menu-table-body"></tbody></table></div>
                </div>
            </div>

            <div class="content-area page-panel" id="inventory-page">
                <div class="card">
                    <div class="card-header"><h3>Inventory CRUD</h3><button class="btn btn-blue" data-action="open-modal" data-entity="inventory">Add Inventory</button></div>
                    <div class="table-responsive"><table class="admin-table"><thead><tr><th>ID</th><th>Item</th><th>Stock</th><th>Min</th><th>Unit</th><th>Status</th><th>Actions</th></tr></thead><tbody id="inventory-table-body"></tbody></table></div>
                </div>
            </div>

            <div class="content-area page-panel" id="suppliers-page">
                <div class="card">
                    <div class="card-header"><h3>Suppliers CRUD</h3><button class="btn btn-blue" data-action="open-modal" data-entity="supplier">Add Supplier</button></div>
                    <div class="table-responsive"><table class="admin-table"><thead><tr><th>ID</th><th>Name</th><th>Contact</th><th>Phone</th><th>Status</th><th>Delivery</th><th>Actions</th></tr></thead><tbody id="suppliers-table-body"></tbody></table></div>
                </div>
            </div>

            <div class="content-area page-panel" id="users-page">
                <div class="card">
                    <div class="card-header"><h3>Users CRUD</h3><button class="btn btn-blue" data-action="open-modal" data-entity="user">Add New User</button></div>
                    <div class="table-responsive"><table class="admin-table"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Phone</th><th>Joined</th><th>Actions</th></tr></thead><tbody id="users-table-body"></tbody></table></div>
                </div>
            </div>
        </main>
    </div>

    <div class="toast-container" id="toast-container"></div>

    <div id="user-modal" class="modal-overlay"><div class="admin-modal"><h2 class="text-display">User</h2><form id="user-form" class="entity-form"><input type="hidden" name="id"><div class="form-grid"><div class="form-group"><label>Name</label><input type="text" name="name" required></div><div class="form-group"><label>Email</label><input type="email" name="email" required></div><div class="form-group"><label>Password</label><input type="password" name="password" placeholder="Leave empty for no change"></div><div class="form-group"><label>Role</label><select name="role"><option>Admin</option><option>Manager</option><option>Store Manager</option><option>Kitchen Admin</option><option>Vendor</option><option>Customer</option></select></div><div class="form-group"><label>Phone</label><input type="text" name="phone"></div><div class="form-group"><label>Address</label><input type="text" name="address"></div></div><div class="modal-actions"><button type="button" class="btn btn-gray-outline" data-action="close-modal" data-modal-id="user-modal">Cancel</button><button type="submit" class="btn btn-blue">Save User</button></div></form></div></div>

    <div id="category-modal" class="modal-overlay"><div class="admin-modal"><h2 class="text-display">Category</h2><form id="category-form" class="entity-form"><input type="hidden" name="id"><div class="form-grid"><div class="form-group"><label>Name</label><input type="text" name="name" required></div><div class="form-group"><label>Slug</label><input type="text" name="slug"></div><div class="form-group"><label>Image Url</label><input type="text" name="image_url"></div><div class="form-group"><label>Status</label><select name="status"><option value="1">Active</option><option value="0">Hidden</option></select></div></div><div class="modal-actions"><button type="button" class="btn btn-gray-outline" data-action="close-modal" data-modal-id="category-modal">Cancel</button><button type="submit" class="btn btn-blue">Save Category</button></div></form></div></div>

    <div id="menu-modal" class="modal-overlay"><div class="admin-modal"><h2 class="text-display">Menu Item</h2><form id="menu-form" class="entity-form"><input type="hidden" name="id"><div class="form-grid"><div class="form-group"><label>Name</label><input type="text" name="name" required></div><div class="form-group"><label>Category</label><select name="category_id" id="menu-category-select"></select></div><div class="form-group full-width"><label>Description</label><textarea name="description" rows="3"></textarea></div><div class="form-group"><label>Price</label><input type="number" step="0.01" name="price" required></div><div class="form-group"><label>Sale Price</label><input type="number" step="0.01" name="sale_price"></div><div class="form-group"><label>Stock Qty</label><input type="number" name="stock_qty"></div><div class="form-group"><label>Image Url</label><input type="text" name="image_url"></div><div class="form-group"><label>Slug</label><input type="text" name="slug"></div><div class="form-group"><label>Status</label><select name="is_available"><option value="1">Available</option><option value="0">Hidden</option></select></div><div class="form-group"><label>Featured</label><select name="is_featured"><option value="0">No</option><option value="1">Yes</option></select></div></div><div class="modal-actions"><button type="button" class="btn btn-gray-outline" data-action="close-modal" data-modal-id="menu-modal">Cancel</button><button type="submit" class="btn btn-blue">Save Menu Item</button></div></form></div></div>

    <div id="inventory-modal" class="modal-overlay"><div class="admin-modal"><h2 class="text-display">Inventory</h2><form id="inventory-form" class="entity-form"><input type="hidden" name="id"><div class="form-grid"><div class="form-group"><label>Item Name</label><input type="text" name="item_name" required></div><div class="form-group"><label>Current Stock</label><input type="number" name="current_stock" required></div><div class="form-group"><label>Min Stock</label><input type="number" name="min_stock" required></div><div class="form-group"><label>Unit</label><input type="text" name="unit" value="units"></div><div class="form-group"><label>Status</label><select name="status"><option>OK</option><option>LOW</option><option>CRITICAL</option></select></div></div><div class="modal-actions"><button type="button" class="btn btn-gray-outline" data-action="close-modal" data-modal-id="inventory-modal">Cancel</button><button type="submit" class="btn btn-blue">Save Inventory</button></div></form></div></div>

    <div id="supplier-modal" class="modal-overlay"><div class="admin-modal"><h2 class="text-display">Supplier</h2><form id="supplier-form" class="entity-form"><input type="hidden" name="id"><div class="form-grid"><div class="form-group"><label>Name</label><input type="text" name="name" required></div><div class="form-group"><label>Contact Person</label><input type="text" name="contact_person"></div><div class="form-group"><label>Phone</label><input type="text" name="phone"></div><div class="form-group"><label>Email</label><input type="email" name="email"></div><div class="form-group"><label>Category</label><input type="text" name="category"></div><div class="form-group"><label>Status</label><select name="status"><option>ACTIVE</option><option>DELAYED</option><option>INACTIVE</option></select></div><div class="form-group full-width"><label>Delivery Days</label><input type="text" name="delivery_days"></div></div><div class="modal-actions"><button type="button" class="btn btn-gray-outline" data-action="close-modal" data-modal-id="supplier-modal">Cancel</button><button type="submit" class="btn btn-blue">Save Supplier</button></div></form></div></div>

    <div id="order-modal" class="modal-overlay"><div class="admin-modal"><h2 class="text-display">Order</h2><form id="order-form" class="entity-form"><input type="hidden" name="id"><div class="form-grid"><div class="form-group"><label>Customer Name</label><input type="text" name="customer_name" required></div><div class="form-group"><label>Email</label><input type="email" name="customer_email"></div><div class="form-group"><label>Phone</label><input type="text" name="customer_phone"></div><div class="form-group"><label>Total Amount</label><input type="number" step="0.01" name="total_amount" required></div><div class="form-group full-width"><label>Address</label><input type="text" name="delivery_address"></div><div class="form-group"><label>Status</label><select name="status"><option>New</option><option>Preparing</option><option>Ready</option><option>Delivered</option><option>Cancelled</option></select></div><div class="form-group"><label>Payment</label><select name="payment_status"><option>Pending</option><option>Paid</option></select></div><div class="form-group"><label>Source</label><select name="source"><option>Web</option><option>UberEats</option><option>Rappi</option><option>WhatsApp</option><option>POS</option></select></div><div class="form-group full-width"><label>Note</label><input type="text" name="note"></div></div><div class="modal-actions"><button type="button" class="btn btn-gray-outline" data-action="close-modal" data-modal-id="order-modal">Cancel</button><button type="submit" class="btn btn-blue">Save Order</button></div></form></div></div>

    <script src="assets/js/admin-dashboard.js"></script>
    
</body>
</html>
