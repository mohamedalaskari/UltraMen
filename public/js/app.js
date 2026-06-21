document.addEventListener('DOMContentLoaded', function () {

    // ── Scroll Reveal ─────────────────────────────────────────────────────────
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // ── Archive product card fade-in ──────────────────────────────────────────
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-8');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.product-image-container').forEach(card => {
        card.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-1000');
        cardObserver.observe(card);
    });

    // ── Section fade-in (About page) ──────────────────────────────────────────
    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100');
                entry.target.classList.remove('translate-y-10', 'opacity-0');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.section-fade').forEach(el => {
        el.classList.add('transition-all', 'duration-1000', 'opacity-0', 'translate-y-10');
        fadeObserver.observe(el);
    });

    // ── Nav hide-on-scroll-down / show-on-scroll-up ───────────────────────────
    const nav = document.getElementById('main-nav');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll <= 0) {
            nav.style.transform = 'translateY(0)';
            nav.classList.remove('shadow-sm');
            lastScroll = 0;
            return;
        }

        if (currentScroll > lastScroll && currentScroll > 80) {
            // Scrolling down — hide nav
            nav.style.transform = 'translateY(-100%)';
        } else {
            // Scrolling up — show nav
            nav.style.transform = 'translateY(0)';
            nav.classList.add('shadow-sm');
        }

        lastScroll = currentScroll;
    });

});

// ── Button press micro-interaction (Cart page) ────────────────────────────────
document.querySelectorAll('button').forEach(btn => {
    btn.addEventListener('mousedown', () => btn.style.transform = 'scale(0.98)');
    btn.addEventListener('mouseup',   () => btn.style.transform = 'scale(1)');
    btn.addEventListener('mouseleave',() => btn.style.transform = 'scale(1)');
});

// ── Contact form micro-interaction ────────────────────────────────────────────
const contactForm = document.getElementById('contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
        const btn = contactForm.querySelector('button[type="submit"]');
        const original = btn.innerText;
        btn.innerText = 'Sending...';
        btn.style.opacity = '0.7';
        btn.disabled = true;

        // Let Laravel handle the actual POST; this just shows animation before redirect
        setTimeout(() => {
            btn.innerText = original;
            btn.style.opacity = '1';
            btn.disabled = false;
        }, 1500);
    });
}

// ── Cart Drawer (toggle) ──────────────────────────────────────────────────────
function toggleCart() {
    const drawer  = document.getElementById('cartDrawer');
    const overlay = document.getElementById('cartOverlay');
    const panel   = document.getElementById('cartPanel');
    const closedClass = document.documentElement.dir === 'rtl' ? '-translate-x-full' : 'translate-x-full';

    if (drawer.classList.contains('invisible')) {
        drawer.classList.remove('invisible');
        setTimeout(() => {
            overlay.classList.add('opacity-100');
            panel.classList.remove(closedClass);
        }, 10);
        document.body.style.overflow = 'hidden';
    } else {
        overlay.classList.remove('opacity-100');
        panel.classList.add(closedClass);
        setTimeout(() => drawer.classList.add('invisible'), 500);
        document.body.style.overflow = '';
    }
}

// ── Cart AJAX helpers ─────────────────────────────────────────────────────────
function _csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

function _cartPost(url, body) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': _csrfToken(),
        },
        body: JSON.stringify(body),
    }).then(r => r.json());
}

function cartAddFromBtn(btn) {
    _cartPost('/cart/add', {
        slug:           btn.dataset.slug,
        name:           btn.dataset.name,
        price:          btn.dataset.price,
        original_price: btn.dataset.originalPrice || '',
        image:          btn.dataset.image,
    }).then(data => {
        _renderCart(data);
        if (!document.getElementById('cartDrawer').classList.contains('invisible') === false) {
            toggleCart();
        } else {
            // drawer already open — just re-render
        }
        // always open drawer on add
        const drawer = document.getElementById('cartDrawer');
        if (drawer.classList.contains('invisible')) toggleCart();
    });
}

function removeFromCart(slug) {
    _cartPost('/cart/remove', { slug }).then(_renderCart);
}

function updateCartQty(slug, qty) {
    _cartPost('/cart/update', { slug, qty }).then(_renderCart);
}

// ── Re-render cart drawer from JSON data ──────────────────────────────────────
function _renderCart(data) {
    // Badge in nav
    const badge = document.getElementById('cartBadge');
    if (badge) {
        badge.textContent = data.count;
        badge.classList.toggle('hidden', data.count === 0);
    }

    // Drawer header count
    const countEl = document.getElementById('cartCount');
    if (countEl) countEl.textContent = '(' + data.count + ')';

    // Subtotal
    const subtotalEl = document.getElementById('cartSubtotal');
    if (subtotalEl) subtotalEl.textContent = data.subtotal;

    // Checkout button visibility
    const checkoutBtn = document.getElementById('cartCheckout');
    if (checkoutBtn) checkoutBtn.classList.toggle('hidden', data.count === 0);

    // Items list
    const itemsEl = document.getElementById('cartItems');
    if (!itemsEl) return;

    if (!data.items.length) {
        itemsEl.innerHTML = `
            <div class="flex flex-col items-center justify-center h-40 text-center">
                <span class="material-symbols-outlined text-4xl text-outline mb-4">shopping_bag</span>
                <p class="font-label-sm text-[11px] text-outline uppercase tracking-widest">Your cart is empty</p>
            </div>`;
        return;
    }

    itemsEl.innerHTML = data.items.map(item => `
        <div class="flex gap-6">
            <div class="w-24 h-32 bg-surface-container flex-shrink-0">
                <img alt="${item.name}" class="w-full h-full object-cover" src="/storage/${item.image}"/>
            </div>
            <div class="flex flex-col justify-between py-1 flex-grow min-w-0">
                <div>
                    <h4 class="font-label-sm text-sm text-primary mb-1 uppercase leading-tight">${item.name}</h4>
                    <p class="font-label-sm text-[10px] text-secondary flex items-center gap-2">
                        ${item.original_price ? `<s class="text-outline opacity-60">${item.original_price}</s>` : ''}
                        ${item.price}
                    </p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button onclick="updateCartQty('${item.slug}', ${item.qty - 1})"
                                class="w-6 h-6 border border-outline-variant flex items-center justify-center hover:border-primary transition-colors text-sm leading-none">−</button>
                        <span class="font-label-sm text-sm w-4 text-center">${item.qty}</span>
                        <button onclick="updateCartQty('${item.slug}', ${item.qty + 1})"
                                class="w-6 h-6 border border-outline-variant flex items-center justify-center hover:border-primary transition-colors text-sm leading-none">+</button>
                    </div>
                    <button onclick="removeFromCart('${item.slug}')"
                            class="text-[10px] font-label-sm text-outline hover:text-error transition-colors uppercase tracking-wider">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// ── Search Overlay (toggle + real-time AJAX search) ────────────────────────────
let _searchDebounce = null;

function toggleSearch() {
    const overlay  = document.getElementById('searchOverlay');
    const backdrop = document.getElementById('searchBackdrop');
    const panel    = document.getElementById('searchPanel');
    const input    = document.getElementById('searchInput');

    if (overlay.classList.contains('invisible')) {
        overlay.classList.remove('invisible');
        setTimeout(() => {
            backdrop.classList.add('opacity-100');
            panel.classList.remove('-translate-y-full');
            input.focus();
        }, 10);
        document.body.style.overflow = 'hidden';
    } else {
        backdrop.classList.remove('opacity-100');
        panel.classList.add('-translate-y-full');
        setTimeout(() => overlay.classList.add('invisible'), 300);
        document.body.style.overflow = '';
        input.value = '';
        document.getElementById('searchResults').innerHTML = '';
    }
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const overlay = document.getElementById('searchOverlay');
        if (overlay && !overlay.classList.contains('invisible')) toggleSearch();
    }
});

document.addEventListener('input', function (e) {
    if (e.target.id !== 'searchInput') return;

    const term = e.target.value.trim();
    const resultsBox = document.getElementById('searchResults');

    clearTimeout(_searchDebounce);

    if (term.length < 2) {
        resultsBox.innerHTML = '';
        return;
    }

    _searchDebounce = setTimeout(() => runProductSearch(term), 300);
});

function runProductSearch(term) {
    fetch(`/search/suggest?q=${encodeURIComponent(term)}`)
        .then(r => r.json())
        .then(data => renderSearchResults(data.results, term))
        .catch(() => {});
}

function renderSearchResults(results, term) {
    const resultsBox = document.getElementById('searchResults');
    const overlay    = document.getElementById('searchOverlay');
    const noResults  = overlay.dataset.noResults;
    const viewAll    = overlay.dataset.viewAll.replace(':term', term);
    const collectionsUrl = overlay.dataset.collectionsUrl;

    if (!results.length) {
        resultsBox.innerHTML = `<p class="text-center text-outline py-10 font-label-sm text-label-sm uppercase tracking-widest">${noResults}</p>`;
        return;
    }

    const cards = results.map(p => `
        <a href="${p.url}" class="flex items-center gap-4 group">
            <div class="w-16 h-20 bg-surface-container flex-shrink-0 overflow-hidden">
                <img alt="${p.name}" class="w-full h-full object-cover" src="${p.image}"/>
            </div>
            <div class="min-w-0">
                <p class="font-label-sm text-sm text-primary uppercase truncate group-hover:text-secondary transition-colors">${p.name}</p>
                <p class="font-label-sm text-[11px] text-secondary mt-1">${p.price}</p>
            </div>
        </a>
    `).join('');

    resultsBox.innerHTML = `
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">${cards}</div>
        <a href="${collectionsUrl}?search=${encodeURIComponent(term)}"
           class="block text-center mt-8 font-label-sm text-[11px] text-primary uppercase tracking-widest hover:text-secondary transition-colors">
            ${viewAll}
        </a>
    `;
}
