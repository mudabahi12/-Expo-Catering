# Expo Catering - Unified Operations Console & Kiosk

Expo Catering is a high-throughput, centralized catering ERP and ordering matrix built in Laravel & PHP. It streamlines catering logistics, daily kitchen production sheet aggregations, CRM client records (pharma reps/corporate accounts), and customer ordering through an AI-assisted checkout terminal.

---

## 🚀 Key Modules & Features

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

## 💻 Local Installation & Setup

Follow these steps to run the application on your local machine:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/mudabahi12/-Expo-Catering.git
   cd -Expo-Catering
   ```

2. **Install Composer Dependencies**:
   ```bash
   composer install
   ```

3. **Configure Environment Variables**:
   Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
   For SQLite, ensure database configuration is:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

4. **Initialize Database**:
   Create a blank SQLite database file and run the migrations and seeds:
   ```bash
   # On Windows PowerShell:
   New-Item -ItemType File -Path database/database.sqlite -Force
   
   # Run migrations and seed test data:
   php artisan migrate:fresh --seed
   ```

5. **Start Development Server**:
   ```bash
   php artisan serve
   ```
   Access the local site at: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🌐 Hostinger Shared Hosting Deployment

To host this project on your Hostinger Shared Hosting (hPanel) account:

1. **Upload Code**:
   - Create a folder called `catering-system` in the root of your hosting account (outside of the `public_html` directory).
   - Upload the project files here.

2. **Move Public Assets**:
   - Move all files from `/catering-system/public` (including `.htaccess` and `index.php`) directly into your `/public_html` folder.

3. **Adjust Bootstrap Paths**:
   - Open `/public_html/index.php` and update the bootstrap paths:
     ```php
     require __DIR__.'/../catering-system/vendor/autoload.php';
     $app = require_once __DIR__.'/../catering-system/bootstrap/app.php';
     ```

4. **Configure MySQL Database**:
   - Go to hPanel -> **Databases** -> **MySQL Databases** and create a new database.
   - Edit `/catering-system/.env` and insert your database username, password, and database name.
   - Set `APP_ENV=production` and `APP_DEBUG=false` for security.

5. **Run Migrations**:
   - Add a temporary web route in `/catering-system/routes/web.php` to run `Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true])` or enable SSH in hPanel and run:
     ```bash
     php artisan migrate:fresh --seed --force
     ```

---

## 👥 Seeded Test Accounts

- **Super Admin (Operations Console)**: `super@caterflow.com` (password: `password`)
- **Admin (Restaurant Partner)**: `admin@caterflow.com` (password: `password`)
- **Customer**: `jane@caterflow.com` (password: `password`)
