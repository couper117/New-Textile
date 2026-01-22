<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORE | Enterprise Store</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #2563eb;
            --bg: #ffffff;
            --surface: #f8fafc;
            --border: #e2e8f0;
            --text: #0f172a;
            --card-bg: #ffffff;
            --text-muted: #64748b;
            --success: #10b981;
        }

        [data-theme="dark"] {
            --bg: #020617;
            --surface: #0f172a;
            --border: #1e293b;
            --text: #f1f5f9;
            --card-bg: #1e293b;
            --text-muted: #94a3b8;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; transition: background 0.3s, border 0.3s; }
        body { background: var(--bg); color: var(--text); overflow-x: hidden; font-size: 14px; display: flex; flex-direction: column; min-height: 100vh; }

        /* --- NAVIGATION --- */
        nav {
            height: 70px; display: flex; align-items: center; justify-content: space-between;
            padding: 0 5%; background: var(--bg); position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid var(--border);
        }
        .logo { font-weight: 700; font-size: 1.4rem; color: var(--accent); display: flex; align-items: center; gap: 8px; }
        
        .search-wrap { flex: 0 1 400px; margin: 0 20px; position: relative; }
        .search-input { 
            width: 100%; padding: 10px 15px 10px 40px; border-radius: 10px; 
            border: 1px solid var(--border); background: var(--surface); color: var(--text);
            outline: none;
        }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; }

        .nav-tools { display: flex; gap: 15px; align-items: center; }
        .tool-icon { 
            cursor: pointer; position: relative; width: 42px; height: 42px; 
            border-radius: 10px; background: var(--surface); display: flex; 
            align-items: center; justify-content: center; 
        }
        .tool-icon svg { width: 20px; height: 20px; }
        #cart-badge { position: absolute; top: -4px; right: -4px; background: var(--accent); color: white; font-size: 0.7rem; padding: 2px 6px; border-radius: 50px; border: 2px solid var(--bg); }

        /* --- PRODUCT GRID --- */
        .container { max-width: 1400px; margin: 0 auto; padding: 20px 5%; flex: 1; width: 100%; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; }
        
        /* MOBILE GRID FIX */
        @media (max-width: 600px) {
            .grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            nav { padding: 0 15px; }
            .search-wrap { display: none; } /* Hide search on mobile nav to save space */
        }

        .card { border: 1px solid var(--border); border-radius: 16px; padding: 16px; background: var(--card-bg); cursor: pointer; transition: 0.2s; }
        .card:hover { border-color: var(--accent); transform: translateY(-4px); }
        .card img { width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 12px; }
        
        @media (max-width: 600px) {
            .card { padding: 10px; }
            .card img { height: 140px; }
        }

        .card h3 { font-size: 1rem; margin-bottom: 4px; }
        .card .price { font-weight: 700; font-size: 1.1rem; color: var(--accent); margin-bottom: 12px; }
        .btn-add { width: 100%; padding: 10px; background: var(--accent); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-add:disabled { opacity: 0.5; cursor: not-allowed; }

        /* --- FOOTER --- */
        footer { background: var(--surface); border-top: 1px solid var(--border); padding: 40px 5%; margin-top: 50px; }
        .footer-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .footer-info { color: var(--text-muted); }

        /* --- MODALS --- */
        .modal-overlay { 
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); 
            z-index: 5000; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 20px;
        }
        .detail-box { 
            background: var(--bg); width: 100%; max-width: 900px; border-radius: 24px; 
            display: grid; grid-template-columns: 1fr 1.2fr; overflow: hidden; position: relative; max-height: 90vh;
        }

        /* MOBILE MODAL FIX */
        @media (max-width: 768px) {
            .detail-box { grid-template-columns: 1fr; overflow-y: auto; }
            .detail-img { height: 250px; }
        }

        .detail-img { background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .detail-img img { width: 100%; height: 100%; object-fit: cover; }
        .detail-info { padding: 40px; overflow-y: auto; }
        @media (max-width: 600px) { .detail-info { padding: 20px; } }

        .spec-list { margin: 20px 0; }
        .spec-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
        .close-modal { position: absolute; top: 20px; right: 20px; cursor: pointer; z-index: 10; background: var(--bg); padding: 8px; border-radius: 50%; border: 1px solid var(--border); }

        /* --- ADMIN PANEL --- */
        #admin-panel { display: none; position: fixed; inset: 0; background: var(--bg); z-index: 4000; overflow-y: auto; padding: 40px 5%; }
        .admin-nav { display: flex; gap: 20px; border-bottom: 1px solid var(--border); margin-bottom: 30px; }
        .admin-nav-item { padding: 10px 20px; cursor: pointer; font-weight: 600; border-bottom: 2px solid transparent; }
        .admin-nav-item.active { border-color: var(--accent); color: var(--accent); }
        .admin-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        
        @media (max-width: 900px) {
            .admin-grid { grid-template-columns: 1fr; }
        }

        .admin-section { background: var(--surface); padding: 30px; border-radius: 20px; border: 1px solid var(--border); }
        .admin-input { width: 100%; padding: 12px; margin: 8px 0; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 0.9rem; }
        
        /* --- CART & CHECKOUT --- */
        #cart-panel { position: fixed; top: 0; right: -100%; width: 380px; height: 100%; background: var(--bg); z-index: 2000; display: flex; flex-direction: column; transition: 0.4s; border-left: 1px solid var(--border); }
        @media (max-width: 400px) { #cart-panel { width: 100%; } }
        #cart-panel.open { right: 0; }
        #cart-list { flex: 1; overflow-y: auto; padding: 20px; }
        
        .checkout-box { background: var(--bg); width: 100%; max-width: 450px; border-radius: 24px; padding: 30px; position: relative; }
        .fulfillment-options { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 15px 0; }
        .fulfillment-btn { padding: 12px; border: 1px solid var(--border); border-radius: 12px; text-align: center; cursor: pointer; font-weight: 600; background: var(--surface); }
        .fulfillment-btn.active { border-color: var(--accent); background: #2563eb10; color: var(--accent); }

        .report-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 15px; margin-bottom: 15px; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .status-pending { background: #fef3c7; color: #92400e; }

        #toast { position: fixed; bottom: -60px; left: 50%; transform: translateX(-50%); background: var(--text); color: var(--bg); padding: 10px 25px; border-radius: 8px; font-weight: 600; z-index: 6000; transition: 0.3s; }
        #toast.show { bottom: 30px; }

        @media print {
            body * { visibility: hidden; }
            #user-receipt, #user-receipt * { visibility: visible; }
            #user-receipt { position: fixed; left: 0; top: 0; width: 100%; border: none; padding: 20px; }
        }
        .receipt-actions { display: flex; gap: 10px; margin-top: 15px; }
        .btn-outline { flex: 1; padding: 10px; background: transparent; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; font-weight: 600; color: var(--text); display: flex; align-items: center; justify-content: center; gap: 5px; }
    </style>
</head>
<body data-theme="light">

    <nav>
        <div class="logo"><i data-lucide="cpu"></i> CORE</div>
        <div class="search-wrap">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" id="search-input" class="search-input" placeholder="Search products..." onkeyup="searchProducts()">
        </div>
        <div class="nav-tools">
            <div class="tool-icon" onclick="toggleTheme()"><i data-lucide="sun" id="theme-btn-icon"></i></div>
            <div class="tool-icon" onclick="togglePanel('cart-panel')">
                <i data-lucide="shopping-cart"></i>
                <span id="cart-badge">0</span>
            </div>
            <div class="tool-icon" style="background: var(--accent); color: white;" onclick="openAuth()"><i data-lucide="settings"></i></div>
        </div>
    </nav>

    <div id="toast">Added to bag</div>

    <main class="container">
        <div class="grid" id="shop-grid"></div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="logo"><i data-lucide="cpu"></i> CORE</div>
            <div class="footer-info">© 2026 CORE Enterprise Store. All rights reserved.</div>
            <div style="display: flex; gap: 20px;">
                <i data-lucide="twitter" style="cursor:pointer"></i>
                <i data-lucide="github" style="cursor:pointer"></i>
                <i data-lucide="linkedin" style="cursor:pointer"></i>
            </div>
        </div>
    </footer>

    <div id="checkout-modal" class="modal-overlay">
        <div class="checkout-box">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="font-size: 1.4rem;">Complete Order</h2>
                <i data-lucide="x" style="cursor:pointer" onclick="closeCheckout()"></i>
            </div>
            <form id="checkout-form" onsubmit="processOrder(event)">
                <label>Contact Information</label>
                <input type="text" id="cust-name" class="admin-input" placeholder="Full Name" required>
                <input type="tel" id="cust-phone" class="admin-input" placeholder="Phone Number" required>
                <label>Fulfillment Method</label>
                <div class="fulfillment-options">
                    <div id="btn-delivery" class="fulfillment-btn" onclick="setFulfillment('delivery')">
                        <i data-lucide="truck" style="width:16px; margin-bottom:4px"></i><br>Delivery
                    </div>
                    <div id="btn-pickup" class="fulfillment-btn" onclick="setFulfillment('pickup')">
                        <i data-lucide="store" style="width:16px; margin-bottom:4px"></i><br>Pickup
                    </div>
                </div>
                <div id="address-field" style="display:none">
                    <label>Delivery Address</label>
                    <textarea id="cust-address" class="admin-input" style="height:60px" placeholder="Street, Building, City"></textarea>
                </div>
                <div id="pickup-info" style="display:none; padding:15px; background:var(--surface); border-radius:12px; margin-top:10px; border:1px solid var(--border)">
                    <p style="font-size:0.8rem; color:var(--text-muted)">📍 Store: 123 Enterprise Way, Tech City. Ready in 20 mins.</p>
                </div>
                <div style="margin-top:20px; padding:15px; border-top:1px solid var(--border);">
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span>Total Amount</span>
                        <strong id="checkout-total">$0</strong>
                    </div>
                    <button type="submit" class="btn-add" style="padding:15px; font-size:1rem;">Confirm & Place Order</button>
                </div>
            </form>
        </div>
    </div>

    <div id="report-modal" class="modal-overlay">
        <div class="checkout-box" style="text-align: center; max-width: 500px;">
            <div id="report-loading">
                <i data-lucide="loader" class="spin" style="width: 40px; height: 40px; margin-bottom: 20px; color: var(--accent);"></i>
                <h2>Processing Order...</h2>
            </div>
            <div id="report-content" style="display: none;">
                <div style="background: #10b98120; color: #10b981; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i data-lucide="check-circle" size="32"></i>
                </div>
                <h2 style="margin-bottom: 10px;">Order Confirmed!</h2>
                <p style="color: var(--text-muted); margin-bottom: 20px;">Your order has been placed successfully.</p>
                <div id="user-receipt" style="text-align: left; background: var(--surface); padding: 20px; border-radius: 12px; border: 1px dashed var(--border);"></div>
                <div class="receipt-actions">
                    <button class="btn-outline" onclick="window.print()"><i data-lucide="printer" size="16"></i> Print</button>
                    <button class="btn-outline" onclick="downloadReceipt()"><i data-lucide="download" size="16"></i> Download</button>
                </div>
                <button class="btn-add" style="margin-top: 20px;" onclick="closeReport()">Done</button>
            </div>
        </div>
    </div>

    <div id="product-modal" class="modal-overlay" onclick="closeProductModal()">
        <div class="detail-box" onclick="event.stopPropagation()">
            <div class="close-modal" onclick="closeProductModal()"><i data-lucide="x"></i></div>
            <div class="detail-img"><img id="modal-img" src=""></div>
            <div class="detail-info">
                <h2 id="modal-title">Name</h2>
                <p id="modal-price" style="font-size: 1.5rem; font-weight: 700; color: var(--accent); margin-top: 5px;">$0</p>
                <div id="modal-specs" class="spec-list"></div>
                <p id="modal-desc" style="color: var(--text-muted); line-height: 1.6; margin-top: 15px;"></p>
                <button class="btn-add" id="modal-add-btn" style="padding: 15px; margin-top: 20px;">Add to Cart</button>
            </div>
        </div>
    </div>

    <div id="cart-panel">
        <div style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
            <h3>Your Bag</h3>
            <i data-lucide="x" style="cursor:pointer" onclick="togglePanel('cart-panel')"></i>
        </div>
        <div id="cart-list"></div>
        <div style="padding: 20px; border-top: 1px solid var(--border);">
            <div style="display:flex; justify-content:space-between; margin-bottom:10px; font-weight:700;">
                <span>Total</span><span id="total-price">$0</span>
            </div>
            <button class="btn-add" onclick="openCheckout()">Checkout</button>
        </div>
    </div>

    <div id="admin-panel">
        <div style="display:flex; justify-content:space-between; margin-bottom: 10px;">
            <h2>Management Console</h2>
            <div class="tool-icon" onclick="togglePanel('admin-panel')"><i data-lucide="x"></i></div>
        </div>
        <div class="admin-nav">
            <div class="admin-nav-item active" id="tab-inventory" onclick="switchAdminTab('inventory')">Inventory</div>
            <div class="admin-nav-item" id="tab-orders" onclick="switchAdminTab('orders')">Orders Received</div>
        </div>
        <div id="view-inventory" class="admin-grid">
            <div class="admin-section">