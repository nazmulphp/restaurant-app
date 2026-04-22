<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Cosmic Burger</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 100px auto;
            padding: 2rem;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .admin-table th, .admin-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .admin-table th {
            background: #f8f9fa;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #666;
        }
        .admin-actions {
            display: flex;
            gap: 0.5rem;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .admin-modal {
            background: white;
            padding: 2rem;
            border-radius: 1.5rem;
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body style="background: #f4f7f6;">
    <div class="admin-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 class="text-display">Menu Management</h1>
            <button class="btn btn-primary" onclick="openAddModal()">+ Add New Item</button>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="admin-menu-body">
                <!-- Data will be injected here -->
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Modal -->
    <div id="admin-modal" class="modal-overlay">
        <div class="admin-modal">
            <h2 id="modal-title" class="text-display" style="margin-bottom: 1.5rem;">Add Menu Item</h2>
            <form id="menu-form">
                <input type="hidden" id="item-id">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="item-name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select id="item-category" class="form-control" required>
                        <!-- Categories will be injected here -->
                    </select>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" id="item-price" step="0.01" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="item-desc" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Image URL</label>
                    <input type="text" id="item-image" class="form-control" required>
                </div>
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeAdminModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/admin.js"></script>
</body>
</html>
