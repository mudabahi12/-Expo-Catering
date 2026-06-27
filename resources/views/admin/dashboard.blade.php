@extends('layouts.app')

@section('title', 'Expo Operations Console')

@section('styles')
<style>
    /* 1. HIDE THE GLOBAL TOP BAR */
    header {
        display: none !important;
    }

    main {
        padding: 0 !important;
        max-width: 100% !important;
        margin: 0 !important;
        width: 100% !important;
    }

    footer {
        display: none !important;
    }

    /* 2. DASHBOARD MAIN LAYOUT */
    .dashboard-container {
        display: grid;
        grid-template-columns: 260px 1fr;
        min-height: 100vh;
        background: #f8fafc;
    }

    @media (max-width: 992px) {
        .dashboard-container {
            grid-template-columns: 1fr;
        }
        .sidebar {
            display: none;
        }
    }

    /* 3. SIDEBAR STYLING */
    .sidebar {
        background: #0f172a;
        color: #94a3b8;
        padding: 1.5rem 1.25rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: sticky;
        top: 0;
        height: 100vh;
        border-right: 1px solid #1e293b;
        z-index: 100;
    }

    .brand-section {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: white;
        margin-bottom: 2rem;
    }

    .brand-logo-icon {
        width: 32px;
        height: 32px;
        background: #e65f2b; /* orange accent */
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-family: 'Outfit', sans-serif;
    }

    .brand-logo-text {
        font-family: 'Outfit', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .sidebar-menu {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .sidebar-section-title {
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 1px;
        color: #475569;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .sidebar-links-list {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        list-style: none;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0.85rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .sidebar-link:hover, .sidebar-link.active {
        color: white;
        background: #1e293b;
    }

    .sidebar-link.active {
        border-left: 3px solid #e65f2b;
        background: #1e293b;
    }

    .sidebar-profile {
        border-top: 1px solid #1e293b;
        padding-top: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .profile-meta-grp {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .profile-avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #e65f2b;
        color: white;
        font-weight: 800;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
    }

    .profile-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: white;
    }

    .profile-role {
        font-size: 0.65rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
    }

    .logout-action-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #475569;
        transition: color 0.2s ease;
    }

    .logout-action-btn:hover {
        color: #ef4444;
    }

    /* 4. CONTENT VIEWPORT STYLING */
    .viewport {
        padding: 2.25rem 3rem;
        overflow-y: auto;
        height: 100vh;
    }

    .view-tab-content {
        display: none;
        animation: fadeIn 0.2s ease;
    }

    .view-tab-content.active {
        display: block;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h1 {
        font-family: 'Outfit', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
    }

    .page-header p {
        font-size: 0.9rem;
        color: #64748b;
        margin-top: 0.2rem;
    }

    /* Card Panels & Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.25rem;
    }

    .stat-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.01);
    }

    .stat-card-title {
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
    }

    .stat-card-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-icon.orange { background: rgba(230, 95, 43, 0.08); color: #e65f2b; }
    .stat-icon.blue { background: rgba(59, 130, 246, 0.08); color: #3b82f6; }
    .stat-icon.purple { background: rgba(168, 85, 247, 0.08); color: #a855f7; }
    .stat-icon.green { background: rgba(16, 185, 129, 0.08); color: #10b981; }

    /* Tables & Forms layout */
    .grid-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.75rem;
    }

    @media (max-width: 1100px) {
        .grid-container {
            grid-template-columns: 1fr;
        }
    }

    .panel-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.01);
        margin-bottom: 1.5rem;
    }

    .panel-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Forms */
    .form-group {
        margin-bottom: 1.1rem;
    }

    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 0.35rem;
    }

    .form-control {
        width: 100%;
        padding: 0.55rem 0.75rem;
        font-size: 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: white;
        outline: none;
    }

    .form-control:focus {
        border-color: #e65f2b;
    }

    .btn-submit {
        background: #0f172a;
        color: white;
        font-weight: 700;
        border-radius: 6px;
        padding: 0.55rem 1.25rem;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
        transition: background-color 0.2s ease;
    }

    .btn-submit:hover {
        background: #e65f2b;
    }

    /* Data Tables */
    .data-table-wrapper {
        overflow-x: auto;
    }

    .console-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.85rem;
    }

    .console-table th {
        background: #f8fafc;
        padding: 0.65rem 0.85rem;
        color: #475569;
        font-weight: 700;
        border-bottom: 1px solid #e2e8f0;
    }

    .console-table td {
        padding: 0.85rem;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }

    .console-table tr:hover td {
        background: #fafafa;
    }

    /* Badges */
    .badge {
        padding: 0.2rem 0.5rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
    }

    .badge-pending { background: #fef3c7; color: #d97706; }
    .badge-preparing { background: #dbeafe; color: #2563eb; }
    .badge-ready { background: #d1fae5; color: #059669; }
    .badge-completed { background: #f1f5f9; color: #475569; }
    .badge-cancelled { background: #fee2e2; color: #dc2626; }

    /* Partners Grid */
    .partners-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
    }

    .partner-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 1px 3px rgba(0,0,0,0.01);
    }

    .partner-card-hdr {
        padding: 1.1rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .partner-avatar {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: white;
        border: 1px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .partner-card-body {
        padding: 1.1rem;
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.4;
        flex: 1;
    }

    .partner-card-footer {
        padding: 0.75rem 1.1rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        text-align: center;
    }

    .partner-stat-num {
        font-weight: 800;
        color: #0f172a;
        font-size: 0.95rem;
    }

    .partner-stat-lbl {
        font-size: 0.6rem;
        color: #94a3b8;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Menu Grid Inside Admin */
    .menu-admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
    }

    .menu-admin-card {
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        padding: 0.75rem;
        display: flex;
        gap: 0.75rem;
        align-items: center;
        position: relative;
    }

    .menu-admin-img {
        width: 50px;
        height: 50px;
        border-radius: 6px;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    
    <!-- LEFT SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-wrapper">
            <a href="/" class="brand-section">
                <div class="brand-logo-icon">E</div>
                <span class="brand-logo-text">Expo Console</span>
            </a>

            <!-- CORE OPERATIONS -->
            <div class="sidebar-menu">
                <div>
                    <div class="sidebar-section-title">Core Operations</div>
                    <ul class="sidebar-links-list">
                        <li>
                            <a class="sidebar-link active" onclick="switchSidebarTab('dashboard', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="sidebar-link" onclick="switchSidebarTab('orders', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                Orders
                            </a>
                        </li>
                        <li>
                            <a class="sidebar-link" onclick="switchSidebarTab('production', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                Production Sheet
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- CLIENT RELATIONSHIPS (CRM) -->
                <div>
                    <div class="sidebar-section-title">Clients Directory</div>
                    <ul class="sidebar-links-list">
                        <li>
                            <a class="sidebar-link" onclick="switchSidebarTab('companies', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                Companies
                            </a>
                        </li>
                        <li>
                            <a class="sidebar-link" onclick="switchSidebarTab('contacts', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                Contacts
                            </a>
                        </li>
                        <li>
                            <a class="sidebar-link" onclick="switchSidebarTab('addresses', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                Delivery Addresses
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- MENU MANAGEMENT -->
                <div>
                    <div class="sidebar-section-title">Menu Setup</div>
                    <ul class="sidebar-links-list">
                        <li>
                            <a class="sidebar-link" onclick="switchSidebarTab('menu', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                Menu Items
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- SETTINGS & CONTROLS -->
                <div>
                    <div class="sidebar-section-title">Configuration</div>
                    <ul class="sidebar-links-list">
                        <li>
                            <a class="sidebar-link" onclick="switchSidebarTab('settings', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                Configuration
                            </a>
                        </li>
                        <li>
                            <a class="sidebar-link" onclick="switchSidebarTab('users', this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Users Directory
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- PROFILE DRAWER -->
        <div class="sidebar-profile">
            <div class="profile-meta-grp">
                <div class="profile-avatar-circle">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="profile-info">
                    <span class="profile-name">{{ auth()->user()->name }}</span>
                    <span class="profile-role">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-action-btn" title="Sign Out">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN VIEWPORT CONTENT -->
    <div class="viewport">

        <!-- ================= 1. TAB: DASHBOARD ================= -->
        <div id="tab-dashboard" class="view-tab-content active">
            <div class="page-header">
                <div>
                    <h1>Catering System Dashboard</h1>
                    <p>Aggregated metrics across registered kitchens, outlets, and system accounts.</p>
                </div>
                <div>
                    @if(auth()->user()->isSuperAdmin())
                        <button onclick="openAdminModal('modal-add-restaurant')" class="btn-submit" style="background:#e65f2b;">+ Add Restaurant</button>
                    @endif
                </div>
            </div>

            <!-- Stats Rows -->
            <div class="stats-row">
                <div class="stat-card">
                    <div>
                        <div class="stat-card-title">Completed Catering Sales</div>
                        <div class="stat-card-value">£{{ number_format($completedSales, 2) }}</div>
                    </div>
                    <div class="stat-icon green">£</div>
                </div>
                <div class="stat-card">
                    <div>
                        <div class="stat-card-title">Catering Partners</div>
                        <div class="stat-card-value">{{ $restaurants->count() }}</div>
                    </div>
                    <div class="stat-icon blue">🏢</div>
                </div>
                <div class="stat-card">
                    <div>
                        <div class="stat-card-title">Total System Accounts</div>
                        <div class="stat-card-value">{{ $totalAccounts }}</div>
                    </div>
                    <div class="stat-icon purple">👥</div>
                </div>
                <div class="stat-card">
                    <div>
                        <div class="stat-card-title">Active Orders Pending</div>
                        <div class="stat-card-value">{{ $activePendingOrders }}</div>
                    </div>
                    <div class="stat-icon orange">⏳</div>
                </div>
            </div>

            <!-- Partners Grid -->
            <div class="panel-card">
                <div class="panel-card-title">Active Catering Partners</div>
                <div class="partners-grid">
                    @foreach($restaurants as $restaurant)
                        <div class="partner-card">
                            <div class="partner-card-hdr">
                                <div class="partner-avatar">{{ $restaurant->icon ?? '🏢' }}</div>
                                <div>
                                    <strong style="color:#0f172a; font-size:0.9rem;">{{ $restaurant->name }}</strong>
                                    <div style="font-size:0.75rem; color:#94a3b8;">{{ $restaurant->phone }}</div>
                                </div>
                            </div>
                            <div class="partner-card-body">
                                <p style="margin-bottom:0.75rem;">{{ $restaurant->description }}</p>
                                <div style="font-size:0.75rem; color:#94a3b8; display:flex; align-items:center; gap:0.25rem;">
                                    📍 {{ $restaurant->address }}
                                </div>
                            </div>
                            <div class="partner-card-footer">
                                <div>
                                    <div class="partner-stat-num">{{ $restaurant->staff_count }}</div>
                                    <div class="partner-stat-lbl">Staff</div>
                                </div>
                                <div>
                                    <div class="partner-stat-num">{{ $restaurant->dishes_count }}</div>
                                    <div class="partner-stat-lbl">Dishes</div>
                                </div>
                                <div>
                                    <div class="partner-stat-num">{{ $restaurant->orders_count }}</div>
                                    <div class="partner-stat-lbl">Orders</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ================= 2. TAB: ORDERS ================= -->
        <div id="tab-orders" class="view-tab-content">
            <div class="page-header">
                <div>
                    <h1>Catering Order Matrix</h1>
                    <p>Live tracking and dispatch operations console.</p>
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card-title">Orders Archive</div>
                <div class="data-table-wrapper">
                    <table class="console-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Details</th>
                                <th>Creations List</th>
                                <th>Location & Dropoff</th>
                                <th>Price Total</th>
                                <th>Status Badge</th>
                                <th>Dispatch Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>
                                        <strong>{{ $order->customer_name }}</strong>
                                        <div style="font-size:0.75rem; color:#64748b;">{{ $order->contact_info }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight:600;">
                                            @foreach($order->items as $item)
                                                {{ $item->quantity }}x {{ $item->menuItem->name ?? 'Dish' }}@if(!$loop->last), @endif
                                            @endforeach
                                        </div>
                                        @if($order->notes)
                                            <div style="font-size:0.75rem; color:#e65f2b; font-style:italic;">"{{ $order->notes }}"</div>
                                        @endif
                                    </td>
                                    <td>{{ $order->table_number_or_delivery ?? 'N/A' }}</td>
                                    <td><strong style="color:#e65f2b;">£{{ number_format($order->total_price, 2) }}</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $order->status }}">{{ $order->status }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-control" style="width:120px; font-size:0.8rem; padding:0.25rem;" onchange="this.form.submit()">
                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                                <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center; color:#94a3b8; padding:2rem;">No orders placed in system.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 3. TAB: PRODUCTION SHEET ================= -->
        <div id="tab-production" class="view-tab-content">
            <div class="page-header">
                <div>
                    <h1>Daily Production Prep Sheet</h1>
                    <p>Consolidated kitchen assembly prep checklist summarizing quantities of active orders.</p>
                </div>
                <div>
                    <button onclick="window.print()" class="btn-submit" style="background:#0f172a;">Print Prep List</button>
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card-title">Aggregated Dish Quantities Needed</div>
                <div class="data-table-wrapper">
                    <table class="console-table">
                        <thead>
                            <tr>
                                <th>Menu Item Name</th>
                                <th>Aggregated Quantity (To Cook)</th>
                                <th>Unit Price</th>
                                <th>Consolidated Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totPrep = 0; @endphp
                            @forelse($productionItems as $pItem)
                                <tr>
                                    <td><strong>{{ $pItem->name }}</strong></td>
                                    <td>
                                        <span style="font-size:1.1rem; font-weight:800; color:#e65f2b;">{{ $pItem->total_qty }}</span> units
                                    </td>
                                    <td>
                                        @php 
                                            $mObj = \App\Models\MenuItem::where('name', $pItem->name)->first();
                                            $price = $mObj ? $mObj->price : 0;
                                        @endphp
                                        £{{ number_format($price, 2) }}
                                    </td>
                                    <td><strong>£{{ number_format($price * $pItem->total_qty, 2) }}</strong></td>
                                </tr>
                                @php $totPrep += $pItem->total_qty; @endphp
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center; color:#94a3b8; padding:2rem;">No active items to prepare today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($totPrep > 0)
                            <tfoot>
                                <tr>
                                    <td><strong>Total Units Needed:</strong></td>
                                    <td><strong style="font-size:1.1rem; color:#e65f2b;">{{ $totPrep }}</strong></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 4. TAB: COMPANIES ================= -->
        <div id="tab-companies" class="view-tab-content">
            <div class="page-header">
                <div>
                    <h1>Corporate Clients Matrix</h1>
                    <p>Corporate partners and pharmaceutical company profiles directory.</p>
                </div>
            </div>

            <div class="grid-container">
                <!-- Directory -->
                <div class="panel-card">
                    <div class="panel-card-title">Corporate Directory</div>
                    <div class="data-table-wrapper">
                        <table class="console-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Industry</th>
                                    <th>Phone line</th>
                                    <th>Linked Contacts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($companies as $company)
                                    <tr>
                                        <td>#{{ $company->id }}</td>
                                        <td><strong>{{ $company->name }}</strong></td>
                                        <td><span class="badge" style="background:#f1f5f9; color:#4f46e5;">{{ $company->industry ?? 'N/A' }}</span></td>
                                        <td>{{ $company->phone ?? 'N/A' }}</td>
                                        <td><strong>{{ $company->contacts_count }}</strong> representatives</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center; color:#94a3b8; padding:2rem;">No corporate accounts registered.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Add Form -->
                <div class="panel-card">
                    <div class="panel-card-title">Quick Add Company</div>
                    <form action="{{ route('admin.companies.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. AstraZeneca UK" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Industry Classification</label>
                            <input type="text" name="industry" class="form-control" placeholder="e.g. Pharmaceuticals">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Hotline</label>
                            <input type="text" name="phone" class="form-control" placeholder="e.g. +44 20 7946 9900">
                        </div>
                        <button type="submit" class="btn-submit" style="width:100%;">Save Company profile</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ================= 5. TAB: CONTACTS ================= -->
        <div id="tab-contacts" class="view-tab-content">
            <div class="page-header">
                <div>
                    <h1>Contact Directory</h1>
                    <p>Client representatives, event organizers and designated medical planners.</p>
                </div>
            </div>

            <div class="grid-container">
                <!-- Table -->
                <div class="panel-card">
                    <div class="panel-card-title">System Contacts List</div>
                    <div class="data-table-wrapper">
                        <table class="console-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Linked Company</th>
                                    <th>Email Address</th>
                                    <th>Phone Line</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                    <tr>
                                        <td><strong>{{ $contact->name }}</strong></td>
                                        <td>
                                            @if($contact->company)
                                                <span class="badge" style="background:#e0e7ff; color:#3730a3;">{{ $contact->company->name }}</span>
                                            @else
                                                <span style="color:#94a3b8; font-style:italic;">Independent Planner</span>
                                            @endif
                                        </td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->phone ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center; color:#94a3b8; padding:2rem;">No contacts registered.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add form -->
                <div class="panel-card">
                    <div class="panel-card-title">Create Contact</div>
                    <form action="{{ route('admin.contacts.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Full Representative Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Sarah Jenkins" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="sarah@example.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="e.g. +44 7700 900077">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Corporate Account Link</label>
                            <select name="company_id" class="form-control">
                                <option value="">-- Independent (No Link) --</option>
                                @foreach($companies as $co)
                                    <option value="{{ $co->id }}">{{ $co->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn-submit" style="width:100%;">Create Representative</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ================= 6. TAB: ADDRESSES ================= -->
        <div id="tab-addresses" class="view-tab-content">
            <div class="page-header">
                <div>
                    <h1>Delivery Addresses Directory</h1>
                    <p>Designated shipping sites, office conference hubs, and client logistics dropoffs.</p>
                </div>
            </div>

            <div class="grid-container">
                <!-- Table -->
                <div class="panel-card">
                    <div class="panel-card-title">Dropoff Registry</div>
                    <div class="data-table-wrapper">
                        <table class="console-table">
                            <thead>
                                <tr>
                                    <th>Linked Contact</th>
                                    <th>Street Address</th>
                                    <th>City / Postal Code</th>
                                    <th>Drop-off Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deliveryAddresses as $address)
                                    <tr>
                                        <td>
                                            @if($address->contact)
                                                <strong>{{ $address->contact->name }}</strong>
                                                @if($address->contact->company)
                                                    <br><span style="font-size:0.7rem; color:#94a3b8;">({{ $address->contact->company->name }})</span>
                                                @endif
                                            @else
                                                <span style="color:#94a3b8; font-style:italic;">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $address->street }}</td>
                                        <td><strong>{{ $address->city }}</strong>, {{ $address->postal_code }}</td>
                                        <td><span style="font-size:0.75rem; color:#64748b; font-style:italic;">{{ $address->notes ?? 'None' }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center; color:#94a3b8; padding:2rem;">No delivery addresses found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add form -->
                <div class="panel-card">
                    <div class="panel-card-title">Register Address</div>
                    <form action="{{ route('admin.delivery-addresses.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Street Delivery line</label>
                            <input type="text" name="street" class="form-control" placeholder="100 Discovery Way" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" placeholder="London" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" placeholder="CB2 0QQ" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Link</label>
                            <select name="contact_id" class="form-control">
                                <option value="">-- No Contact Link --</option>
                                @foreach($contacts as $ct)
                                    <option value="{{ $ct->id }}">{{ $ct->name }} @if($ct->company) ({{ $ct->company->name }}) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Logistics Instructions</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Leave with receptionist at Reception B"></textarea>
                        </div>
                        <button type="submit" class="btn-submit" style="width:100%;">Save Dropoff Address</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ================= 7. TAB: MENU ================= -->
        <div id="tab-menu" class="view-tab-content">
            <div class="page-header">
                <div>
                    <h1>Menu Management Console</h1>
                    <p>Manage appetizers, main courses, desserts, pricing, and active stock availability.</p>
                </div>
                <div>
                    <button onclick="toggleAddItemForm()" class="btn-submit" style="background:#e65f2b;">+ Add Menu Item</button>
                </div>
            </div>

            <div class="grid-container">
                <!-- Menu list & Addition form -->
                <div>
                    <!-- Form: Add Menu Item (Hidden by default) -->
                    <div id="add-item-form-container" class="panel-card" style="display: none; background: #fafafa;">
                        <div class="panel-card-title">Add New Dish Creation</div>
                        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Menu Category</label>
                                <select name="category_id" class="form-control" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dish / Creation Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Truffle Bruschetta" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Price (£)</label>
                                <input type="number" name="price" step="0.01" class="form-control" placeholder="14.50" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dish Description</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Describe the culinary creation..."></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dietary Tags (comma separated)</label>
                                <input type="text" name="tags" class="form-control" placeholder="Vegetarian, Gluten-Free, Halal">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dish Picture (Optional)</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group" style="display:flex; align-items:center; gap:0.5rem; margin-top:1rem;">
                                <input type="checkbox" name="is_available" value="1" checked style="accent-color:#e65f2b; cursor:pointer;" id="chk-avail">
                                <label for="chk-avail" style="font-size:0.8rem; font-weight:700; color:#475569; cursor:pointer;">Available in ordering catalog</label>
                            </div>
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end; margin-top: 1rem;">
                                <button type="button" class="btn-submit" style="background:#94a3b8;" onclick="toggleAddItemForm()">Cancel</button>
                                <button type="submit" class="btn-submit" style="background:#e65f2b;">Save Item</button>
                            </div>
                        </form>
                    </div>

                    <!-- Items grid -->
                    <div class="panel-card">
                        <div class="panel-card-title">Dish Catalog</div>
                        <div class="menu-admin-grid">
                            @foreach($menuItems as $item)
                                <div class="menu-admin-card">
                                    <img src="{{ $item->image_path ? $item->image_path : '/images/default-dish.jpg' }}" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100'" alt="{{ $item->name }}" class="menu-admin-img">
                                    <div style="flex:1;">
                                        <strong style="font-size:0.85rem; color:#0f172a; display:block;">{{ $item->name }}</strong>
                                        <span style="font-size:0.7rem; color:#94a3b8; display:block;">{{ $item->category->name ?? 'Dish' }}</span>
                                        <strong style="font-size:0.85rem; color:#e65f2b;">£{{ number_format($item->price, 2) }}</strong>
                                        
                                        <!-- Actions -->
                                        <div style="display:flex; gap:0.25rem; margin-top:0.35rem;">
                                            <form action="{{ route('admin.menu.toggle-availability', $item->id) }}" method="POST" style="margin:0;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-submit" style="font-size:0.6rem; padding:0.15rem 0.35rem; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1;">
                                                    {{ $item->is_available ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.menu.delete', $item->id) }}" method="POST" style="margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-submit" style="font-size:0.6rem; padding:0.15rem 0.35rem; background:#fee2e2; color:#ef4444;" onclick="return confirm('Delete this menu item?')">
                                                    Del
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div style="position:absolute; top:0.25rem; right:0.25rem;">
                                        <span class="badge {{ $item->is_available ? 'badge-ready' : 'badge-cancelled' }}" style="font-size:0.55rem;">
                                            {{ $item->is_available ? 'In' : 'Out' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Categories column -->
                <div class="panel-card">
                    <div class="panel-card-title">Menu Categories</div>
                    <form action="{{ route('admin.categories.store') }}" method="POST" style="margin-bottom:1.5rem;">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Appetizers" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Brief description..."></textarea>
                        </div>
                        <button type="submit" class="btn-submit" style="width:100%;">Add Category</button>
                    </form>

                    <h4 style="font-size:0.8rem; color:#475569; margin-bottom:0.5rem; text-transform:uppercase; font-weight:700; border-bottom:1px solid #e2e8f0; padding-bottom:0.35rem;">Categories list</h4>
                    <ul style="list-style:none; font-size:0.8rem;">
                        @foreach($categories as $cat)
                            <li style="display:flex; justify-content:space-between; align-items:center; padding:0.4rem 0; border-bottom:1px solid #f1f5f9;">
                                <div>
                                    <strong>{{ $cat->name }}</strong>
                                    <span style="color:#94a3b8; font-size:0.75rem;">({{ $cat->menu_items_count }} items)</span>
                                </div>
                                <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-submit" style="font-size:0.6rem; padding:0.15rem 0.35rem; background:#fee2e2; color:#ef4444;" onclick="return confirm('Delete category and all its items?')">Del</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- ================= 8. TAB: CONFIGURATION ================= -->
        <div id="tab-settings" class="view-tab-content">
            <div class="page-header">
                <div>
                    <h1>Global Configuration Parameters</h1>
                    <p>Modify business tax rates, base currency symbols, operations parameters and site details.</p>
                </div>
            </div>

            <div class="panel-card" style="max-width:550px;">
                <div class="panel-card-title">Configuration settings</div>
                <form action="{{ route('admin.configuration.update') }}" method="POST">
                    @csrf
                    
                    @php
                        $bizName = $settings->where('key', 'business_name')->first()->value ?? 'Expo Catering';
                        $taxRate = $settings->where('key', 'tax_rate')->first()->value ?? '12.5';
                        $currency = $settings->where('key', 'currency')->first()->value ?? '£';
                    @endphp

                    <div class="form-group">
                        <label class="form-label">Business Name</label>
                        <input type="text" name="business_name" class="form-control" value="{{ $bizName }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Default Tax Rate (%)</label>
                        <input type="number" name="tax_rate" step="0.01" class="form-control" value="{{ $taxRate }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" name="currency" class="form-control" value="{{ $currency }}" required>
                    </div>

                    <button type="submit" class="btn-submit" style="background:#e65f2b; margin-top:0.5rem;">Save Configuration settings</button>
                </form>
            </div>
        </div>

        <!-- ================= 9. TAB: USERS ================= -->
        <div id="tab-users" class="view-tab-content">
            <div class="page-header">
                <div>
                    <h1>Users Directory</h1>
                    <p>Secure system accounts provisioning, customer profiles, and staff role authorization.</p>
                </div>
                <div>
                    @if(auth()->user()->isSuperAdmin())
                        <button onclick="openAdminModal('modal-create-account')" class="btn-submit" style="background:#0f172a;">+ Create Account</button>
                    @endif
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card-title">Registered Accounts Directory</div>
                <div class="data-table-wrapper">
                    <table class="console-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Details</th>
                                <th>Dietary Profile</th>
                                <th>Role</th>
                                <th style="text-align:right;">Role Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $userObj)
                                <tr>
                                    <td><strong>{{ $userObj->name }}</strong></td>
                                    <td>{{ $userObj->email }}</td>
                                    <td>{{ $userObj->phone ?? 'N/A' }}</td>
                                    <td>
                                        @if($userObj->dietary_preferences)
                                            @foreach(explode(',', $userObj->dietary_preferences) as $pref)
                                                <span class="badge" style="background:#e0e7ff; color:#3b82f6; margin-right:0.2rem;">{{ trim($pref) }}</span>
                                            @endforeach
                                        @else
                                            <span style="color:#94a3b8; font-style:italic;">None</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge" style="background:#f1f5f9; color: {{ $userObj->role === 'super_admin' ? '#ef4444' : ($userObj->role === 'admin' ? '#e65f2b' : '#64748b') }};">
                                            {{ ucfirst(str_replace('_', ' ', $userObj->role)) }}
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <form action="{{ route('admin.users.role', $userObj->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="form-control" style="width:130px; font-size:0.75rem; padding:0.2rem; display:inline-block;" onchange="this.form.submit()">
                                                <option value="customer" {{ $userObj->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                                <option value="admin" {{ $userObj->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="super_admin" {{ $userObj->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ================= MODALS ================= -->
@if(auth()->user()->isSuperAdmin())
    <!-- MODAL: ADD RESTAURANT -->
    <div id="modal-add-restaurant" class="caterflow-modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(15, 23, 42, 0.4); backdrop-filter:blur(3px); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:white; border-radius:12px; max-width:500px; width:100%; padding:1.75rem; border:1px solid #cbd5e1; box-shadow:0 10px 15px rgba(0,0,0,0.1);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; border-bottom:1px solid #f1f5f9; padding-bottom:0.5rem;">
                <h3 style="font-weight:800; font-size:1.15rem; color:#0f172a;">Add Catering Restaurant</h3>
                <button onclick="closeAdminModal('modal-add-restaurant')" style="background:none; border:none; font-size:1.5rem; color:#94a3b8; cursor:pointer;">&times;</button>
            </div>
            <form action="{{ route('admin.restaurants.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Restaurant Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Royal Feast" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Contact Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="e.g. +44 20 7946 0192" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Catering details..." required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Location Address</label>
                    <input type="text" name="address" class="form-control" placeholder="e.g. 101 Palace Row, London" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Icon Emoji (Optional)</label>
                    <input type="text" name="icon" class="form-control" placeholder="e.g. 👑, 🍝, 🌶️" maxlength="2">
                </div>
                <button type="submit" class="btn-submit" style="width:100%; background:#e65f2b; margin-top:0.5rem;">Save Restaurant</button>
            </form>
        </div>
    </div>

    <!-- MODAL: CREATE ACCOUNT -->
    <div id="modal-create-account" class="caterflow-modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(15, 23, 42, 0.4); backdrop-filter:blur(3px); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:white; border-radius:12px; max-width:500px; width:100%; padding:1.75rem; border:1px solid #cbd5e1; box-shadow:0 10px 15px rgba(0,0,0,0.1);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; border-bottom:1px solid #f1f5f9; padding-bottom:0.5rem;">
                <h3 style="font-weight:800; font-size:1.15rem; color:#0f172a;">Create System Account</h3>
                <button onclick="closeAdminModal('modal-create-account')" style="background:none; border:none; font-size:1.5rem; color:#94a3b8; cursor:pointer;">&times;</button>
            </div>
            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Jane Doe" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="jane@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">System Role</label>
                    <select name="role" class="form-control">
                        <option value="customer">Customer</option>
                        <option value="admin">Admin (Restaurant Owner)</option>
                        <option value="super_admin">Super Admin (System Operator)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                </div>
                <button type="submit" class="btn-submit" style="width:100%; margin-top:0.5rem;">Generate Account</button>
            </form>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
    function switchSidebarTab(tabId, element) {
        // Toggle Sidebar Link Active Class
        const links = document.querySelectorAll(".sidebar-link");
        links.forEach(l => l.classList.remove("active"));
        element.classList.add("active");

        // Toggle Content Tab Active Class
        const contents = document.querySelectorAll(".view-tab-content");
        contents.forEach(c => c.classList.remove("active"));
        document.getElementById("tab-" + tabId).classList.add("active");
    }

    function toggleAddItemForm() {
        const form = document.getElementById("add-item-form-container");
        if (form.style.display === "none") {
            form.style.display = "block";
            form.scrollIntoView({ behavior: 'smooth' });
        } else {
            form.style.display = "none";
        }
    }

    // Modal Control
    function openAdminModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeAdminModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Deep Link to Tab from URL Hash
    window.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash.replace('#', '');
        if (hash) {
            const tabBtn = Array.from(document.querySelectorAll(".sidebar-link")).find(l => l.onclick.toString().includes(hash));
            if (tabBtn) tabBtn.click();
        }
    });
</script>
@endsection
