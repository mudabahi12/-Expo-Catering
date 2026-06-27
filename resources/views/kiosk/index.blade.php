@extends('layouts.app')

@section('title', 'Restaurant Ordering - Expo Catering')

@section('styles')
<style>
    /* Brands Theme: Cream & Orange Grid Theme */
    body {
        background-color: #fcfbfa !important;
        --primary-brand: #e65f2b;
        --primary-brand-hover: #cf4f20;
        background-image: 
            linear-gradient(to right, rgba(230, 95, 43, 0.03) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(230, 95, 43, 0.03) 1px, transparent 1px) !important;
        background-size: 30px 30px !important;
    }

    .kiosk-wrapper {
        display: grid;
        grid-template-columns: 1.8fr 1.2fr;
        gap: 2rem;
        align-items: start;
        margin-top: 1rem;
        position: relative;
    }

    @media (max-width: 1100px) {
        .kiosk-wrapper {
            grid-template-columns: 1fr;
        }
    }

    /* Kiosk Header */
    .kiosk-header {
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .kiosk-header h1 {
        font-family: 'Outfit', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    .kiosk-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }

    /* Category Scroll Chips */
    .category-scroll {
        display: flex;
        gap: 0.6rem;
        overflow-x: auto;
        padding-bottom: 0.75rem;
        margin-bottom: 1.75rem;
        scrollbar-width: none;
    }

    .category-scroll::-webkit-scrollbar {
        display: none;
    }

    .cat-chip {
        padding: 0.5rem 1.1rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        white-space: nowrap;
        transition: all 0.2s ease;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }

    .cat-chip:hover, .cat-chip.active {
        color: white;
        background: var(--primary-brand);
        border-color: var(--primary-brand);
        box-shadow: 0 4px 10px rgba(230, 95, 43, 0.15);
    }

    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.25rem;
        margin-bottom: 3rem;
    }

    .menu-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
    }

    .menu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -5px rgba(230, 95, 43, 0.08);
        border-color: rgba(230, 95, 43, 0.25);
    }

    .menu-img-container {
        height: 155px;
        position: relative;
        background: #f1f5f9;
        overflow: hidden;
    }

    .menu-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .menu-card:hover .menu-img {
        transform: scale(1.04);
    }

    .diet-match-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: rgba(16, 185, 129, 0.95);
        color: white;
        padding: 0.25rem 0.55rem;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .menu-body {
        padding: 1.1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .menu-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }

    .menu-desc {
        color: #64748b;
        font-size: 0.8rem;
        line-height: 1.4;
        margin-bottom: 0.85rem;
        flex: 1;
    }

    .menu-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
        margin-bottom: 0.85rem;
    }

    .menu-tag {
        font-size: 0.65rem;
        padding: 0.1rem 0.35rem;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 4px;
        font-weight: 600;
    }

    .menu-tag.matching {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .menu-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .menu-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary-brand);
    }

    .btn-add-to-cart {
        background: #0f172a;
        color: white;
        padding: 0.4rem 0.85rem;
        font-size: 0.75rem;
        border-radius: 6px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-add-to-cart:hover {
        background: var(--primary-brand);
        transform: translateY(-1px);
    }

    /* Kiosk Panel Styles */
    .kiosk-panel {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        position: sticky;
        top: 90px;
    }

    .panel-tabs {
        display: flex;
        background: #f8fafc;
        border-radius: 10px;
        padding: 0.3rem;
        margin-bottom: 1.25rem;
        border: 1px solid #e2e8f0;
    }

    .panel-tab-btn {
        flex: 1;
        background: none;
        border: none;
        color: #64748b;
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 700;
        padding: 0.55rem 0.25rem;
        cursor: pointer;
        border-radius: 7px;
        transition: all 0.2s ease;
        text-align: center;
    }

    .panel-tab-btn.active {
        color: var(--primary-brand);
        background: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .panel-content {
        display: none;
        animation: fadeIn 0.25s ease;
    }

    .panel-content.active {
        display: block;
    }

    /* AI Assistant Interface */
    .ai-assistant-container {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #fafafa;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);
    }

    .ai-assistant-header {
        background: #0f172a;
        color: white;
        padding: 0.65rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .ai-assistant-header .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        animation: pulseGreen 1.5s infinite;
    }

    .ai-chat-messages {
        height: 180px;
        overflow-y: auto;
        padding: 0.85rem;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .chat-bubble {
        max-width: 85%;
        padding: 0.55rem 0.85rem;
        border-radius: 10px;
        font-size: 0.8rem;
        line-height: 1.4;
    }

    .chat-bubble.assistant {
        background: white;
        color: #1e293b;
        align-self: flex-start;
        border: 1px solid #e2e8f0;
        border-top-left-radius: 2px;
    }

    .chat-bubble.user {
        background: var(--primary-brand);
        color: white;
        align-self: flex-end;
        border-top-right-radius: 2px;
    }

    .ai-input-area {
        display: flex;
        border-top: 1px solid #e2e8f0;
        background: white;
    }

    .ai-chat-input {
        flex: 1;
        border: none;
        padding: 0.6rem 0.85rem;
        font-size: 0.8rem;
        font-family: inherit;
        outline: none;
    }

    .btn-ai-send {
        background: none;
        border: none;
        padding: 0 0.85rem;
        cursor: pointer;
        color: var(--primary-brand);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-ai-send:hover {
        color: var(--primary-brand-hover);
    }

    /* Cart Items */
    .cart-list {
        max-height: 200px;
        overflow-y: auto;
        margin-bottom: 1rem;
        padding-right: 0.25rem;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f1f5f9;
        gap: 0.5rem;
    }

    .cart-item-name {
        font-weight: 700;
        font-size: 0.85rem;
        color: #1e293b;
    }

    .cart-item-price {
        font-size: 0.75rem;
        color: var(--primary-brand);
        font-weight: 700;
        margin-top: 0.1rem;
    }

    .cart-item-actions {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .qty-btn {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .qty-btn:hover {
        background: var(--primary-brand);
        color: white;
        border-color: var(--primary-brand);
    }

    .cart-item-qty {
        font-weight: 700;
        font-size: 0.8rem;
        min-width: 16px;
        text-align: center;
    }

    .cart-total-section {
        border-top: 1px solid #edf2f7;
        padding-top: 0.75rem;
        margin-bottom: 1rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* Checkout Form Styling */
    .checkout-form {
        margin-top: 1.25rem;
        border-top: 1px solid #edf2f7;
        padding-top: 1.25rem;
    }

    .form-group {
        margin-bottom: 0.95rem;
    }

    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 0.35rem;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: white;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary-brand);
    }

    /* Payment selectors */
    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .pay-method-option {
        border: 1px solid #cbd5e1;
        background: white;
        padding: 0.5rem;
        border-radius: 6px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pay-method-option.selected {
        border-color: var(--primary-brand);
        background: rgba(230, 95, 43, 0.05);
        color: var(--primary-brand);
        font-weight: 700;
    }

    .pay-method-icon {
        font-size: 1.1rem;
        margin-bottom: 0.15rem;
    }

    .pay-method-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .card-inputs-wrapper {
        border: 1px solid #e2e8f0;
        background: #fafafa;
        border-radius: 8px;
        padding: 0.85rem;
        margin-bottom: 1rem;
        animation: slideDown 0.2s ease;
    }

    /* Live Orders Tracker */
    .live-tracker-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
        margin-top: 1rem;
    }

    .tracker-col {
        border: 1px solid #e2e8f0;
        background: #fafafa;
        border-radius: 10px;
        padding: 0.85rem;
        min-height: 220px;
    }

    .tracker-col h3 {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.4rem;
        margin-bottom: 0.75rem;
    }

    .tracker-preparing-title { color: #2563eb; }
    .tracker-ready-title { color: #10b981; }

    .tracker-list {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        align-items: center;
    }

    .order-capsule {
        padding: 0.35rem 0.65rem;
        border-radius: 20px;
        font-weight: 800;
        font-size: 0.95rem;
        text-align: center;
        width: 100%;
        max-width: 100px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .order-prep-cap {
        background: rgba(37, 99, 235, 0.08);
        color: #2563eb;
        border: 1px solid rgba(37, 99, 235, 0.2);
    }

    .order-ready-cap {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
        animation: pulseReady 2s infinite;
    }

    @keyframes pulseGreen {
        0% { opacity: 0.4; }
        50% { opacity: 1; }
        100% { opacity: 0.4; }
    }

    @keyframes pulseReady {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="kiosk-header">
    <h1>Expo Ordering</h1>
    <p>Place your catering orders instantly. Use our AI Assistant to build your customized cart conversationally.</p>
</div>

<div class="kiosk-wrapper">
    <!-- Left Column: Menu -->
    <div>
        <!-- Category Filter Chips -->
        <div class="category-scroll">
            <span class="cat-chip active" onclick="filterCategory('all', this)">All Creations</span>
            @foreach($categories as $category)
                <span class="cat-chip" onclick="filterCategory('cat-{{ $category->id }}', this)">{{ $category->name }}</span>
            @endforeach
        </div>

        @auth
            @if(!empty($userPreferences))
                <div style="margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.12); padding: 0.5rem 0.85rem; border-radius: 10px;">
                    <label class="form-checkbox" style="margin: 0; color: #10b981; font-weight: 700; font-size: 0.85rem; display:flex; align-items:center; gap:0.4rem; cursor:pointer;">
                        <input type="checkbox" id="diet-filter-toggle" onchange="toggleDietFilter(this.checked)" style="accent-color:#10b981;">
                        <span>Highlight and filter my dietary preferences: ({{ implode(', ', $userPreferences) }})</span>
                    </label>
                </div>
            @endif
        @endauth

        <!-- Menu Grid -->
        <div class="menu-grid">
            @foreach($categories as $category)
                @foreach($category->menuItems as $item)
                    @php
                        $itemTags = $item->tags_array;
                        $matchesPref = false;
                        if (!empty($userPreferences)) {
                            $matches = array_intersect($userPreferences, $itemTags);
                            $matchesPref = count($matches) > 0;
                        }
                    @endphp
                    <div class="menu-card category-item cat-{{ $category->id }}" data-item-id="{{ $item->id }}" data-diet-match="{{ $matchesPref ? 'true' : 'false' }}">
                        <div class="menu-img-container">
                            <img src="{{ $item->image_path ? $item->image_path : '/images/default-dish.jpg' }}" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300'" alt="{{ $item->name }}" class="menu-img">
                            @if($matchesPref)
                                <div class="diet-match-badge">★ Diet Match</div>
                            @endif
                        </div>
                        <div class="menu-body">
                            <h3 class="menu-title">{{ $item->name }}</h3>
                            <p class="menu-desc">{{ $item->description }}</p>
                            
                            @if($item->tags)
                                <div class="menu-tags">
                                    @foreach($itemTags as $tag)
                                        @php
                                            $isMatching = in_array($tag, $userPreferences);
                                        @endphp
                                        <span class="menu-tag {{ $isMatching ? 'matching' : '' }}">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="menu-footer">
                                <span class="menu-price">£{{ number_format($item->price, 2) }}</span>
                                <button onclick="addToCart({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }})" class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Right Column: Console Sidebar -->
    <div class="kiosk-panel">
        <div class="panel-tabs">
            <button class="panel-tab-btn active" id="btn-cart" onclick="switchTab('tab-cart')">My Checkout</button>
            <button class="panel-tab-btn" id="btn-tracker" onclick="switchTab('tab-tracker')">Live Tracker</button>
            <button class="panel-tab-btn" id="btn-history" onclick="switchTab('tab-history')">Order History</button>
        </div>

        <!-- TAB: MY CHECKOUT -->
        <div id="tab-cart" class="panel-content active">
            <!-- AI Ordering Chatbot Widget -->
            <div class="ai-assistant-container">
                <div class="ai-assistant-header">
                    <div class="pulse-dot"></div>
                    <span>AI ORDERING ASSISTANT</span>
                </div>
                <div class="ai-chat-messages" id="ai-chat-container">
                    <div class="chat-bubble assistant">
                        Hi! I'm your catering assistant. Ask me to add dishes to your cart, suggest options based on dietary needs, or clear your cart! Try typing: <strong>"add 2 bruschetta and a steak"</strong>.
                    </div>
                </div>
                <div class="ai-input-area">
                    <input type="text" id="ai-user-input" class="ai-chat-input" placeholder="Type instructions here..." onkeydown="handleChatKey(event)">
                    <button onclick="sendChatMessage()" class="btn-ai-send">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polyline points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </div>
            </div>

            <!-- Cart content list -->
            <div id="empty-cart-msg" style="text-align: center; color: #64748b; padding: 1.5rem 0;">
                <p style="font-size: 1.25rem; margin-bottom: 0.25rem;">🛒</p>
                <p style="font-size: 0.85rem; font-weight: 500;">Your cart is empty</p>
            </div>

            <div id="cart-wrapper-el" style="display: none;">
                <div class="cart-list" id="cart-items-el">
                    <!-- Dynamic cart items -->
                </div>
                <div class="cart-total-section">
                    <div class="total-row">
                        <span>Grand Total:</span>
                        <span id="cart-total-amount">£0.00</span>
                    </div>
                </div>

                <!-- Checkout Form -->
                <form id="restaurant-checkout-form" onsubmit="submitCheckoutOrder(event)" class="checkout-form">
                    <div class="form-group">
                        <label class="form-label">Customer Name</label>
                        <input type="text" id="cust-name" class="form-control" placeholder="Jane Doe" value="{{ $user ? $user->name : '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Delivery Address / Table Location</label>
                        <input type="text" id="cust-location" class="form-control" placeholder="Table 4 or Delivery Site" value="{{ $user ? $user->address : '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact Details (Phone / Email)</label>
                        <input type="text" id="cust-contact" class="form-control" placeholder="e.g. +44 7700 900077" value="{{ $user ? $user->phone : '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Special Operations Notes</label>
                        <textarea id="cust-notes" class="form-control" rows="2" placeholder="Dietary restrictions or instructions..."></textarea>
                    </div>

                    <!-- Payment Method Selector -->
                    <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <div class="payment-methods-grid">
                            <div class="pay-method-option selected" id="pay-cc" onclick="selectPaymentMethod('credit_card')">
                                <div class="pay-method-icon">💳</div>
                                <div class="pay-method-label">Card</div>
                            </div>
                            <div class="pay-method-option" id="pay-invoice" onclick="selectPaymentMethod('invoice')">
                                <div class="pay-method-icon">📄</div>
                                <div class="pay-method-label">Invoice</div>
                            </div>
                            <div class="pay-method-option" id="pay-cash" onclick="selectPaymentMethod('cash')">
                                <div class="pay-method-icon">💵</div>
                                <div class="pay-method-label">Cash</div>
                            </div>
                        </div>
                    </div>

                    <!-- Credit Card Inputs (Dynamic) -->
                    <div id="credit-card-inputs" class="card-inputs-wrapper">
                        <div class="form-group">
                            <label class="form-label" style="font-size:0.65rem;">Card Number</label>
                            <input type="text" id="cc-num" class="form-control" placeholder="4111 2222 3333 4444" maxlength="19">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:0.65rem;">Expiry Date</label>
                                <input type="text" id="cc-exp" class="form-control" placeholder="MM/YY" maxlength="5">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" style="font-size:0.65rem;">CVC / Security Code</label>
                                <input type="text" id="cc-cvc" class="form-control" placeholder="123" maxlength="3">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="background: var(--primary-brand); border-radius: 8px; width: 100%; font-size: 0.95rem; padding: 0.7rem 1rem;">
                        Confirm & Place Order
                    </button>
                </form>
            </div>
        </div>

        <!-- TAB: LIVE TRACKER -->
        <div id="tab-tracker" class="panel-content">
            <h2 style="font-size: 1rem; font-weight:700; margin-bottom:0.25rem; color:#0f172a; text-align:center;">Real-time Kitchen Tracker</h2>
            <p style="font-size: 0.75rem; color:#64748b; text-align:center; margin-bottom:1.25rem;">Live view matching our kitchen display system screen.</p>
            
            <div class="live-tracker-grid">
                <div class="tracker-col">
                    <h3 class="tracker-preparing-title">Preparing</h3>
                    <div class="tracker-list" id="track-prep-list">
                        <!-- Polled -->
                    </div>
                </div>
                <div class="tracker-col">
                    <h3 class="tracker-ready-title">Ready</h3>
                    <div class="tracker-list" id="track-ready-list">
                        <!-- Polled -->
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: ORDER HISTORY -->
        <div id="tab-history" class="panel-content">
            <h2 style="font-size: 1rem; font-weight:700; margin-bottom:1rem; color:#0f172a; text-align:center;">My Past Catering Invoices</h2>
            
            @auth
                <div style="max-height: 420px; overflow-y: auto; padding-right: 0.25rem;">
                    @forelse($myOrders as $pastOrder)
                        <div style="background: #fafafa; border: 1px solid #e2e8f0; border-radius: 10px; padding: 0.75rem; margin-bottom: 0.6rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                                <strong style="font-size:0.85rem; color:#0f172a;">Order #{{ $pastOrder->id }}</strong>
                                <span class="badge badge-{{ $pastOrder->status }}" style="font-size: 0.6rem; padding: 0.15rem 0.4rem;">{{ $pastOrder->status }}</span>
                            </div>
                            <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 0.4rem; line-height: 1.4;">
                                @foreach($pastOrder->items as $pastItem)
                                    <span style="color: var(--primary-brand); font-weight: 700;">{{ $pastItem->quantity }}x</span> {{ $pastItem->menuItem->name ?? 'Dish' }}@if(!$loop->last), @endif
                                @endforeach
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.75rem; border-top: 1px solid #f1f5f9; padding-top: 0.4rem;">
                                <span>{{ $pastOrder->created_at->format('M d, H:i') }}</span>
                                <strong style="color: var(--primary-brand);">£{{ number_format($pastOrder->total_price, 2) }}</strong>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; color: #64748b; padding: 2rem 0;">
                            <p style="font-size: 1.5rem;">🍽</p>
                            <p style="margin-top: 0.25rem; font-size: 0.8rem;">No past invoice orders found.</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div style="text-align: center; color: #64748b; padding: 2rem 0;">
                    <p style="font-size: 1.75rem; margin-bottom: 0.5rem;">🔒</p>
                    <p style="font-size: 0.8rem; line-height: 1.4;">Create a restaurant account or log in to track your order invoices.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="margin-top: 1rem; background:#0f172a;">Log In</a>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- SUCCESS DIALOG OVERLAY -->
<div id="checkout-success-dialog" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(5px); z-index: 3000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div style="background: white; border: 1px solid #cbd5e1; max-width: 440px; width: 100%; text-align: center; border-radius: 16px; padding: 2rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="width: 60px; height: 60px; background: rgba(16, 185, 129, 0.1); border: 2px solid #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; font-size: 1.85rem; color: #10b981; font-weight:800;">
            ✓
        </div>
        <h2 style="font-family: 'Outfit', sans-serif; font-size: 1.6rem; color: #0f172a; margin-bottom: 0.5rem;">Catering Order Dispatched!</h2>
        <p style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin-bottom: 1.25rem;" id="success-modal-msg">
            Your invoice has been generated and queued for kitchen prep. You can track the status on the Live Tracker panel.
        </p>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.6rem; font-weight: 700; font-size: 0.85rem; margin-bottom: 1.5rem; color:#0f172a;" id="success-modal-order-tag">
            Invoice: #---
        </div>
        <button onclick="dismissSuccessDialog()" class="btn btn-primary" style="background:#0f172a; width: 100%; border-radius: 8px; font-size:0.9rem;">
            Track Order Status
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // State
    let cart = [];
    let activeCategory = 'all';
    let filterDietary = false;
    let selectedPayment = 'credit_card';

    // Menu Items JSON from Laravel for conversational parsing
    const availableMenuItems = @json($categories->flatMap->menuItems);

    // Initial message log
    const chatLog = [
        { sender: 'assistant', text: "Hi! I'm your catering assistant. Ask me to add dishes to your cart, suggest options based on dietary needs, or clear your cart! Try typing: <strong>\"add 2 bruschetta and a steak\"</strong>." }
    ];

    function filterCategory(catClass, element) {
        const chips = document.querySelectorAll(".cat-chip");
        chips.forEach(c => c.classList.remove("active"));
        element.classList.add("active");
        activeCategory = catClass;
        applyMenuFilters();
    }

    function toggleDietFilter(checked) {
        filterDietary = checked;
        applyMenuFilters();
    }

    function applyMenuFilters() {
        const items = document.querySelectorAll(".category-item");
        items.forEach(item => {
            const matchesCat = (activeCategory === 'all' || item.classList.contains(activeCategory));
            const matchesDiet = (!filterDietary || item.getAttribute('data-diet-match') === 'true');
            if (matchesCat && matchesDiet) {
                item.style.display = "flex";
            } else {
                item.style.display = "none";
            }
        });
    }

    function switchTab(tabId) {
        const contents = document.querySelectorAll(".panel-content");
        contents.forEach(c => c.classList.remove("active"));
        const buttons = document.querySelectorAll(".panel-tab-btn");
        buttons.forEach(b => b.classList.remove("active"));

        document.getElementById(tabId).classList.add("active");
        if (tabId === 'tab-cart') document.getElementById('btn-cart').classList.add('active');
        if (tabId === 'tab-tracker') {
            document.getElementById('btn-tracker').classList.add('active');
            pollLiveTracker();
        }
        if (tabId === 'tab-history') document.getElementById('btn-history').classList.add('active');
    }

    function selectPaymentMethod(method) {
        selectedPayment = method;
        document.querySelectorAll(".pay-method-option").forEach(el => el.classList.remove("selected"));
        
        const ccInputs = document.getElementById("credit-card-inputs");
        if (method === 'credit_card') {
            document.getElementById("pay-cc").classList.add("selected");
            ccInputs.style.display = "block";
        } else {
            ccInputs.style.display = "none";
            if (method === 'invoice') {
                document.getElementById("pay-invoice").classList.add("selected");
            } else {
                document.getElementById("pay-cash").classList.add("selected");
            }
        }
    }

    // Cart logic
    function addToCart(id, name, price, quantity = 1) {
        const existing = cart.find(item => item.id === id);
        if (existing) {
            existing.quantity += quantity;
        } else {
            cart.push({ id, name, price, quantity, notes: '' });
        }
        renderCart();
    }

    function changeQuantity(id, delta) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.quantity += delta;
            if (item.quantity <= 0) {
                cart = cart.filter(i => i.id !== id);
            }
            renderCart();
        }
    }

    function updateItemNotes(id, noteVal) {
        const item = cart.find(i => i.id === id);
        if (item) item.notes = noteVal;
    }

    function renderCart() {
        const emptyMsg = document.getElementById("empty-cart-msg");
        const cartWrapper = document.getElementById("cart-wrapper-el");
        const cartItemsContainer = document.getElementById("cart-items-el");
        const totalAmountEl = document.getElementById("cart-total-amount");

        if (cart.length === 0) {
            emptyMsg.style.display = "block";
            cartWrapper.style.display = "none";
            return;
        }

        emptyMsg.style.display = "none";
        cartWrapper.style.display = "block";

        let html = '';
        let total = 0;

        cart.forEach(item => {
            const lineTotal = item.price * item.quantity;
            total += lineTotal;
            html += `
                <div class="cart-item">
                    <div style="flex: 1;">
                        <span class="cart-item-name">${item.name}</span>
                        <div class="cart-item-price">£${item.price.toFixed(2)} x ${item.quantity} = £${lineTotal.toFixed(2)}</div>
                        <input type="text" class="form-control" style="font-size: 0.7rem; padding: 0.15rem 0.4rem; margin-top: 0.25rem;" 
                            placeholder="e.g. well-done, extra sauce" value="${item.notes}" oninput="updateItemNotes(${item.id}, this.value)">
                    </div>
                    <div class="cart-item-actions">
                        <button class="qty-btn" type="button" onclick="changeQuantity(${item.id}, -1)">-</button>
                        <span class="cart-item-qty">${item.quantity}</span>
                        <button class="qty-btn" type="button" onclick="changeQuantity(${item.id}, 1)">+</button>
                    </div>
                </div>
            `;
        });

        cartItemsContainer.innerHTML = html;
        totalAmountEl.textContent = `£${total.toFixed(2)}`;
    }

    // Checkout Order Submit via AJAX
    function submitCheckoutOrder(e) {
        e.preventDefault();
        if (cart.length === 0) return;

        const custName = document.getElementById("cust-name").value;
        const custLoc = document.getElementById("cust-location").value;
        const custCont = document.getElementById("cust-contact").value;
        const custNotes = document.getElementById("cust-notes").value;

        // Mock validation for Credit Card if selected
        if (selectedPayment === 'credit_card') {
            const ccNum = document.getElementById("cc-num").value;
            const ccExp = document.getElementById("cc-exp").value;
            const ccCvc = document.getElementById("cc-cvc").value;
            if (!ccNum || !ccExp || !ccCvc) {
                alert("Please fill out your Credit Card details.");
                return;
            }
        }

        const payload = {
            customer_name: custName,
            contact_info: custCont,
            table_number_or_delivery: custLoc,
            notes: (custNotes ? custNotes : '') + ` (Paid via ${selectedPayment.replace('_', ' ').toUpperCase()})`,
            cart: cart,
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route("kiosk.order.place") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById("success-modal-order-tag").textContent = "Invoice: #" + data.order_id;
                document.getElementById("checkout-success-dialog").style.display = "flex";
                
                // reset cart
                cart = [];
                renderCart();
                document.getElementById("cust-notes").value = '';
                document.getElementById("cc-num").value = '';
                document.getElementById("cc-exp").value = '';
                document.getElementById("cc-cvc").value = '';
            } else {
                alert("Order Error: " + (data.error || 'Server error'));
            }
        })
        .catch(err => {
            console.error(err);
            alert("Connection error placing catering order.");
        });
    }

    function dismissSuccessDialog() {
        document.getElementById("checkout-success-dialog").style.display = "none";
        switchTab("tab-tracker");
    }

    // Polling tracker lists
    function pollLiveTracker() {
        fetch('{{ route("kiosk.live-orders") }}')
        .then(res => res.json())
        .then(data => {
            const prepDiv = document.getElementById("track-prep-list");
            const readyDiv = document.getElementById("track-ready-list");

            if (data.preparing.length === 0) {
                prepDiv.innerHTML = '<span style="color:#94a3b8; font-size:0.75rem;">None preparing</span>';
            } else {
                prepDiv.innerHTML = data.preparing.map(o => `
                    <div class="order-capsule order-prep-cap">
                        #${o.id}
                        <div style="font-size:0.6rem; color:#64748b; font-weight:550; margin-top:0.1rem;">${o.customer_name}</div>
                    </div>
                `).join('');
            }

            if (data.ready.length === 0) {
                readyDiv.innerHTML = '<span style="color:#94a3b8; font-size:0.75rem;">None ready</span>';
            } else {
                readyDiv.innerHTML = data.ready.map(o => `
                    <div class="order-capsule order-ready-cap">
                        #${o.id}
                        <div style="font-size:0.6rem; color:#64748b; font-weight:550; margin-top:0.1rem;">${o.customer_name}</div>
                    </div>
                `).join('');
            }
        })
        .catch(err => console.error("Tracker poll error", err));
    }

    setInterval(pollLiveTracker, 4000);

    // AI Assistant Chatbot Engine (Conversational NLP Client-side Parser)
    function handleChatKey(e) {
        if (e.key === 'Enter') {
            sendChatMessage();
        }
    }

    function sendChatMessage() {
        const input = document.getElementById("ai-user-input");
        const query = input.value.trim();
        if (!query) return;

        input.value = '';
        appendMessage('user', query);

        // Process message
        setTimeout(() => {
            const responseText = processQuery(query);
            appendMessage('assistant', responseText);
        }, 350);
    }

    function appendMessage(sender, text) {
        const container = document.getElementById("ai-chat-container");
        const bubble = document.createElement("div");
        bubble.className = `chat-bubble ${sender}`;
        bubble.innerHTML = text;
        container.appendChild(bubble);
        container.scrollTop = container.scrollHeight;
    }

    function processQuery(text) {
        const clean = text.toLowerCase().trim();

        // 1. Help Commands
        if (clean.includes("help") || clean === "hi" || clean === "hello") {
            return "Sure, here are things you can ask me:<br>• <em>\"add 2 steaks and 1 bruschetta\"</em><br>• <em>\"suggest a vegetarian option\"</em><br>• <em>\"what starters do you have?\"</em><br>• <em>\"remove steak\"</em><br>• <em>\"clear my cart\"</em>";
        }

        // 2. Clear Cart
        if (clean.includes("clear cart") || clean.includes("empty cart") || clean.includes("remove all")) {
            cart = [];
            renderCart();
            return "I've emptied your shopping cart for you.";
        }

        // 3. Suggestions and Recommendations
        if (clean.includes("suggest") || clean.includes("recommend") || clean.includes("what is") || clean.includes("find")) {
            let matched = [];
            
            if (clean.includes("veg") || clean.includes("vegetarian")) {
                matched = availableMenuItems.filter(i => i.tags && i.tags.toLowerCase().includes("vegetarian"));
            } else if (clean.includes("halal")) {
                matched = availableMenuItems.filter(i => i.tags && i.tags.toLowerCase().includes("halal"));
            } else if (clean.includes("gluten") || clean.includes("gf")) {
                matched = availableMenuItems.filter(i => i.tags && i.tags.toLowerCase().includes("gluten"));
            } else if (clean.includes("appetizer") || clean.includes("starter")) {
                matched = availableMenuItems.filter(i => i.category_id == 1);
            } else if (clean.includes("steak") || clean.includes("main") || clean.includes("ribeye")) {
                matched = availableMenuItems.filter(i => i.category_id == 2);
            }

            if (matched.length > 0) {
                const item = matched[Math.floor(Math.random() * matched.length)];
                return `How about the <strong>${item.name}</strong>? It costs £${item.price.toFixed(2)} and features description: "${item.description}". Tell me if you'd like me to add it!`;
            }

            // Pick a random recommendation if specific filters fail
            const randItem = availableMenuItems[Math.floor(Math.random() * availableMenuItems.length)];
            return `I recommend trying our <strong>${randItem.name}</strong> (Price: £${randItem.price.toFixed(2)}). Shall I add one to your cart?`;
        }

        // 4. Add items
        if (clean.includes("add") || clean.includes("order") || clean.includes("buy") || clean.includes("get")) {
            // Parse counts and item names
            // We search for item keywords in query
            let addedLog = [];
            
            availableMenuItems.forEach(item => {
                const itemNameLower = item.name.toLowerCase();
                const keywords = itemNameLower.split(' ');
                
                // Let's check if the query contains the full item name or its core keywords
                let matched = false;
                if (clean.includes(itemNameLower)) {
                    matched = true;
                } else if (keywords.length > 1 && keywords.every(kw => kw.length > 3 && clean.includes(kw))) {
                    matched = true;
                } else if (keywords.some(kw => kw.length > 4 && clean.includes(kw))) {
                    // fallback partial matches like "bruschetta"
                    matched = true;
                }

                if (matched) {
                    // Extract quantity. Look at word immediately before or keyword itself
                    let qty = 1;
                    // Simple regex to find number before the name or match partial patterns
                    const regex = new RegExp(`(\\d+)\\s*(?:x\\s*)?${itemNameLower.substring(0, 7)}`);
                    const match = clean.match(regex);
                    if (match && match[1]) {
                        qty = parseInt(match[1]);
                    } else {
                        // try search for words "two", "three", "four", etc.
                        if (clean.includes("two ") || clean.includes("2 ")) qty = 2;
                        if (clean.includes("three ") || clean.includes("3 ")) qty = 3;
                        if (clean.includes("four ") || clean.includes("4 ")) qty = 4;
                        if (clean.includes("five ") || clean.includes("5 ")) qty = 5;
                    }

                    addToCart(item.id, item.name, item.price, qty);
                    addedLog.push(`${qty}x ${item.name}`);
                }
            });

            if (addedLog.length > 0) {
                return `Added <strong>${addedLog.join(', ')}</strong> to your shopping checkout cart!`;
            }

            return "I couldn't identify the menu item you wanted to add. Try naming items explicitly like: <em>\"add truffle bruschetta\"</em> or <em>\"add 2 steaks\"</em>.";
        }

        // 5. Remove items
        if (clean.includes("remove") || clean.includes("delete") || clean.includes("subtract")) {
            let removedItem = null;
            availableMenuItems.forEach(item => {
                if (clean.includes(item.name.toLowerCase()) || clean.includes(item.name.toLowerCase().split(' ')[0])) {
                    cart = cart.filter(c => c.id !== item.id);
                    removedItem = item.name;
                }
            });
            if (removedItem) {
                renderCart();
                return `Removed <strong>${removedItem}</strong> from your cart.`;
            }
            return "I couldn't find that item in your cart. Try typing: <em>\"remove steak\"</em>.";
        }

        // 6. Generic Fallback
        return "I heard you, but I'm not sure how to assist. Try asking me to add items (e.g. <em>\"add steak\"</em>), suggest items (e.g. <em>\"suggest something vegetarian\"</em>) or clear cart.";
    }
</script>
@endsection
