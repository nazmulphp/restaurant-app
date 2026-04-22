document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('cosmic_token');
    const user = JSON.parse(localStorage.getItem('cosmic_user') || 'null');

    if (!token || !user) {
        window.location.href = 'admin-login.php';
        return;
    }

    const state = {
        users: [],
        categories: [],
        menu: [],
        inventory: [],
        suppliers: [],
        orders: [],
        orderFilter: 'all',
        salesChart: null,
    };

    const endpoints = {
        user: 'php-backend/users.php',
        category: 'php-backend/categories_api.php',
        menu: 'php-backend/admin_menu.php',
        inventory: 'php-backend/inventory.php',
        supplier: 'php-backend/suppliers.php',
        order: 'php-backend/orders_api.php',
    };

    const pages = Array.from(document.querySelectorAll('.page-panel'));
    const navItems = Array.from(document.querySelectorAll('.nav-item'));

    const initialsEl = document.querySelector('.user-initials');
    if (initialsEl && user.name) {
        initialsEl.textContent = user.name.split(' ').map(part => part[0]).join('').slice(0, 2).toUpperCase();
    }

    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            showPage(item.dataset.page);
        });
    });

    document.querySelectorAll('[data-target-page]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            showPage(link.dataset.targetPage);
        });
    });

    document.querySelectorAll('.page-action-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const page = btn.dataset.targetPage;
            if (page) showPage(page);
        });
    });

    document.addEventListener('click', (e) => {
        const openBtn = e.target.closest('[data-action="open-modal"]');
        if (openBtn) {
            e.preventDefault();
            openEntityModal(openBtn.dataset.entity, openBtn.dataset.id || null);
            return;
        }

        const deleteBtn = e.target.closest('[data-action="delete-entity"]');
        if (deleteBtn) {
            e.preventDefault();
            removeEntity(deleteBtn.dataset.entity, deleteBtn.dataset.id);
            return;
        }

        const closeBtn = e.target.closest('[data-action="close-modal"]');
        if (closeBtn) {
            e.preventDefault();
            closeModal(closeBtn.dataset.modalId);
            return;
        }

        const backdrop = e.target.closest('.modal-overlay');
        if (backdrop && e.target === backdrop) {
            backdrop.classList.remove('show'); backdrop.classList.remove('active');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.show, .modal-overlay.active').forEach(modal => { modal.classList.remove('show'); modal.classList.remove('active'); });
        }
    });

    document.getElementById('refresh-dashboard-btn')?.addEventListener('click', () => {
        hydrateAll();
        toast('Dashboard refreshed', 'success');
    });

    document.getElementById('logout-btn')?.addEventListener('click', async () => {
        try {
            await fetch('php-backend/logout.php', { method: 'POST' });
        } catch (e) {}
        localStorage.removeItem('cosmic_token');
        localStorage.removeItem('cosmic_user');
        window.location.href = 'admin-login.php';
    });

    document.querySelectorAll('[data-order-filter]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('[data-order-filter]').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            state.orderFilter = btn.dataset.orderFilter;
            renderOrdersHub();
        });
    });


    function entityStateKey(type) {
        return {
            user: 'users',
            category: 'categories',
            menu: 'menu',
            inventory: 'inventory',
            supplier: 'suppliers',
            order: 'orders'
        }[type];
    }

    function showPage(pageName) {
        const next = document.getElementById(`${pageName}-page`);
        if (!next) {
            toast('This page is not ready yet', 'error');
            return;
        }

        navItems.forEach(i => i.classList.toggle('active', i.dataset.page === pageName));
        pages.forEach(page => page.classList.remove('is-active'));
        next.classList.add('is-active');

        if (pageName === 'orders') renderOrdersTable();
        if (pageName === 'menu') {
            renderCategoriesTable();
            renderMenuTable();
        }
        if (pageName === 'inventory') renderInventoryTable();
        if (pageName === 'suppliers') renderSuppliersTable();
        if (pageName === 'users') renderUsersTable();
    }

    async function api(url, options = {}) {
        const res = await fetch(url, {
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                ...(options.headers || {}),
            },
            ...options,
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok || data.success === false || data.error) {
            throw new Error(data.message || data.error || 'Request failed');
        }
        return data;
    }

    function money(value) {
        return `$${Number(value || 0).toFixed(2)}`;
    }

    function safe(value) {
        return value == null || value === '' ? '—' : String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatDate(value) {
        if (!value) return '—';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return value;
        return date.toLocaleDateString();
    }

    function toast(message, type = 'success') {
        const wrap = document.getElementById('toast-container');
        const el = document.createElement('div');
        el.className = `toast toast-${type}`;
        el.textContent = message;
        wrap.appendChild(el);
        setTimeout(() => el.classList.add('show'), 10);
        setTimeout(() => {
            el.classList.remove('show');
            setTimeout(() => el.remove(), 250);
        }, 2500);
    }

    function fillForm(formId, item = {}) {
        const form = document.getElementById(formId);
        if (!form) return;
        form.reset();
        Array.from(form.elements).forEach(el => {
            if (!el.name) return;
            if (Object.prototype.hasOwnProperty.call(item, el.name)) {
                el.value = item[el.name] ?? '';
            }
        });
    }

    function collectForm(formId) {
        const form = document.getElementById(formId);
        const fd = new FormData(form);
        return Object.fromEntries(fd.entries());
    }

    window.openEntityModal = function(type, id = null) {
        if (type === 'menu') populateCategorySelect();
        const formId = `${type}-form`;
        const modalId = `${type}-modal`;
        const dataset = entityStateKey(type);
        const item = id == null ? null : (state[dataset] || []).find(entry => Number(entry.id) === Number(id));
        fillForm(formId, item || {});
        const modal = document.getElementById(modalId); if (modal) { modal.classList.add('show'); modal.classList.add('active'); }
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId); if (modal) { modal.classList.remove('show'); modal.classList.remove('active'); }
    };

    function bindForm(formId, type) {
        const form = document.getElementById(formId);
        if (!form) return;
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = collectForm(formId);
            const isEdit = payload.id && payload.id !== '';
            if (isEdit) payload._method = 'PUT';
            try {
                await api(endpoints[type], {
                    method: 'POST',
                    body: JSON.stringify(payload),
                });
                closeModal(`${type}-modal`);
                await hydrateEntity(type);
                await hydrateDashboard();
                toast(`${type.charAt(0).toUpperCase() + type.slice(1)} saved`, 'success');
            } catch (error) {
                toast(error.message, 'error');
            }
        });
    }

    bindForm('user-form', 'user');
    bindForm('category-form', 'category');
    bindForm('menu-form', 'menu');
    bindForm('inventory-form', 'inventory');
    bindForm('supplier-form', 'supplier');
    bindForm('order-form', 'order');

    async function removeEntity(type, id) {
        if (!window.confirm('Delete this item?')) return;
        try {
            await api(endpoints[type], { method: 'POST', body: JSON.stringify({ id, _method: 'DELETE' }) });
            await hydrateEntity(type);
            await hydrateDashboard();
            toast('Deleted successfully', 'success');
        } catch (error) {
            toast(error.message, 'error');
        }
    }

    window.deleteEntity = removeEntity;

    async function hydrateEntity(type) {
        const data = await api(endpoints[type]);
        state[entityStateKey(type)] = data.items || [];
        if (type === 'user') renderUsersTable();
        if (type === 'category') {
            renderCategoriesTable();
            populateCategorySelect();
        }
        if (type === 'menu') renderMenuTable();
        if (type === 'inventory') renderInventoryTable();
        if (type === 'supplier') renderSuppliersTable();
        if (type === 'order') {
            renderOrdersTable();
            renderOrdersHub();
        }
    }

    async function hydrateAll() {
        await Promise.all([
            hydrateEntity('user'),
            hydrateEntity('category'),
            hydrateEntity('menu'),
            hydrateEntity('inventory'),
            hydrateEntity('supplier'),
            hydrateEntity('order'),
        ]);
        hydrateDashboard();
    }

    async function hydrateDashboard() {
        try {
            const stats = await api('php-backend/dashboard_stats.php');
            document.getElementById('stat-sales').textContent = money(stats.salesToday);
            document.getElementById('stat-orders').textContent = stats.activeOrders ?? 0;
            document.getElementById('stat-low-stock').textContent = stats.lowStock ?? 0;
            document.getElementById('stat-top-selling').textContent = stats.topSelling || 'N A';
        } catch (error) {
            document.getElementById('stat-sales').textContent = money(sumSalesToday());
            document.getElementById('stat-orders').textContent = state.orders.filter(item => ['New', 'Preparing', 'Ready'].includes(item.status)).length;
            document.getElementById('stat-low-stock').textContent = state.inventory.filter(item => item.status !== 'OK').length;
            document.getElementById('stat-top-selling').textContent = state.menu[0]?.name || 'N A';
        }

        document.getElementById('stat-users').textContent = state.users.length;
        document.getElementById('stat-orders-sub').textContent = `${state.orders.filter(item => item.status === 'New').length} new • ${state.orders.filter(item => item.status === 'Preparing').length} preparing • ${state.orders.filter(item => item.status === 'Ready').length} ready`;
        document.getElementById('badge-orders').textContent = state.orders.filter(item => ['New', 'Preparing', 'Ready'].includes(item.status)).length;
        document.getElementById('badge-inventory').textContent = state.inventory.filter(item => item.status !== 'OK').length;

        renderOrdersHub();
        renderInventoryOverview();
        renderSuppliersOverview();
        renderTopMenu();
        renderSalesChart();
        updateTime();
    }

    function sumSalesToday() {
        const today = new Date().toDateString();
        return state.orders.filter(item => new Date(item.created_at).toDateString() === today).reduce((sum, item) => sum + Number(item.total_amount || 0), 0);
    }

    function populateCategorySelect() {
        const select = document.getElementById('menu-category-select');
        if (!select) return;
        select.innerHTML = '<option value="">No Category</option>' + state.categories.map(item => `<option value="${item.id}">${safe(item.name)}</option>`).join('');
    }

    function renderUsersTable() {
        const tbody = document.getElementById('users-table-body');
        if (!tbody) return;
        tbody.innerHTML = state.users.map(item => `
            <tr>
                <td>${item.id}</td>
                <td>${safe(item.name)}</td>
                <td>${safe(item.email)}</td>
                <td><span class="status-pill mini-pill">${safe(item.role)}</span></td>
                <td>${safe(item.phone)}</td>
                <td>${formatDate(item.created_at)}</td>
                <td class="action-cell"><button class="icon-btn" data-action="open-modal" data-entity="user" data-id="${item.id}"><i data-lucide="pencil"></i></button><button class="icon-btn text-red" data-action="delete-entity" data-entity="user" data-id="${item.id}"><i data-lucide="trash-2"></i></button></td>
            </tr>
        `).join('') || '<tr><td colspan="7" class="empty-cell">No users found</td></tr>';
        lucide.createIcons();
    }

    function renderCategoriesTable() {
        const tbody = document.getElementById('categories-table-body');
        if (!tbody) return;
        tbody.innerHTML = state.categories.map(item => `
            <tr>
                <td>${item.id}</td>
                <td>${safe(item.name)}</td>
                <td>${safe(item.slug)}</td>
                <td>${Number(item.status) === 1 ? 'Active' : 'Hidden'}</td>
                <td class="action-cell"><button class="icon-btn" data-action="open-modal" data-entity="category" data-id="${item.id}"><i data-lucide="pencil"></i></button><button class="icon-btn text-red" data-action="delete-entity" data-entity="category" data-id="${item.id}"><i data-lucide="trash-2"></i></button></td>
            </tr>
        `).join('') || '<tr><td colspan="5" class="empty-cell">No categories found</td></tr>';
        lucide.createIcons();
    }

    function renderMenuTable() {
        const tbody = document.getElementById('menu-table-body');
        if (!tbody) return;
        tbody.innerHTML = state.menu.map(item => `
            <tr>
                <td>${item.id}</td>
                <td>${safe(item.name)}</td>
                <td>${safe(item.category_name)}</td>
                <td>${money(item.price)}</td>
                <td>${safe(item.stock_qty)}</td>
                <td>${Number(item.is_available) === 1 ? 'Available' : 'Hidden'}</td>
                <td class="action-cell"><button class="icon-btn" data-action="open-modal" data-entity="menu" data-id="${item.id}"><i data-lucide="pencil"></i></button><button class="icon-btn text-red" data-action="delete-entity" data-entity="menu" data-id="${item.id}"><i data-lucide="trash-2"></i></button></td>
            </tr>
        `).join('') || '<tr><td colspan="7" class="empty-cell">No menu items found</td></tr>';
        lucide.createIcons();
    }

    function renderInventoryTable() {
        const tbody = document.getElementById('inventory-table-body');
        if (!tbody) return;
        tbody.innerHTML = state.inventory.map(item => `
            <tr>
                <td>${item.id}</td>
                <td>${safe(item.item_name)}</td>
                <td>${safe(item.current_stock)}</td>
                <td>${safe(item.min_stock)}</td>
                <td>${safe(item.unit)}</td>
                <td>${safe(item.status)}</td>
                <td class="action-cell"><button class="icon-btn" data-action="open-modal" data-entity="inventory" data-id="${item.id}"><i data-lucide="pencil"></i></button><button class="icon-btn text-red" data-action="delete-entity" data-entity="inventory" data-id="${item.id}"><i data-lucide="trash-2"></i></button></td>
            </tr>
        `).join('') || '<tr><td colspan="7" class="empty-cell">No inventory found</td></tr>';
        lucide.createIcons();
    }

    function renderSuppliersTable() {
        const tbody = document.getElementById('suppliers-table-body');
        if (!tbody) return;
        tbody.innerHTML = state.suppliers.map(item => `
            <tr>
                <td>${item.id}</td>
                <td>${safe(item.name)}</td>
                <td>${safe(item.contact_person)}</td>
                <td>${safe(item.phone)}</td>
                <td>${safe(item.status)}</td>
                <td>${safe(item.delivery_days)}</td>
                <td class="action-cell"><button class="icon-btn" data-action="open-modal" data-entity="supplier" data-id="${item.id}"><i data-lucide="pencil"></i></button><button class="icon-btn text-red" data-action="delete-entity" data-entity="supplier" data-id="${item.id}"><i data-lucide="trash-2"></i></button></td>
            </tr>
        `).join('') || '<tr><td colspan="7" class="empty-cell">No suppliers found</td></tr>';
        lucide.createIcons();
    }

    function renderOrdersTable() {
        const tbody = document.getElementById('orders-table-body');
        if (!tbody) return;
        tbody.innerHTML = state.orders.map(item => `
            <tr>
                <td>#${item.id}</td>
                <td>${safe(item.customer_name)}</td>
                <td>${money(item.total_amount)}</td>
                <td>${safe(item.status)}</td>
                <td>${safe(item.payment_status)}</td>
                <td>${safe(item.source)}</td>
                <td>${formatDate(item.created_at)}</td>
                <td class="action-cell"><button class="icon-btn" data-action="open-modal" data-entity="order" data-id="${item.id}"><i data-lucide="pencil"></i></button><button class="icon-btn text-red" data-action="delete-entity" data-entity="order" data-id="${item.id}"><i data-lucide="trash-2"></i></button></td>
            </tr>
        `).join('') || '<tr><td colspan="8" class="empty-cell">No orders found</td></tr>';
        lucide.createIcons();
    }

    function renderOrdersHub() {
        const grid = document.getElementById('orders-hub-grid');
        if (!grid) return;
        const items = state.orderFilter === 'all' ? state.orders.slice(0, 6) : state.orders.filter(item => item.status === state.orderFilter).slice(0, 6);
        grid.innerHTML = items.map(item => `
            <div class="order-card">
                <div class="order-header"><span class="order-id">#${item.id}</span><span class="order-status-tag tag-${String(item.status || '').toLowerCase()}">${safe(item.status)}</span></div>
                <div class="order-customer">${safe(item.customer_name)}</div>
                <div class="order-items">${safe(item.delivery_address)}</div>
                <div class="order-footer"><span class="payment-status ${String(item.payment_status || '').toLowerCase()}">${safe(item.payment_status)}</span><span class="order-time">${money(item.total_amount)}</span></div>
            </div>
        `).join('') || '<div class="empty-box">No orders found</div>';
    }

    function renderInventoryOverview() {
        const wrap = document.getElementById('inventory-list');
        if (!wrap) return;
        wrap.innerHTML = state.inventory.slice(0, 5).map(item => `
            <div class="list-item inventory-item">
                <div class="inventory-icon"><i data-lucide="package"></i></div>
                <div class="inventory-details"><div class="item-info"><span class="item-name">${safe(item.item_name)}</span><span class="item-sub">Min ${safe(item.min_stock)} ${safe(item.unit)}</span></div><div class="stock-info"><span class="stock-value">${safe(item.current_stock)}</span><span class="stock-status status-${String(item.status || '').toLowerCase()}">${safe(item.status)}</span></div></div>
            </div>
        `).join('') || '<div class="empty-box">No inventory found</div>';
        lucide.createIcons();
    }

    function renderSuppliersOverview() {
        const wrap = document.getElementById('suppliers-list');
        if (!wrap) return;
        wrap.innerHTML = state.suppliers.slice(0, 4).map(item => `
            <div class="list-item"><div class="item-info"><span class="item-name">${safe(item.name)}</span><span class="item-sub">${safe(item.category)}</span></div><span class="status-label status-${String(item.status || '').toLowerCase()}">${safe(item.status)}</span></div>
        `).join('') || '<div class="empty-box">No suppliers found</div>';
    }

    function renderTopMenu() {
        const wrap = document.getElementById('top-menu-list');
        if (!wrap) return;
        wrap.innerHTML = state.menu.slice(0, 5).map(item => `
            <div class="top-menu-item"><img src="${safe(item.image_url || 'assets/img/burger-image.png')}" class="menu-item-img" alt="${safe(item.name)}"><div class="menu-item-details"><div class="item-info"><span class="item-name">${safe(item.name)}</span><span class="item-sub">${safe(item.category_name)}</span></div><span class="menu-item-price">${money(item.price)}</span></div></div>
        `).join('') || '<div class="empty-box">No menu items found</div>';
    }

    function renderSalesChart() {
        const ctx = document.getElementById('sales-chart');
        if (!ctx) return;
        const labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const values = [0, 0, 0, 0, 0, 0, 0];
        state.orders.forEach(item => {
            const d = new Date(item.created_at);
            const idx = (d.getDay() + 6) % 7;
            values[idx] += Number(item.total_amount || 0);
        });
        if (state.salesChart) state.salesChart.destroy();
        state.salesChart = new Chart(ctx, {
            type: 'line',
            data: { labels, datasets: [{ label: 'Sales', data: values, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.15)', tension: 0.35, fill: true }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.08)' } }, x: { ticks: { color: '#94a3b8' }, grid: { display: false } } } }
        });
    }

    function updateTime() {
        const timeEl = document.getElementById('current-time');
        if (!timeEl) return;
        const now = new Date();
        timeEl.textContent = now.toLocaleString('en-US', { weekday: 'short', month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true });
    }

    if (window.lucide) lucide.createIcons();
    updateTime();
    setInterval(updateTime, 60000);
    hydrateAll();
    setInterval(() => {
        hydrateEntity('order').then(hydrateDashboard).catch(() => {});
    }, 30000);
});
