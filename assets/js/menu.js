document.addEventListener('DOMContentLoaded', () => {
  const grid = document.getElementById('menu-grid');
  const tabs = document.querySelectorAll('.tab-btn');
  const tabList = document.querySelector('[role="tablist"]');
  const searchInput = document.getElementById('menu-search');

  function renderMenu(items) {
    if (!grid) return;
    grid.innerHTML = items.map((item, index) => {
      const stars = Array(5).fill(0).map((_, i) => {
        const isFull = i < Math.floor(item.rating);
        return `<svg width="14" height="14" viewBox="0 0 24 24" fill="${isFull ? '#FFB800' : '#E5E7EB'}"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>`;
      }).join('');

      return `
        <div class="menu-card reveal active" style="transition-delay: ${index * 0.05}s">
          <img src="${item.image}" alt="${item.name}" class="menu-card-img" referrerPolicy="no-referrer">
          <div style="padding: 0.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
              <h4 class="text-display" style="font-size: 1.25rem;">${item.name}</h4>
              <span style="color: var(--color-primary); font-weight: 900; font-size: 1.1rem;">$${item.price}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.75rem;">
              <div style="display: flex;">${stars}</div>
              <span style="font-size: 0.75rem; color: #999;">(${item.reviews})</span>
            </div>
            <p style="font-size: 0.875rem; color: #666; margin-bottom: 1.5rem; line-height: 1.4;">
              ${item.desc}
            </p>
            <div style="display: flex; gap: 0.5rem;">
              <button class="btn btn-outline" style="flex: 1; padding: 0.6rem 0.5rem; font-size: 0.7rem; background: #f3f4f6; color: #1f2937; border: none; white-space: nowrap;" onclick="openModal(${item.id})">See More</button>
              <button class="btn btn-primary btn-add-to-cart" data-id="${item.id}" style="flex: 1.2; padding: 0.6rem 0.5rem; font-size: 0.7rem; white-space: nowrap;" onclick="addToCart(${item.id}, this)">Add to Cart</button>
            </div>
          </div>
        </div>
      `;
    }).join('');
    if (typeof updateCartUI === 'function') updateCartUI();
  }

  function setActiveTab(tab) {
    tabs.forEach(t => {
      t.classList.remove('active');
      t.setAttribute('aria-selected', 'false');
      t.setAttribute('tabindex', '-1');
    });
    tab.classList.add('active');
    tab.setAttribute('aria-selected', 'true');
    tab.setAttribute('tabindex', '0');
    tab.focus();

    // Update tabpanel label
    grid.setAttribute('aria-labelledby', tab.id);

    const category = tab.dataset.category;
    const filtered = category === 'All' 
      ? window.MENU_ITEMS 
      : window.MENU_ITEMS.filter(i => i.category === category);
    renderMenu(filtered);
  }

  // Initial Render & URL Filtering
  const urlParams = new URLSearchParams(window.location.search);
  const categoryParam = urlParams.get('category');

  function initialRender() {
    if (grid) {
      if (categoryParam) {
        const targetTab = Array.from(tabs).find(t => t.dataset.category === categoryParam);
        if (targetTab) {
          setActiveTab(targetTab);
        } else {
          renderMenu(window.MENU_ITEMS);
        }
      } else {
        renderMenu(window.MENU_ITEMS);
      }
    }
  }

  // If menu is already loaded, render immediately, otherwise wait for event
  if (window.MENU_ITEMS && window.MENU_ITEMS.length > 0) {
    initialRender();
  } else {
    window.addEventListener('menuLoaded', initialRender);
  }

  // Filtering
  tabs.forEach(tab => {
    tab.addEventListener('click', () => setActiveTab(tab));
  });

  // Keyboard Navigation
  if (tabList) {
    tabList.addEventListener('keydown', (e) => {
      const target = e.target;
      if (target.getAttribute('role') !== 'tab') return;

      let newTab;
      const tabArray = Array.from(tabs);
      const index = tabArray.indexOf(target);

      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        newTab = tabArray[(index + 1) % tabArray.length];
      } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        newTab = tabArray[(index - 1 + tabArray.length) % tabArray.length];
      } else if (e.key === 'Home') {
        newTab = tabArray[0];
      } else if (e.key === 'End') {
        newTab = tabArray[tabArray.length - 1];
      }

      if (newTab) {
        e.preventDefault();
        setActiveTab(newTab);
      }
    });
  }

  // Search
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      const query = e.target.value.toLowerCase();
      const filtered = window.MENU_ITEMS.filter(i => 
        i.name.toLowerCase().includes(query) || 
        i.category.toLowerCase().includes(query)
      );
      renderMenu(filtered);
    });
  }
});
