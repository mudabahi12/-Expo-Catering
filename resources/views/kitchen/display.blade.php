@extends('layouts.app')

@section('title', 'Kitchen Display System - FeastFlow')

@section('styles')
<style>
    .kds-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .kds-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.25rem;
        font-weight: 700;
        background: linear-gradient(to right, #fff, #60a5fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .kds-header p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    /* Active Orders Grid */
    .kds-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .kds-card {
        border-radius: 16px;
        background: rgba(31, 41, 55, 0.45);
        border: 1px solid var(--border-glass);
        box-shadow: var(--shadow-premium);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: cardFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        transition: var(--transition);
    }

    .kds-card:hover {
        transform: scale(1.01);
        border-color: rgba(255,255,255,0.15);
    }

    /* Status-colored Card Headers */
    .kds-card-header {
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-glass);
    }

    .kds-header-pending {
        background: rgba(245, 158, 11, 0.15);
        border-left: 4px solid #fbbf24;
    }

    .kds-header-preparing {
        background: rgba(59, 130, 246, 0.15);
        border-left: 4px solid #60a5fa;
    }

    .kds-header-ready {
        background: rgba(16, 185, 129, 0.15);
        border-left: 4px solid #34d399;
    }

    .kds-order-no {
        font-size: 1.2rem;
        font-weight: 800;
    }

    .kds-elapsed {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    /* Card Body */
    .kds-card-body {
        padding: 1.25rem;
        flex: 1;
    }

    .kds-cust-meta {
        font-size: 0.9rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 0.5rem;
    }

    .kds-cust-meta strong {
        color: #fff;
    }

    .kds-items-list {
        list-style: none;
        margin-bottom: 1.25rem;
    }

    .kds-item-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 1.05rem;
    }

    .kds-item-qty {
        font-weight: 800;
        color: var(--accent);
        margin-right: 0.5rem;
    }

    .kds-item-name {
        font-weight: 600;
        color: var(--text-main);
    }

    .kds-item-note {
        font-size: 0.8rem;
        color: #fca5a5;
        font-style: italic;
        margin-left: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .kds-order-notes {
        background: rgba(255, 255, 255, 0.03);
        border: 1px dashed var(--border-glass);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #f59e0b;
        margin-top: 0.75rem;
    }

    /* Card Footer Action Buttons */
    .kds-card-footer {
        padding: 1rem 1.25rem;
        border-top: 1px solid var(--border-glass);
        display: flex;
        gap: 0.5rem;
        background: rgba(0,0,0,0.15);
    }

    @keyframes cardFadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="kds-header">
    <div>
        <h1>Kitchen Display System</h1>
        <p>Live order monitor screen for chefs and caterers. Orders sync automatically.</p>
    </div>
    <div style="font-size: 0.85rem; background: rgba(255,255,255,0.05); padding: 0.4rem 0.8rem; border-radius: 12px; border: 1px solid var(--border-glass);">
        🔴 Live Syncing: <strong id="sync-indicator" style="color: #10b981;">Active</strong>
    </div>
</div>

<!-- Grid of Active Order Cards -->
<div class="kds-grid" id="kds-orders-container">
    @forelse($orders as $order)
        <div class="kds-card" id="order-card-{{ $order->id }}">
            <div class="kds-card-header kds-header-{{ $order->status }}">
                <span class="kds-order-no">Order #{{ $order->id }}</span>
                <span class="kds-elapsed">{{ $order->created_at->diffForHumans(null, true) }} ago</span>
            </div>
            
            <div class="kds-card-body">
                <div class="kds-cust-meta">
                    <div>Guest: <strong>{{ $order->customer_name }}</strong></div>
                    <div>Location: <strong>{{ $order->table_number_or_delivery }}</strong></div>
                </div>

                <ul class="kds-items-list">
                    @foreach($order->items as $item)
                        <li>
                            <div class="kds-item-row">
                                <span><span class="kds-item-qty">{{ $item->quantity }}x</span><span class="kds-item-name">{{ $item->menuItem->name ?? 'Deleted Item' }}</span></span>
                            </div>
                            @if($item->notes)
                                <div class="kds-item-note">↳ "{{ $item->notes }}"</div>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @if($order->notes)
                    <div class="kds-order-notes">
                        <strong>Chef Notes:</strong> "{{ $order->notes }}"
                    </div>
                @endif
            </div>

            <div class="kds-card-footer">
                @if($order->status === 'pending')
                    <button onclick="updateStatus({{ $order->id }}, 'preparing')" class="btn btn-primary btn-sm" style="flex: 1; background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: none;">Start Preparing</button>
                @elseif($order->status === 'preparing')
                    <button onclick="updateStatus({{ $order->id }}, 'ready')" class="btn btn-primary btn-sm" style="flex: 1; background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: none;">Mark Ready</button>
                @elseif($order->status === 'ready')
                    <button onclick="updateStatus({{ $order->id }}, 'completed')" class="btn btn-primary btn-sm" style="flex: 1; background: linear-gradient(135deg, #10b981, #059669); box-shadow: none;">Complete</button>
                @endif
                <button onclick="updateStatus({{ $order->id }}, 'cancelled')" class="btn btn-secondary btn-sm btn-danger" style="padding: 0.4rem 0.6rem;">✕</button>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 4rem 0;" id="kds-empty-msg">
            <p style="font-size: 2.5rem; margin-bottom: 0.5rem;">🍳</p>
            <h3>Kitchen is clear.</h3>
            <p style="font-size: 0.9rem; margin-top: 0.25rem;">Waiting for incoming kiosk orders...</p>
        </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
    // AJAX status updates
    function updateStatus(orderId, nextStatus) {
        const payload = {
            status: nextStatus,
            _token: '{{ csrf_token() }}'
        };

        fetch(`/kitchen/orders/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Instantly remove card or redraw
                const card = document.getElementById(`order-card-${orderId}`);
                if (card) {
                    if (nextStatus === 'completed' || nextStatus === 'cancelled') {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => card.remove(), 300);
                    } else {
                        // Let poll redraw or redraw ourselves
                        pollKitchenData();
                    }
                }
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error communicating with kitchen server.');
        });
    }

    // Live sync polling
    function pollKitchenData() {
        const indicator = document.getElementById('sync-indicator');
        indicator.textContent = 'Syncing...';
        indicator.style.color = '#3b82f6';

        fetch('/kitchen/active-orders-data')
        .then(response => response.json())
        .then(orders => {
            indicator.textContent = 'Active';
            indicator.style.color = '#10b981';

            const container = document.getElementById('kds-orders-container');
            
            if (orders.length === 0) {
                container.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 4rem 0;" id="kds-empty-msg">
                        <p style="font-size: 2.5rem; margin-bottom: 0.5rem;">🍳</p>
                        <h3>Kitchen is clear.</h3>
                        <p style="font-size: 0.9rem; margin-top: 0.25rem;">Waiting for incoming kiosk orders...</p>
                    </div>
                `;
                return;
            }

            // Map and build HTML
            let html = '';
            orders.forEach(order => {
                let itemsHtml = '';
                order.items.forEach(item => {
                    itemsHtml += `
                        <li>
                            <div class="kds-item-row">
                                <span><span class="kds-item-qty">${item.quantity}x</span><span class="kds-item-name">${item.name}</span></span>
                            </div>
                            ${item.notes ? `<div class="kds-item-note">↳ "${item.notes}"</div>` : ''}
                        </li>
                    `;
                });

                let buttonHtml = '';
                if (order.status === 'pending') {
                    buttonHtml = `<button onclick="updateStatus(${order.id}, 'preparing')" class="btn btn-primary btn-sm" style="flex: 1; background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: none;">Start Preparing</button>`;
                } else if (order.status === 'preparing') {
                    buttonHtml = `<button onclick="updateStatus(${order.id}, 'ready')" class="btn btn-primary btn-sm" style="flex: 1; background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: none;">Mark Ready</button>`;
                } else if (order.status === 'ready') {
                    buttonHtml = `<button onclick="updateStatus(${order.id}, 'completed')" class="btn btn-primary btn-sm" style="flex: 1; background: linear-gradient(135deg, #10b981, #059669); box-shadow: none;">Complete</button>`;
                }

                html += `
                    <div class="kds-card" id="order-card-${order.id}">
                        <div class="kds-card-header kds-header-${order.status}">
                            <span class="kds-order-no">Order #${order.id}</span>
                            <span class="kds-elapsed">${order.elapsed_time}</span>
                        </div>
                        
                        <div class="kds-card-body">
                            <div class="kds-cust-meta">
                                <div>Guest: <strong>${order.customer_name}</strong></div>
                                <div>Location: <strong>${order.table_number_or_delivery}</strong></div>
                            </div>

                            <ul class="kds-items-list">
                                ${itemsHtml}
                            </ul>

                            ${order.notes ? `
                                <div class="kds-order-notes">
                                    <strong>Chef Notes:</strong> "${order.notes}"
                                </div>
                            ` : ''}
                        </div>

                        <div class="kds-card-footer">
                            ${buttonHtml}
                            <button onclick="updateStatus(${order.id}, 'cancelled')" class="btn btn-secondary btn-sm btn-danger" style="padding: 0.4rem 0.6rem;">✕</button>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        })
        .catch(err => {
            console.error('Error polling kitchen data:', err);
            indicator.textContent = 'Offline';
            indicator.style.color = '#ef4444';
        });
    }

    // Auto-poll kitchen data every 4 seconds
    setInterval(pollKitchenData, 4000);
</script>
@endsection
