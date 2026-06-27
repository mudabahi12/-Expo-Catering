# Expo Catering

Expo Catering is a high-throughput, centralized catering ERP and ordering matrix built in Laravel & PHP. It streamlines catering logistics, daily kitchen production sheet aggregations, CRM client records (pharma reps/corporate accounts), and customer ordering through an AI-assisted checkout terminal.

---

## Key Modules & Features

### 1. Landing Page (`/`)
- Sleek cream-orange radial glow layout with a custom background grid.
- Dynamic statistics display:
  - **Orders**: `∞`
  - **Paper Tickets**: `0`
  - **System**: `1`
- Detailed features matrix outlining operations (Smart Orders, Print Tickets, Pharma Reps, AR & Reports).
- Clear pathways for customer kiosks and staff dashboard login.

### 2. Customer Kiosk & AI Assistant (`/restaurant`)
- **AI Ordering Assistant Chatbot**: Client-side conversational NLP parser. Customers can type commands like *"add 2 truffle bruschetta and a steak"*, *"suggest a vegetarian appetizer"*, or *"clear cart"* to dynamically modify their cart and receive interactive recommendations.
- **Dynamic Cart**: Instant updates, special instruction notes per line item, and quantity controls.
- **Aligned Checkout Form**: Collects customer name, delivery location (table or address), and phone/email contacts.
- **Payment Method Selectors**: Support for Credit Card, Invoice, and Cash payments. Selecting Credit Card reveals fully formatted Card Number, Expiry, and CVC inputs.
- **Live tracker**: Real-time preparation list tracking the order dispatch lifecycle (polled automatically via AJAX every 4 seconds).
- **Invoice Archive**: History of past invoice orders for authenticated clients.

### 3. Super Admin & Owner Console (`/admin/dashboard`)
- Full-height sidebar console (`260px` dark navy panel `#0f172a` with an orange-brand logo).
- Immersive view with the standard top navigation bar removed.
- **Interactive Tabs**:
  1. **Dashboard**: Metrics widgets (Total Catering Sales, registered partners, system accounts, active pending orders) and registered catering partner cards.
  2. **Orders Matrix**: Dispatch dashboard featuring customer details, order items, special instruction notes, delivery locations, pricing, and live status selectors.
  3. **Production Sheet**: Automatically aggregates and consolidates all quantities of menu items needed to fulfill today's active kitchen prep orders.
  4. **Companies (CRM)**: Corporate account directory with industry classifications, phone hotlines, and quick add forms.
  5. **Contacts (CRM)**: Client representatives directory, email links, and quick add forms.
  6. **Delivery Addresses (CRM)**: Shipping locations and drop-off instructions directory with quick add forms.
  7. **Menu Items**: Catalog listing, categories creation, and menu stock availability toggles.
  8. **Configuration**: Global settings form to adjust business name, currency symbols, and default tax rates.
  9. **Users Directory**: Secure account list with privilege delegation actions (Customer, Admin, Super Admin).

---

## 🛠 Tech Stack

- **Framework**: Laravel 9
- **Core Language**: PHP (Blade Templating)
- **Styling**: Pure CSS (Cream-orange theme highlights, radial blur effects, grid-pattern background)
- **Database**: SQLite (default for local development) / MySQL (ready for production)
- **Asynchronous Logic**: Vanilla JavaScript (Fetch API polling, client-side NLP parser)

---



## 👥 Seeded Test Accounts

- **Super Admin (Operations Console)**: `super@caterflow.com` (password: `password`)
- **Admin (Restaurant Partner)**: `admin@caterflow.com` (password: `password`)
- **Customer**: `jane@caterflow.com` (password: `password`)
