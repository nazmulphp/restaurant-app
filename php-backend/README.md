# PHP Backend for Cosmic Burger

This directory contains the PHP equivalent of the Node.js backend used in the preview.

## Setup on Hostinger

1.  Upload all files in this directory to a folder on your Hostinger server (e.g., `/api/`).
2.  The `config.php` is already configured with your credentials.
3.  Update your frontend `fetch` calls to point to these PHP files.
    *   Example: `fetch('/api/menu')` -> `fetch('/api/get_menu.php')`
    *   Example: `fetch('/api/orders')` -> `fetch('/api/place_order.php')`
    *   Example: `fetch('/api/admin/menu')` -> `fetch('/api/admin_menu.php')`

## Database Schema

The `schema.sql` file in the root directory contains the SQL needed to create the tables. The Node.js preview has already initialized these tables in your database.

## Endpoints

- `get_menu.php`: GET - Fetch all available menu items.
- `place_order.php`: POST - Store a new order.
- `admin_menu.php`: POST/PUT/DELETE - Manage menu items (requires `?id=X` for PUT/DELETE).
- `settings.php`: GET/POST - Manage site settings.
