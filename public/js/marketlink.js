window.ML={
 homeMap(markets){const el=document.getElementById('homeMap');if(!el||typeof L==='undefined')return;const list=(markets||[]).filter(m=>m&&m.latitude!==null&&m.longitude!==null&&m.latitude!==''&&m.longitude!=='');const map=L.map(el,{scrollWheelZoom:false}).setView(list.length?[Number(list[0].latitude),Number(list[0].longitude)]:[25.396,68.358],list.length?11:12);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(map);list.forEach(m=>L.marker([Number(m.latitude),Number(m.longitude)]).addTo(map).bindPopup(`<b>${escapeHtml(m.name)}</b><br>${escapeHtml(m.address||'')}<br>${escapeHtml(m.days||'')} · ${escapeHtml(m.hours||'')}`));if(list.length>1)map.fitBounds(L.latLngBounds(list.map(m=>[Number(m.latitude),Number(m.longitude)])),{padding:[30,30]});setTimeout(()=>map.invalidateSize(),250);},
 marketsMap(markets){const el=document.getElementById('marketsMap');if(!el||typeof L==='undefined')return;const list=(markets||[]).filter(m=>m&&m.latitude!==null&&m.longitude!==null&&m.latitude!==''&&m.longitude!=='');const map=L.map(el,{scrollWheelZoom:false}).setView(list.length?[Number(list[0].latitude),Number(list[0].longitude)]:[25.396,68.358],list.length?11:12);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(map);list.forEach(m=>L.marker([Number(m.latitude),Number(m.longitude)]).addTo(map).bindPopup(`<b>${escapeHtml(m.name)}</b><br>${escapeHtml(m.address||'')}<br>${escapeHtml(m.days||'')} · ${escapeHtml(m.hours||'')}`));if(list.length>1)map.fitBounds(L.latLngBounds(list.map(m=>[Number(m.latitude),Number(m.longitude)])),{padding:[30,30]});setTimeout(()=>map.invalidateSize(),250);},
 singleMap(id,lat,lng,name){const el=document.getElementById(id);if(!el||typeof L==='undefined')return;const la=Number(lat),lo=Number(lng);if(!Number.isFinite(la)||!Number.isFinite(lo))return;const map=L.map(el,{scrollWheelZoom:false}).setView([la,lo],14);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(map);L.marker([la,lo]).addTo(map).bindPopup(`<b>${escapeHtml(name)}</b>`).openPopup();setTimeout(()=>map.invalidateSize(),250);}
};
function escapeHtml(value){return String(value??'').replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'}[c]));}

document.addEventListener('DOMContentLoaded',()=>{
 const root=document.documentElement, themeBtn=document.getElementById('themeToggle');
 function applyTheme(dark){root.classList.toggle('theme-dark',dark);if(themeBtn){themeBtn.setAttribute('aria-pressed',dark?'true':'false');themeBtn.innerHTML=dark?'<i class="bi bi-sun"></i>':'<i class="bi bi-moon-stars"></i>';}}
 let saved='light';try{saved=localStorage.getItem('marketlink_theme')||'light';}catch(e){}
 applyTheme(saved==='dark');
 themeBtn?.addEventListener('click',()=>{const dark=!root.classList.contains('theme-dark');try{localStorage.setItem('marketlink_theme',dark?'dark':'light');}catch(e){}applyTheme(dark);});

 const toggle=document.getElementById('assistantToggle'),panel=document.getElementById('assistantPanel'),close=document.getElementById('assistantClose'),form=document.getElementById('assistantForm'),input=document.getElementById('assistantInput'),body=document.getElementById('assistantBody');
 if(toggle&&panel){toggle.addEventListener('click',()=>panel.classList.toggle('open'));close?.addEventListener('click',()=>panel.classList.remove('open'));}
 form?.addEventListener('submit',async e=>{e.preventDefault();const message=input.value.trim();if(!message)return;addMsg(escapeHtml(message),'user');input.value='';addMsg('Thinking…','bot');try{const token=document.querySelector('meta[name="csrf-token"]')?.content;const res=await fetch('/assistant',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token||'','Accept':'application/json'},body:JSON.stringify({message})});if(!res.ok)throw new Error('assistant');const data=await res.json();body.lastElementChild?.remove();addMsg(formatAssistant(data),'bot');}catch(err){body.lastElementChild?.remove();addMsg('Sorry, I could not reach the assistant right now.','bot');}});
 function addMsg(html,type){const div=document.createElement('div');div.className='assistant-msg '+type;div.innerHTML=html;body.appendChild(div);body.scrollTop=body.scrollHeight;}
 function formatAssistant(data){let html=escapeHtml(data.answer||'');if(data.results?.length)html+='<div class="assistant-results">'+data.results.map(x=>`<a href="/products/${encodeURIComponent(x.id)}"><b>${escapeHtml(x.name)}</b><small>${escapeHtml(x.price)} · ${escapeHtml(x.farmer)}</small></a>`).join('')+'</div>';if(data.orders?.length)html+='<div class="assistant-results">'+data.orders.map(x=>`<div><b>${escapeHtml(x.number)}</b><small>${escapeHtml(x.status)} · ${escapeHtml(x.pickup)}</small></div>`).join('')+'</div>';if(data.markets?.length)html+='<div class="assistant-results">'+data.markets.map(x=>`<div><b>${escapeHtml(x.name)}</b><small>${escapeHtml(x.days||'')} · ${escapeHtml(x.hours||'')}</small></div>`).join('')+'</div>';if(data.farmers?.length)html+='<div class="assistant-results">'+data.farmers.map(x=>`<div><b>${escapeHtml(x.name)}</b><small>${escapeHtml(x.address||'')}</small></div>`).join('')+'</div>';return html;}
});


// Add consistent icons to important action controls without touching forms/routes.
document.addEventListener('DOMContentLoaded', () => {
    const iconRules = [
        [/^apply$/i, 'bi-funnel'],
        [/^clear( all)?$/i, 'bi-x-circle'],
        [/^(view|view product|view again)$/i, 'bi-eye'],
        [/^browse( products| all)?$/i, 'bi-grid'],
        [/^explore( products| markets| all)?$/i, 'bi-arrow-up-right'],
        [/^manage$/i, 'bi-sliders2'],
        [/^save( changes| order)?$/i, 'bi-check2-circle'],
        [/^create( an account| your stall| market| category)?$/i, 'bi-plus-circle'],
        [/^delete$/i, 'bi-trash'],
        [/^remove( favorite)?$/i, 'bi-heartbreak'],
        [/^reply$/i, 'bi-reply'],
        [/^export csv$/i, 'bi-download'],
        [/^accept$/i, 'bi-check-circle'],
        [/^decline$/i, 'bi-x-circle'],
        [/^cancel( order)?$/i, 'bi-x-circle'],
        [/^ready$/i, 'bi-box-seam'],
        [/^(complete|completed)$/i, 'bi-check2-all'],
        [/^add to cart$/i, 'bi-bag-plus'],
        [/^cart$/i, 'bi-bag'],
        [/^sign in$/i, 'bi-box-arrow-in-right'],
        [/^sign out$/i, 'bi-box-arrow-right'],
        [/^register$/i, 'bi-person-plus'],
        [/^submit( review)?$/i, 'bi-send'],
        [/^send( reset link| message)?$/i, 'bi-send'],
        [/^back( to .*)?$/i, 'bi-arrow-left'],
        [/^place pre-order(s)?$/i, 'bi-bag-check'],
        [/^update$/i, 'bi-arrow-repeat'],
    ];
    document.querySelectorAll('button, a.btn, a.btn-sm').forEach(el => {
        if (el.querySelector('i, svg, img')) return;
        const text = el.textContent.trim().replace(/\s+/g, ' ');
        if (!text) return;
        const rule = iconRules.find(([re]) => re.test(text));
        if (!rule) return;
        const icon = document.createElement('i');
        icon.className = `bi ${rule[1]} me-1`;
        icon.setAttribute('aria-hidden', 'true');
        el.prepend(icon);
    });
});


// Smooth customer cart + order actions.
document.addEventListener('DOMContentLoaded', () => {
    // Make this block idempotent in case the layout/script is accidentally
    // evaluated more than once. This prevents duplicate cart POSTs/toasts.
    if (window.__ML_CART_ACTIONS_BOUND__) return;
    window.__ML_CART_ACTIONS_BOUND__ = true;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    function showMLToast(message, type = 'success') {
        document.querySelectorAll('.ml-toast').forEach(el => el.remove());
        const toast = document.createElement('div');
        toast.className = `ml-toast ${type}`;
        toast.setAttribute('role', 'status');
        toast.setAttribute('aria-live', 'polite');
        const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';
        toast.innerHTML = `<i class="bi ${icon}"></i><span>${escapeHtml(message)}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 180);
        }, 2600);
    }

    function updateCartBadge(count) {
        const cartLink = document.querySelector('.nav-icon-link[aria-label="Cart"]');
        if (!cartLink) return;
        let badge = cartLink.querySelector('.cart-count-badge');
        const total = Number(count);
        if (!Number.isFinite(total) || total <= 0) {
            badge?.remove();
            cartLink.removeAttribute('data-cart-count');
            return;
        }
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'nav-badge cart-count-badge';
            cartLink.appendChild(badge);
        }
        badge.textContent = total > 99 ? '99+' : String(total);
        cartLink.setAttribute('data-cart-count', String(total));
        cartLink.classList.remove('cart-updated');
        void cartLink.offsetWidth;
        cartLink.classList.add('cart-updated');
    }

    document.querySelectorAll('form.cart-ajax-form').forEach(form => {
        // Guard each form as well: one physical click can never create two
        // concurrent requests even if another handler is registered.
        if (form.dataset.mlCartBound === '1') return;
        form.dataset.mlCartBound = '1';

        form.addEventListener('submit', async event => {
            event.preventDefault();
            event.stopImmediatePropagation();
            if (form.dataset.mlCartSubmitting === '1') return;
            form.dataset.mlCartSubmitting = '1';
            const button = form.querySelector('button[type="submit"]');
            const original = button?.innerHTML || '';
            const productName = form.querySelector('input[name="product_id"]')?.value;
            if (button) {
                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>';
            }
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')?.value || csrf
                    },
                    body: new FormData(form)
                });
                const data = await response.json().catch(() => ({}));
                if (!response.ok) throw new Error(data.message || 'Could not add this product to your cart.');
                updateCartBadge(data.cart_count);
                showMLToast(data.message || (productName ? 'Product added to your cart.' : 'Product added to your cart.'));
            } catch (error) {
                showMLToast(error.message || 'Could not add this product to your cart.', 'error');
            } finally {
                form.dataset.mlCartSubmitting = '0';
                if (button) {
                    button.disabled = false;
                    button.innerHTML = original;
                }
            }
        });
    });

    document.querySelectorAll('form[data-ajax-cancel]').forEach(form => {
        if (form.dataset.mlCancelBound === '1') return;
        form.dataset.mlCancelBound = '1';

        form.addEventListener('submit', async event => {
            if (event.defaultPrevented) return;
            event.preventDefault();
            if (!window.confirm('Cancel this order?')) return;
            if (form.dataset.mlCancelSubmitting === '1') return;
            form.dataset.mlCancelSubmitting = '1';

            const button = form.querySelector('button[type="submit"]');
            const original = button?.innerHTML || 'Cancel';
            if (button) {
                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span> Cancelling…';
            }
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')?.value || csrf
                    },
                    body: new FormData(form)
                });
                const data = await response.json().catch(() => ({}));
                if (!response.ok) throw new Error(data.message || 'Could not cancel this order.');

                // Orders list: update the row immediately without a refresh.
                const row = form.closest('.order-row');
                const rowStatus = row?.querySelector('.status');
                if (rowStatus) {
                    rowStatus.className = 'status status-cancelled';
                    rowStatus.textContent = 'Cancelled';
                }
                if (row && !row.querySelector('a[href*="reorder"]')) {
                    const actions = form.closest('.d-flex');
                    if (actions) {
                        const reorder = document.createElement('a');
                        reorder.href = data.reorder_url || '#';
                        if (reorder.href !== '#') {
                            reorder.className = 'btn btn-sm btn-outline-success rounded-pill';
                            reorder.textContent = 'Reorder';
                            actions.appendChild(reorder);
                        }
                    }
                }
                if (row) {
                    const editLink = row.querySelector('a[href*="/edit"]');
                    editLink?.remove();
                    form.remove();
                }

                // Order details page: update status/timeline/action area immediately.
                const detailStatus = document.querySelector('[data-order-status]');
                if (detailStatus) {
                    detailStatus.className = 'status status-cancelled';
                    detailStatus.textContent = 'Cancelled';
                    const timeline = detailStatus.closest('.panel')?.querySelector('.timeline');
                    if (timeline) {
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-danger rounded-4 mb-0';
                        alert.innerHTML = '<strong>Order Cancelled</strong><div>This order has been cancelled.</div>';
                        timeline.replaceWith(alert);
                    }
                    form.closest('[data-cancel-panel]')?.remove();
                    document.querySelector('a[href*="/edit"]')?.remove();
                }

                showMLToast(data.message || 'Order cancelled successfully.');
            } catch (error) {
                if (button) {
                    button.disabled = false;
                    button.innerHTML = original;
                }
                showMLToast(error.message || 'Could not cancel this order.', 'error');
            } finally {
                form.dataset.mlCancelSubmitting = '0';
            }
        });
    });
});
