document.addEventListener('DOMContentLoaded', () => {
    const menuBody = document.getElementById('admin-menu-body');
    const categorySelect = document.getElementById('item-category');
    const menuForm = document.getElementById('menu-form');
    const adminModal = document.getElementById('admin-modal');
    
    let categories = [];

    async function fetchData() {
        try {
            const [menuRes, catRes] = await Promise.all([
                fetch('php-backend/get_menu.php'),
                fetch('php-backend/get_categories.php')
            ]);
            
            const menu = await menuRes.json();
            categories = await catRes.json();
            
            renderCategories();
            renderMenu(menu);
        } catch (error) {
            console.error("Fetch error:", error);
        }
    }

    function renderCategories() {
        categorySelect.innerHTML = categories.map(c => `
            <option value="${c.id}">${c.name}</option>
        `).join('');
    }

    function renderMenu(menu) {
        menuBody.innerHTML = menu.map(item => `
            <tr>
                <td><img src="${item.image_url}" width="50" height="50" style="border-radius: 8px; object-fit: cover;"></td>
                <td style="font-weight: 700;">${item.name}</td>
                <td>${item.category_name}</td>
                <td>$${item.price}</td>
                <td>
                    <span style="padding: 4px 8px; border-radius: 999px; font-size: 0.7rem; background: ${item.is_available ? '#e6f4ea' : '#fce8e6'}; color: ${item.is_available ? '#1e7e34' : '#d93025'};">
                        ${item.is_available ? 'Available' : 'Sold Out'}
                    </span>
                </td>
                <td>
                    <div class="admin-actions">
                        <button class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.7rem;" onclick="editItem(${JSON.stringify(item).replace(/"/g, '&quot;')})">Edit</button>
                        <button class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.7rem; color: #d93025; border-color: #fce8e6;" onclick="deleteItem(${item.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    window.openAddModal = () => {
        document.getElementById('modal-title').textContent = "Add Menu Item";
        document.getElementById('item-id').value = "";
        menuForm.reset();
        adminModal.style.display = 'flex';
    };

    window.closeAdminModal = () => {
        adminModal.style.display = 'none';
    };

    window.editItem = (item) => {
        document.getElementById('modal-title').textContent = "Edit Menu Item";
        document.getElementById('item-id').value = item.id;
        document.getElementById('item-name').value = item.name;
        document.getElementById('item-category').value = item.category_id;
        document.getElementById('item-price').value = item.price;
        document.getElementById('item-desc').value = item.description;
        document.getElementById('item-image').value = item.image_url;
        adminModal.style.display = 'flex';
    };

    window.deleteItem = async (id) => {
        if (confirm("Are you sure you want to delete this item?")) {
            try {
                const res = await fetch(`php-backend/admin_menu.php?id=${id}`, { method: 'DELETE' });
                if (res.ok) fetchData();
            } catch (error) {
                console.error("Delete error:", error);
            }
        }
    };

    menuForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('item-id').value;
        const data = {
            name: document.getElementById('item-name').value,
            category_id: document.getElementById('item-category').value,
            price: document.getElementById('item-price').value,
            description: document.getElementById('item-desc').value,
            image_url: document.getElementById('item-image').value,
            is_available: true
        };

        const url = id ? `php-backend/admin_menu.php?id=${id}` : 'php-backend/admin_menu.php';
        const method = id ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            if (res.ok) {
                closeAdminModal();
                fetchData();
            }
        } catch (error) {
            console.error("Save error:", error);
        }
    });

    fetchData();
});
