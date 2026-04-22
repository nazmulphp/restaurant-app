window.MENU_ITEMS = [];

async function fetchMenu() {
  try {
    const response = await fetch('php-backend/get_menu.php');
    const data = await response.json();
    // Map database fields to frontend fields
    window.MENU_ITEMS = data.map(item => ({
      id: item.id,
      name: item.name,
      category: item.category_name,
      price: parseFloat(item.price),
      image: item.image_url,
      desc: item.description,
      rating: parseFloat(item.rating || 4.5),
      reviews: parseInt(item.reviews || 0, 10),
      modifiers: item.category_name === 'Burgers' ? ["Extra Cheese", "Bacon", "Double Patty", "No Onion"] : []
    }));
    
    // Dispatch event to notify menu.js that data is ready
    window.dispatchEvent(new CustomEvent('menuLoaded'));
  } catch (error) {
    console.error("Failed to fetch menu:", error);
  }
}

fetchMenu();

const TAX_RATES = {
  'ON': 0.13,
  'QC': 0.14975,
  'BC': 0.12,
  'AB': 0.05,
  'MB': 0.12,
  'SK': 0.11,
  'NS': 0.15,
  'NB': 0.15,
  'NL': 0.15,
  'PE': 0.15
};

// Cart Logic
const getCart = () => JSON.parse(sessionStorage.getItem('cosmic_cart') || '[]');
const saveCart = (cart) => {
  sessionStorage.setItem('cosmic_cart', JSON.stringify(cart));
  if (typeof updateCartUI === 'function') updateCartUI();
};

window.updateCartQty = function(id, delta) {
  const cart = getCart();
  const item = cart.find(i => i.id === id);
  if (item) {
    item.quantity += delta;
    if (item.quantity <= 0) {
      removeFromCart(id);
      return;
    }
    saveCart(cart);
    renderCheckout();
  }
};

window.removeFromCart = function(id) {
  let cart = getCart();
  cart = cart.filter(item => item.id !== id);
  saveCart(cart);
  updateCartUI();
  
  // If we are on the checkout page, re-render it
  if (window.location.pathname.includes('order.php')) {
    renderCheckout();
  }
  
  // If mini-cart is open, refresh it
  const feedback = document.querySelector('.cart-feedback');
  if (feedback && feedback.classList.contains('active')) {
    if (cart.length > 0) {
      showCartFeedback();
    } else {
      feedback.classList.remove('active');
    }
  }
};

function renderCheckout() {
  const cart = getCart();
  const listContainer = document.getElementById('cart-items-list');
  const emptyMsg = document.getElementById('empty-cart-msg');
  const checkoutContent = document.getElementById('checkout-content');

  if (!listContainer) return;

  if (cart.length === 0) {
    emptyMsg.style.display = 'block';
    checkoutContent.style.display = 'none';
    return;
  }

  emptyMsg.style.display = 'none';
  checkoutContent.style.display = 'grid';

  listContainer.innerHTML = cart.map(item => `
    <div class="cart-item">
      <img src="${item.image}" alt="${item.name}" class="cart-item-img">
      <div class="cart-item-info">
        <div style="display: flex; justify-content: space-between;">
          <h4 style="font-family: var(--font-display); font-size: 1rem;">${item.name}</h4>
          <span style="font-weight: 800;">$${(item.price * item.quantity).toFixed(2)}</span>
        </div>
        <p style="font-size: 0.75rem; color: #666;">$${item.price} each</p>
        <div class="qty-controls">
          <button class="qty-btn" onclick="updateCartQty(${item.id}, -1)">-</button>
          <span style="font-weight: 800; font-size: 0.875rem;">${item.quantity}</span>
          <button class="qty-btn" onclick="updateCartQty(${item.id}, 1)">+</button>
          <button onclick="removeFromCart(${item.id})" style="margin-left: auto; background: none; border: none; color: #ef4444; padding: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Remove">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
          </button>
        </div>
      </div>
    </div>
  `).join('');

  updateTotals();
}

function updateTotals() {
  const cart = getCart();
  const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
  
  const province = document.getElementById('province-select')?.value || 'ON';
  const taxRate = TAX_RATES[province] || 0.13;
  const tax = subtotal * taxRate;
  
  const deliveryType = document.querySelector('.delivery-btn.active')?.dataset.type || 'pickup';
  const deliveryFee = deliveryType === 'delivery' ? 5.00 : 0;

  const total = subtotal + tax + deliveryFee;

  document.getElementById('summary-subtotal').textContent = `$${subtotal.toFixed(2)}`;
  document.getElementById('summary-tax').textContent = `$${tax.toFixed(2)}`;
  document.getElementById('tax-rate-label').textContent = (taxRate * 100).toFixed(1);
  
  const deliveryRow = document.getElementById('delivery-fee-row');
  if (deliveryRow) {
    deliveryRow.style.display = deliveryType === 'delivery' ? 'flex' : 'none';
    document.getElementById('summary-delivery').textContent = `$${deliveryFee.toFixed(2)}`;
  }

  document.getElementById('summary-total').textContent = `$${total.toFixed(2)}`;
}

window.addToCart = function(id, btnElement) {
  const item = MENU_ITEMS.find(i => i.id === id);
  if (!item) return;

  // Handle Button State
  const btn = btnElement || document.getElementById('modal-add-btn');
  if (btn) {
    const originalText = btn.innerHTML;
    btn.classList.add('btn-loading');
    
    // Simulate loading
    setTimeout(() => {
      const cart = getCart();
      const existingItem = cart.find(i => i.id === id);

      if (existingItem) {
        existingItem.quantity += 1;
      } else {
        cart.push({ ...item, quantity: 1 });
      }

      saveCart(cart);
      
      btn.classList.remove('btn-loading');
      btn.classList.add('btn-in-cart');
      btn.innerHTML = originalText;
      
      showCartFeedback(item);
    }, 800);
  } else {
    // Fallback if button not found
    const cart = getCart();
    const existingItem = cart.find(i => i.id === id);
    if (existingItem) {
      existingItem.quantity += 1;
    } else {
      cart.push({ ...item, quantity: 1 });
    }
    saveCart(cart);
    showCartFeedback(item);
  }
};

function showCartFeedback(item) {
  // Remove existing feedback if any
  const existing = document.querySelector('.cart-feedback');
  if (existing) existing.remove();

  const feedback = document.createElement('div');
  feedback.className = 'cart-feedback';
  
  const cart = getCart();
  
  // Determine what to display
  let contentHtml = '';
  let title = item ? 'Added to Cart!' : 'Your Cart';

  if (item) {
    // Just show the added item
    contentHtml = `
      <div class="mini-cart-item" style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem; position: relative;">
        <img src="${item.image}" alt="${item.name}" style="width: 45px; height: 45px; border-radius: 0.5rem; object-fit: cover;">
        <div class="mini-cart-info" style="flex: 1;">
          <h4 style="font-size: 0.9rem; margin: 0;">${item.name}</h4>
          <p style="font-size: 0.8rem; color: #666; margin: 0;">$${item.price} • Qty: 1</p>
        </div>
        <button onclick="removeFromCart(${item.id})" style="background: none; border: none; cursor: pointer; color: #ff4d4d; padding: 4px; display: flex; align-items: center; justify-content: center;" title="Remove">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div>
    `;
  } else {
    // Show all items in cart (up to 3, then "and more...")
    const displayItems = cart.slice(-3).reverse(); // Show last 3 added
    contentHtml = `
      <div style="max-height: 200px; overflow-y: auto; margin-bottom: 1.5rem; padding-right: 0.5rem;">
        ${displayItems.map(i => `
          <div class="mini-cart-item" style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem; position: relative;">
            <img src="${i.image}" alt="${i.name}" style="width: 40px; height: 40px; border-radius: 0.4rem; object-fit: cover;">
            <div class="mini-cart-info" style="flex: 1;">
              <h4 style="font-size: 0.85rem; margin: 0;">${i.name}</h4>
              <p style="font-size: 0.75rem; color: #666; margin: 0;">$${i.price} • Qty: ${i.quantity}</p>
            </div>
            <button onclick="removeFromCart(${i.id})" style="background: none; border: none; cursor: pointer; color: #ff4d4d; padding: 4px; display: flex; align-items: center; justify-content: center;" title="Remove">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
          </div>
        `).join('')}
        ${cart.length > 3 ? `<p style="font-size: 0.75rem; color: #999; text-align: center; margin: 0.5rem 0;">+ ${cart.length - 3} more items</p>` : ''}
      </div>
    `;
  }

  feedback.innerHTML = `
    <div class="cart-feedback-content">
      <div class="mini-cart-header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid #eee;">
        <h3 class="text-display" style="font-size: 1rem; margin: 0;">${title}</h3>
        <button onclick="this.closest('.cart-feedback').classList.remove('active')" style="background: none; border: none; cursor: pointer; color: #999; padding: 4px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div>
      
      ${contentHtml}

      <div style="display: flex; flex-direction: column; gap: 0.75rem;">
        <a href="order.php" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.75rem; text-align: center;">Proceed to Checkout</a>
        <a href="menu.php" class="btn btn-outline" style="width: 100%; padding: 0.75rem; font-size: 0.75rem; color: var(--color-neutral-900); border-color: var(--color-neutral-200); text-align: center;">Buy More Items</a>
      </div>
    </div>
  `;
  document.body.appendChild(feedback);
  
  // Trigger animation
  setTimeout(() => {
    feedback.classList.add('active');
  }, 10);
  
  // Close modal if open
  closeModal();
}

function updateCartUI() {
  const cart = getCart();
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  const isNotEmpty = totalItems > 0;

  // 1. Update Header Cart Icon
  const headerCart = document.getElementById('header-cart');
  if (headerCart) {
    if (isNotEmpty) {
      headerCart.classList.add('visible');
      headerCart.querySelector('.cart-badge').textContent = totalItems;
    } else {
      headerCart.classList.remove('visible');
    }
  }

  // 2. Update Floating Cart Button
  let floatingCart = document.getElementById('floating-cart');
  if (!floatingCart) {
    floatingCart = document.createElement('button');
    floatingCart.id = 'floating-cart';
    floatingCart.className = 'floating-cart';
    floatingCart.innerHTML = `
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
      <span class="cart-badge">${totalItems}</span>
    `;
    floatingCart.onclick = () => showCartFeedback();
    document.body.appendChild(floatingCart);
  }
  
  if (isNotEmpty) {
    floatingCart.classList.add('visible');
    floatingCart.querySelector('.cart-badge').textContent = totalItems;
  } else {
    floatingCart.classList.remove('visible');
  }

  // 3. Update "Add to Cart" Buttons on page
  const cartItemIds = cart.map(item => item.id);
  
  // Grid buttons
  document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
    // Extract ID from onclick attribute if possible, or use a data attribute
    // For now, we'll rely on the fact that these are rendered by menu.js
    // We'll update menu.js to add a data-id attribute
    const id = parseInt(btn.dataset.id);
    if (cartItemIds.includes(id)) {
      btn.classList.add('btn-in-cart');
      btn.disabled = true;
    } else {
      btn.classList.remove('btn-in-cart');
      btn.disabled = false;
    }
  });

  // Modal button
  const modalAddBtn = document.getElementById('modal-add-btn');
  if (modalAddBtn) {
    // We need to know which item is currently in the modal
    // We can check the modal title or store the current ID globally
    if (window.currentModalItemId && cartItemIds.includes(window.currentModalItemId)) {
      modalAddBtn.classList.add('btn-in-cart');
      modalAddBtn.disabled = true;
    } else {
      modalAddBtn.classList.remove('btn-in-cart');
      modalAddBtn.disabled = false;
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  // Navbar Scroll Effect
  const navbar = document.querySelector('.navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  // Reveal Animations (Intersection Observer)
  const revealElements = document.querySelectorAll('.reveal');
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const delay = entry.target.dataset.delay || 0;
        setTimeout(() => {
          entry.target.classList.add('active');
        }, delay);
      }
    });
  }, { threshold: 0.1 });

  revealElements.forEach(el => revealObserver.observe(el));

  updateCartUI();
  fetchSiteSettings();
  fetchHomepageData();
  wireNewsletterForms();
  wireContactForm();

  // Checkout Page Logic
  if (window.location.pathname.includes('order.php')) {
    renderCheckout();

    const deliveryBtns = document.querySelectorAll('.delivery-btn');
    deliveryBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        deliveryBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        const addressFields = document.getElementById('address-fields');
        if (btn.dataset.type === 'pickup') {
          addressFields.style.display = 'none';
          document.querySelectorAll('#address-fields input').forEach(input => input.required = false);
        } else {
          addressFields.style.display = 'block';
          document.querySelectorAll('#address-fields input').forEach(input => input.required = true);
        }
        updateTotals();
      });
    });

    const provinceSelect = document.getElementById('province-select');
    if (provinceSelect) {
      provinceSelect.addEventListener('change', updateTotals);
    }

    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
      checkoutForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(checkoutForm);
        const customerData = Object.fromEntries(formData.entries());
        customerData.deliveryType = document.querySelector('.delivery-btn.active').dataset.type;
        
        const cart = getCart();
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const province = customerData.state || 'ON';
        const taxRate = TAX_RATES[province] || 0.13;
        const tax = subtotal * taxRate;
        const deliveryFee = customerData.deliveryType === 'delivery' ? 5.00 : 0;
        const total = subtotal + tax + deliveryFee;

        const orderData = {
          customer_name: customerData.name || customerData.firstName + ' ' + customerData.lastName,
          customer_email: customerData.email,
          customer_phone: customerData.phone,
          delivery_address: `${customerData.address}, ${customerData.city}, ${customerData.state}, ${customerData.zip}`,
          items: cart.map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.price
          })),
          total_amount: total
        };

        // Send to API
        fetch('php-backend/place_order.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(orderData)
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            sessionStorage.setItem('cosmic_pending_order', JSON.stringify({ ...orderData, orderId: data.orderId, orderNumber: data.orderNumber }));
            window.location.href = 'order-way.php?order_id=' + encodeURIComponent(data.orderId);
          } else {
            alert("Failed to place order. Please try again.");
          }
        })
        .catch(err => {
          console.error("Order error:", err);
          alert("An error occurred. Please try again.");
        });
      });
    }
  }

  // Combo Slider Navigation
  const slider = document.getElementById('combo-slider');
  const prevBtn = document.querySelector('.slider-nav.prev');
  const nextBtn = document.querySelector('.slider-nav.next');

  if (slider && prevBtn && nextBtn) {
    nextBtn.addEventListener('click', () => {
      const scrollAmount = slider.offsetWidth;
      slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });

    prevBtn.addEventListener('click', () => {
      const scrollAmount = slider.offsetWidth;
      slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
  }

  // Smooth Scroll for Internal Links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;
      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
});

// Modal Functions
window.openModal = function(id) {
  window.currentModalItemId = id;
  const item = MENU_ITEMS.find(i => i.id === id);
  if (!item) return;

  const modal = document.getElementById('menu-modal');
  const img = document.getElementById('modal-img');
  const title = document.getElementById('modal-title');
  const desc = document.getElementById('modal-desc');
  const price = document.getElementById('modal-price');
  const category = document.getElementById('modal-category');
  const modifiersContainer = document.getElementById('modal-modifiers');

  if (modal && img && title && desc && price && category) {
    img.src = item.image;
    img.alt = item.name;
    title.textContent = item.name;
    desc.textContent = item.desc;
    price.textContent = `$${item.price}`;
    category.textContent = item.category;

    const addBtn = document.getElementById('modal-add-btn');
    if (addBtn) {
      addBtn.onclick = function() { addToCart(item.id, this); };
    }
    
    updateCartUI();

    const ratingContainer = document.getElementById('modal-rating');
    if (ratingContainer) {
      const stars = Array(5).fill(0).map((_, i) => {
        const isFull = i < Math.floor(item.rating);
        return `<svg width="18" height="18" viewBox="0 0 24 24" fill="${isFull ? '#FFB800' : '#E5E7EB'}"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>`;
      }).join('');
      ratingContainer.innerHTML = `
        <div style="display: flex;">${stars}</div>
        <span style="font-weight: 700; color: var(--color-neutral-900);">${item.rating}</span>
        <span style="color: #999;">(${item.reviews} reviews)</span>
      `;
    }

    if (modifiersContainer) {
      if (item.modifiers && item.modifiers.length > 0) {
        modifiersContainer.innerHTML = `
          <h5 style="margin-bottom: 1rem; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em;">Customize Your Order</h5>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
            ${item.modifiers.map(mod => `
              <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; cursor: pointer;">
                <input type="checkbox" name="modifier" value="${mod}" style="accent-color: var(--color-primary);">
                ${mod}
              </label>
            `).join('')}
          </div>
        `;
        modifiersContainer.style.display = 'block';
      } else {
        modifiersContainer.style.display = 'none';
      }
    }

    modal.style.display = 'flex';
    setTimeout(() => {
      modal.classList.add('active');
    }, 10);
    document.body.style.overflow = 'hidden';
  }
};

window.closeModal = function() {
  const modal = document.getElementById('menu-modal');
  if (modal) {
    modal.classList.remove('active');
    setTimeout(() => {
      modal.style.display = 'none';
    }, 400);
    document.body.style.overflow = '';
  }
};

// Close modal on outside click
window.addEventListener('click', (e) => {
  const modal = document.getElementById('menu-modal');
  if (e.target === modal) {
    closeModal();
  }
});


async function fetchSiteSettings() {
  try {
    const response = await fetch('php-backend/site_settings.php');
    const data = await response.json();
    if (!data.success) return;
    const s = data.settings || {};

    document.querySelectorAll('[data-site-name]').forEach(el => { el.textContent = s.site_name || 'Cosmic Burger'; });
    document.querySelectorAll('[data-site-email]').forEach(el => { el.textContent = s.contact_email || ''; if (el.tagName === 'A') el.href = 'mailto:' + s.contact_email; });
    document.querySelectorAll('[data-site-phone]').forEach(el => { el.textContent = s.contact_phone || ''; if (el.tagName === 'A') el.href = 'tel:' + s.contact_phone; });
    document.querySelectorAll('[data-footer-text]').forEach(el => { el.textContent = s.footer_text || ''; });
    document.querySelectorAll('[data-business-hours]').forEach(el => { el.textContent = s.business_hours || ''; });

    const heroTitle = document.getElementById('hero-title-dynamic');
    if (heroTitle && s.hero_title) heroTitle.innerHTML = s.hero_title.replace('Multiverse', '<span style="color: var(--color-primary)">Multiverse</span>');
    const heroText = document.getElementById('hero-text-dynamic');
    if (heroText && s.hero_text) heroText.textContent = s.hero_text;
    const promoCode = document.getElementById('promo-code-dynamic');
    if (promoCode && s.promo_code) promoCode.textContent = s.promo_code;
  } catch (error) {
    console.error('Settings load failed:', error);
  }
}

async function fetchHomepageData() {
  const featuredContainer = document.getElementById('featured-menu-grid');
  const statsItems = {
    totalMenuItems: document.getElementById('stat-total-menu-items'),
    ordersToday: document.getElementById('stat-orders-today'),
    totalOrders: document.getElementById('stat-total-orders'),
    totalSales: document.getElementById('stat-total-sales')
  };
  if (!featuredContainer && !statsItems.totalMenuItems) return;

  try {
    const response = await fetch('php-backend/homepage_data.php');
    const data = await response.json();
    if (!data.success) return;

    if (data.stats) {
      if (statsItems.totalMenuItems) statsItems.totalMenuItems.textContent = data.stats.total_menu_items;
      if (statsItems.ordersToday) statsItems.ordersToday.textContent = data.stats.orders_today;
      if (statsItems.totalOrders) statsItems.totalOrders.textContent = data.stats.total_orders;
      if (statsItems.totalSales) statsItems.totalSales.textContent = '$' + Number(data.stats.total_sales || 0).toFixed(2);
    }

    if (featuredContainer && Array.isArray(data.featured)) {
      featuredContainer.innerHTML = data.featured.map(item => `
        <article class="menu-card reveal active">
          <img src="${item.image_url}" alt="${item.name}" class="menu-card-img" referrerPolicy="no-referrer">
          <div style="padding: 0.5rem;">
            <div style="display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;">
              <h4 class="text-display" style="font-size:1.25rem;">${item.name}</h4>
              <span style="color: var(--color-primary); font-weight: 900;">$${Number(item.price).toFixed(2)}</span>
            </div>
            <p style="font-size:0.875rem;color:#666;margin:0.75rem 0 1.25rem;">${item.description || ''}</p>
            <div style="display:flex;gap:0.75rem;align-items:center;justify-content:space-between;">
              <span style="font-size:0.75rem;color:#666;">${item.category_name || ''}</span>
              <button class="btn btn-primary" onclick="addToCart(${item.id}, this)">Add to Cart</button>
            </div>
          </div>
        </article>
      `).join('');
    }
  } catch (error) {
    console.error('Homepage data load failed:', error);
  }
}

async function submitJson(url, payload) {
  const response = await fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  });
  return response.json();
}

function wireNewsletterForms() {
  document.querySelectorAll('.newsletter-form').forEach(form => {
    if (form.dataset.wired === '1') return;
    form.dataset.wired = '1';
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const input = form.querySelector('.newsletter-input');
      if (!input) return;
      const result = await submitJson('php-backend/newsletter_subscribe.php', { email: input.value.trim() });
      alert(result.message || (result.success ? 'Subscribed.' : 'Failed.'));
      if (result.success) input.value = '';
    });
  });
}

function wireContactForm() {
  const form = document.getElementById('contact-form');
  if (!form || form.dataset.wired === '1') return;
  form.dataset.wired = '1';
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const result = await submitJson('php-backend/contact_submit.php', {
      name: form.querySelector('[name="name"]').value.trim(),
      email: form.querySelector('[name="email"]').value.trim(),
      message: form.querySelector('[name="message"]').value.trim(),
    });
    const status = document.getElementById('contact-form-status');
    if (status) {
      status.textContent = result.message || '';
      status.style.color = result.success ? 'green' : '#b91c1c';
    }
    if (result.success) form.reset();
  });
}
