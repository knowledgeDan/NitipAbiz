# NitipAbiz - Project Setup Documentation

## Project Overview

NitipAbiz adalah platform pemesanan dan pengiriman makanan berbasis web yang dirancang khusus untuk lingkungan sekolah. Platform ini menghubungkan Customer, Canteen Sellers, dan Couriers dalam ekosistem lokal sekolah.

## Tech Stack

- **Framework**: Laravel 12.x
- **PHP**: 8.2.12
- **Database**: MariaDB 10.4.32 (MySQL-compatible)
- **Frontend**: Blade Templates + Vite
- **Node.js**: v22.20.0

## Database Schema

### Tables Created

1. **schools** - Data sekolah
2. **student_registry** - Registry siswa yang terdaftar (NIS validation)
3. **users** - Data pengguna dengan roles dan verification status
4. **canteens** - Data kantin yang terdaftar
5. **menus** - Menu makanan dari setiap kantin
6. **orders** - Data pesanan
7. **order_items** - Detail item pesanan
8. **deliveries** - Data pengiriman
9. **order_history** - History perubahan status pesanan
10. **disputes** - Laporan dispute/sengketa transaksi

## User Roles

1. **Customer** - Pengguna yang memesan makanan
2. **Seller** - Pemilik/pengelola kantin
3. **Courier** - Kurir yang mengantar pesanan
4. **System Manager** - Administrator platform

## Order Status Flow

```
PENDING → ACCEPTED → PREPARING → READY_FOR_PICKUP → DELIVERING → DELIVERED → COMPLETED
                                                                              ↓
                                                                          CANCELLED
```

## Key Features (MVP Scope)

### Authentication & Authorization
- Registration dengan NIS validation
- Login/Logout
- Role-based access control (RBAC)
- User verification system
- Courier verification system

### Customer Features
- Browse canteens by school
- Browse menus
- Shopping cart
- Order placement (cash payment)
- Order tracking
- Order history

### Seller Features
- Canteen registration
- Menu CRUD operations
- Order management
- Stock management

### Courier Features
- Courier registration with verification
- Availability toggle
- View available orders
- Accept delivery orders
- Delivery status updates
- Earnings tracking (Rp2,000 per delivery)

### System Manager Features
- School CRUD
- User management
- Student registry management
- Canteen verification
- Courier verification
- Order monitoring
- Dispute management

## Security Features

### Identity Verification
- School ID + NIS binding
- Face photo upload
- Student ID photo upload (for couriers)
- Ban evasion prevention

### Transaction Integrity
- Order history logging (WHO, WHAT, WHEN, STATUS)
- Mutual confirmation (Customer + Courier)
- Dispute reporting system
- Cash payment tracking

## Payment System

- **Payment Method**: Cash only (MVP)
- **Delivery Fee**: Rp2,000 (fixed per order)
- **Courier Earnings**: Rp2,000 per completed delivery

## Design System

### Color Palette
- **Primary Color**: Blue (trust, reliability, technology)
- **Secondary Color**: Orange (food, energy, action)
- **Neutral Colors**: White, light grey, dark grey

### UI/UX Principles
1. Minimalism - show only relevant information
2. Clarity - immediate understanding
3. Consistency - predictable behavior
4. Efficiency - minimal interaction
5. Visual Hierarchy - prioritize important info
6. Locality - school context always clear
7. Feedback - clear action confirmations

### Navigation
- **Sidebar**: Collapsible left sidebar (default collapsed)
- **Interaction**: Hover to expand with smooth animation
- **Active Indicator**: Animated decision-line (125% width, smooth transitions)

## Installation Steps

### 1. Clone & Install Dependencies

```bash
cd E:\Projects\NitipAbiz\nitipabiz-app
composer install
npm install
```

### 2. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup

```bash
# Database already exists and is connected
# Default configuration uses MariaDB 10.4.32

# Run migrations to create all tables
php artisan migrate

# To reset database and run migrations fresh
php artisan migrate:fresh
```

**Database Tables Created:**
- schools
- users (with NitipAbiz fields)
- student_registry
- canteens
- menus
- orders
- order_items
- deliveries
- order_history
- disputes

**Database Connection:**
- Driver: mariadb
- Host: 127.0.0.1
- Port: 3306
- Database: nitipabiz
- Username: root
- Password: (empty)

### 4. Run Development Server

```bash
# Terminal 1 - Laravel Server
php artisan serve

# Terminal 2 - Vite Dev Server
npm run dev
```

## Development Timeline (24 Weeks)

### Phase 1: Foundation & Setup (Week 1-2) ✅
- [x] Project setup
- [x] Database schema design
- [x] Migration files
- [x] Model creation
- [x] MariaDB database connection
- [x] All tables created and verified
- [ ] Authentication system
- [ ] RBAC implementation

### Phase 2: Core UI Framework (Week 3-4)
- [ ] Design system implementation
- [ ] Sidebar navigation
- [ ] Responsive layout
- [ ] Role-based navigation pages

### Phase 3: System Manager Features (Week 5-6)
- [ ] School & User management
- [ ] Student registry management
- [ ] Verification interfaces
- [ ] Monitoring dashboard

### Phase 4: Seller Features (Week 7-8)
- [ ] Canteen management
- [ ] Menu CRUD
- [ ] Stock management

### Phase 5: Customer Features (Week 9-11)
- [ ] Browsing & cart
- [ ] Checkout & order creation
- [ ] Order tracking & history

### Phase 6: Order Processing (Week 12-13)
- [ ] Seller order management
- [ ] Order status workflow
- [ ] Cancellation rules

### Phase 7: Courier Features (Week 14-16)
- [ ] Courier registration
- [ ] Delivery assignment
- [ ] Delivery completion
- [ ] Earnings tracking

### Phase 8: Security & Verification (Week 17-18)
- [ ] Identity verification
- [ ] Transaction security
- [ ] Dispute system

### Phase 9: Testing & Refinement (Week 19-21)
- [ ] Unit & integration testing
- [ ] User acceptance testing
- [ ] Bug fixes & polish

### Phase 10: Deployment & Launch (Week 22-24)
- [ ] Production setup
- [ ] Soft launch
- [ ] Documentation & training

## Next Steps

1. **Implement Authentication System**
   - Laravel Breeze or custom auth
   - Add NIS validation
   - Role-based middleware

2. **Create Seeders**
   - Schools seeder
   - Student registry seeder
   - Test users seeder

3. **Build Controllers**
   - AuthController
   - SchoolController
   - CanteenController
   - MenuController
   - OrderController
   - DeliveryController

4. **Design Frontend**
   - Install Tailwind CSS
   - Create base layout
   - Implement sidebar navigation
   - Build component library

## Business Rules

1. User must have verified account
2. Default landing page: **Pesanan** page
3. Empty state message: "Belum pesan. Nitip yuk!"
4. One order = one canteen only
5. Fixed delivery fee: Rp2,000
6. Courier earnings: Rp2,000 per completed delivery
7. Payment method: Cash only
8. School-based locality (couriers only see their school's orders)
9. Order cancellation only allowed before "PREPARING" status
10. Mutual confirmation required for order completion

## Contact & Support

- **Project Name**: NitipAbiz
- **Version**: 1.0.0 (MVP)
- **Status**: Development Phase 1
- **Started**: July 27, 2026

---

**Note**: Refer to `PRD_NitipAbiz.md` for complete product requirements and specifications.
