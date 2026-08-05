Below is a consolidated PRD based on the **NitipAbiz** concept we established, including the UKK-oriented CRUD and user-management requirements, the minimalist visual direction, the school-localised delivery model, and the specific navigation and interaction behaviour you described.

# Product Requirements Document (PRD)

# NitipAbiz

**Product Type:** Localised School Food Ordering & Delivery Web Application
**Platform:** Web
**Design Style:** Minimalist, modern, clean
**Primary Colour:** Blue
**Secondary Colour:** Orange
**Payment Method:** Cash only
**Target Environment:** Schools and their local communities
**Document Version:** 1.0

---

# 1. Product Overview

**NitipAbiz** is a minimalist web-based food ordering and delivery platform designed specifically for school environments.

The platform functions similarly to a localised school version of a food delivery service, connecting:

- **Customers** who want to order food.
- **Canteen Sellers** who provide food and manage their menus.
- **Couriers/Deliverers** who deliver orders within the school environment.
- **System Managers** who manage users, schools, canteens, and platform data.

Unlike conventional ride-hailing or food delivery platforms, NitipAbiz is restricted to a local school environment. The service is designed around short-distance delivery between canteens and members of the same school community.

The platform does not use digital payments. All transactions are conducted using **cash**.

The proposed delivery fee is a fixed **Rp2,000 per completed delivery order**. The low fixed fee reflects the localised nature of the service, where delivery distances are short and student couriers generally do not require fuel expenses.

NitipAbiz is intended to help students obtain food more conveniently during school breaks while providing students with the opportunity to earn additional income by becoming couriers during their available free time.

---

# 2. Problem Statement

Students often have limited break time and may need to spend a significant portion of that time queueing at the canteen.

Common problems include:

1. Long queues at school canteens.
2. Limited break periods.
3. Students having to leave their classrooms to purchase food.
4. Difficulty knowing which canteens and menus are available.
5. Lack of an integrated system for ordering food within a school.
6. Students who are willing to deliver food having no structured way to receive delivery requests.
7. Canteen sellers having no centralised digital system to manage menus and incoming orders.

NitipAbiz aims to address these problems by providing a centralised platform for food ordering and local delivery within the school environment.

---

# 3. Product Goals

## 3.1 Primary Goal

To provide a simple and efficient web platform that connects school community members with registered canteens and local student couriers.

## 3.2 Secondary Goals

- Reduce physical queues at school canteens.
- Help users order food without leaving their current location.
- Help canteen sellers manage menus and orders digitally.
- Provide students with opportunities to become local couriers.
- Create a structured system for managing school-based food delivery.
- Demonstrate complete CRUD and user-management functionality.
- Provide a clean and intuitive user interface that is easy to operate.

---

# 4. Target Users

NitipAbiz has four primary user roles.

## 4.1 Customer

A customer is a member of the school community who orders food.

Examples:

- Students
- Teachers
- School staff

Customers can:

- Select their school.
- Browse registered canteens.
- Browse menus.
- Add food to a cart.
- Place orders.
- View ongoing orders.
- Track order status.
- View order history.

---

## 4.2 Canteen Seller

A seller is an individual or business responsible for a registered school canteen.

Sellers can:

- Register a canteen.
- Select the school where the canteen operates.
- Manage canteen information.
- Add menus.
- Edit menus.
- Delete menus.
- Manage prices.
- Manage stock or availability.
- View incoming orders.
- Process orders.

---

## 4.3 Courier

A courier is a member of the school community who voluntarily delivers food orders.

Couriers can:

- Register as a courier.
- Select their school.
- Set their availability status.
- View available delivery orders.
- Accept delivery orders.
- Deliver orders.
- Complete deliveries.
- View delivery history.
- View accumulated delivery earnings.

Couriers are intended to operate primarily during free periods, particularly school break periods.

The system does not treat couriers as professional full-time drivers. NitipAbiz is designed around short-distance deliveries within the school environment.

---

## 4.4 System Manager

The System Manager is responsible for managing the overall NitipAbiz platform.

System Managers can:

- Manage schools.
- Manage users.
- Manage canteens.
- Verify canteens.
- Verify couriers.
- Remove inappropriate data.
- Manage user roles.
- Monitor transactions.
- View platform activity.

---

# 5. Core Product Concept

The main structure of NitipAbiz is:

```text
School
   ↓
Registered Canteens
   ↓
Menus
   ↓
Customer Orders
   ↓
Courier Delivery
```

For example:

```text
SMK Negeri X
│
├── Kantin Bu Sari
│   ├── Nasi Goreng
│   ├── Mie Goreng
│   └── Es Teh
│
└── Kantin Pak Budi
    ├── Bakso
    ├── Soto
    └── Es Jeruk
```

Users interact primarily with the school environment they belong to.

The school acts as the primary locality boundary for:

- Customers.
- Canteens.
- Couriers.
- Food orders.

A courier should only receive delivery opportunities that are relevant to their registered school environment.

---

# 6. Main User Journey

The main customer flow is:

```text
Create Account
   ↓
Login
   ↓
Pesanan Page
   ↓
Select School / Browse School Context
   ↓
Browse Canteen
   ↓
Browse Menu
   ↓
Add Food to Cart
   ↓
Checkout
   ↓
Confirm Cash Payment
   ↓
Order Created
   ↓
Canteen Accepts Order
   ↓
Canteen Prepares Food
   ↓
Food Ready for Pickup
   ↓
Courier Accepts Delivery
   ↓
Courier Delivers Food
   ↓
Customer Receives Food
   ↓
Order Completed
```

---

# 7. First Login and Default Page

After successfully creating an account and logging in, the user should immediately be directed to the **"Pesanan"** page.

The **Pesanan** page is the default landing page after authentication.

The page primarily displays the user's ongoing orders.

## 7.1 When an Ongoing Order Exists

The page displays the user's active order card.

Example:

```text
Pesanan #1024

Kantin Bu Sari

Nasi Goreng × 1
Es Teh × 1

Total: Rp15.000

Status:
Sedang Diantar
```

The order card should provide relevant information such as:

- Order number.
- Canteen name.
- Ordered items.
- Total cost.
- Delivery fee.
- Current order status.
- Courier information, if applicable.
- Order creation time.

---

## 7.2 When No Ongoing Order Exists

If the user has no ongoing order, the Pesanan page should display a minimalist empty-state placeholder.

The background or central empty-state area should contain the text:

> **"Belum pesan. Nitip yuk!"**

The empty state should encourage the user to begin browsing and ordering without overwhelming them with additional information.

A primary action such as:

> **Pesan Sekarang**

may be displayed below the message.

---

# 8. Order Status System

The order status flow is:

```text
PENDING
   ↓
ACCEPTED
   ↓
PREPARING
   ↓
READY_FOR_PICKUP
   ↓
DELIVERING
   ↓
COMPLETED
```

Orders may also be cancelled when permitted:

```text
PENDING
   ↓
CANCELLED
```

## 8.1 PENDING

The customer has successfully created an order.

The order is waiting for the canteen to process it.

---

## 8.2 ACCEPTED

The canteen has accepted the order.

---

## 8.3 PREPARING

The canteen is preparing the customer's food.

---

## 8.4 READY_FOR_PICKUP

The food has been prepared and is ready to be collected by a courier.

---

## 8.5 DELIVERING

The courier has collected the food and is delivering it to the customer.

The system does not require a separate `PICKED_UP` state for the MVP.

The courier action of collecting the food transitions the order directly from:

```text
READY_FOR_PICKUP
        ↓
DELIVERING
```

---

## 8.6 COMPLETED

The customer has received the order and the delivery process is complete.

The courier receives the fixed delivery earnings associated with the completed order.

---

## 8.7 CANCELLED

The order has been cancelled according to the applicable cancellation rules.

---

# 9. Payment System

NitipAbiz does not support digital payments in its initial version.

All payments are conducted using:

> **Cash**

The customer pays the required amount directly according to the order arrangement.

The total order cost is calculated as:

```text
Food Subtotal
+
Fixed Delivery Fee
=
Total Order Cost
```

Example:

```text
Nasi Goreng          Rp10.000
Es Teh                Rp3.000
--------------------------------
Food Subtotal        Rp13.000
Delivery Fee          Rp2.000
--------------------------------
Total                Rp15.000
```

The fixed delivery fee is:

> **Rp2.000 per completed delivery order**

The delivery fee is recorded as courier earnings.

The system does not require:

- Digital wallets.
- Bank transfers.
- Payment gateways.
- Credit/debit card processing.
- QR payment integration.

Digital payment functionality may be considered a future enhancement but is outside the MVP scope.

---

# 10. Navigation and Layout

NitipAbiz uses a **minimalist navigation system** designed to maximise available content space.

The primary navigation is located on the **left side of the screen**.

The sidebar is collapsed by default.

In its default state, the sidebar displays only simple icons or logos.

When the user hovers over the sidebar, it expands smoothly and reveals the corresponding text labels.

Example:

```text
Collapsed:

[Logo]
[Icon]
[Icon]
[Icon]
[Icon]
[Icon]

Expanded:

[Logo]  NitipAbiz
[Icon]  Pesanan
[Icon]  Kantin
[Icon]  Menu
[Icon]  Pengantaran
[Icon]  Riwayat
```

The expanded navigation should provide enough width for clear labels without occupying excessive screen space.

---

# 11. Navigation Items

The exact navigation items depend on the user's role.

## 11.1 Customer Navigation

```text
Pesanan
Kantin
Keranjang
Riwayat
Profil
```

Potential icons:

- Pesanan — clipboard/order icon.
- Kantin — storefront icon.
- Keranjang — shopping cart icon.
- Riwayat — history icon.
- Profil — user icon.

---

## 11.2 Seller Navigation

```text
Pesanan
Kantin Saya
Menu
Riwayat
Profil
```

---

## 11.3 Courier Navigation

```text
Pesanan
Order Tersedia
Pengantaran
Riwayat
Pendapatan
Profil
```

---

## 11.4 System Manager Navigation

```text
Dashboard
Sekolah
Pengguna
Kantin
Pesanan
Pengantaran
Laporan
Pengaturan
```

---

# 12. Navigation Interaction Design

The navigation should use a minimalist animated interaction.

When a navigation item is selected or hovered, a **smooth decision-line indicator** appears underneath the navigation item.

The indicator has the following behaviour:

1. The line has a small default width.
2. When positioned under the active or hovered navigation item, the line expands to approximately **125% of the navigation item's width**.
3. When moving between two navigation items, the line smoothly travels toward the destination.
4. While travelling between items, the line temporarily shortens.
5. When reaching the destination, the line expands again to approximately 125% of the destination item's width.
6. The animation should be smooth and subtle rather than distracting.

Conceptually:

```text
Default:

   Pesanan       Kantin       Riwayat
      ─             ─            ─

Hover/Active:

   Pesanan       Kantin       Riwayat
   ───────────      ─             ─

Moving:

   Pesanan       Kantin       Riwayat
      ───────────→ ─             ─

Destination:

   Pesanan       Kantin       Riwayat
      ─             ───────────    ─
```

The animation should use smooth transitions and avoid sudden jumps.

The active navigation item should remain visually distinguishable after the cursor leaves the sidebar.

---

# 13. Visual Design System

NitipAbiz uses a **minimalist visual language**.

Design principles:

- Clean.
- Simple.
- Spacious.
- Modern.
- Functional.
- Low visual clutter.
- Clear hierarchy.
- Strong focus on the current task.

The interface should avoid excessive gradients, excessive shadows, unnecessary decorative elements, and overly complex animations.

---

# 14. Colour Palette

## 14.1 Primary Colour — Blue

Blue is the dominant colour of NitipAbiz.

Blue represents:

- Trust.
- Reliability.
- Technology.
- Stability.
- Cleanliness.

Blue should be used for:

- Primary buttons.
- Active navigation.
- Links.
- Important UI states.
- Selected elements.
- Primary branding.

---

## 14.2 Secondary Colour — Orange

Orange is the secondary accent colour.

Orange represents:

- Food.
- Energy.
- Activity.
- Warmth.
- Action.

Orange should be used selectively for:

- Important secondary actions.
- Food-related highlights.
- Notifications.
- Delivery-related indicators.
- Small accents.
- Call-to-action emphasis where appropriate.

Orange should not overpower the dominant blue theme.

---

## 14.3 Neutral Colours

The interface should primarily use:

- White.
- Light grey.
- Dark grey.
- Soft neutral backgrounds.

The colour hierarchy should generally follow:

```text
Blue
  ↓
Primary Interface

Orange
  ↓
Secondary Accent

Neutral Colours
  ↓
Background and Supporting Content
```

---

# 15. Button Interaction

Buttons should have a subtle hover effect.

Recommended interaction:

```text
Default
   ↓
Hover
   ↓
Slight visual emphasis
```

Possible effects include:

- Slight colour change.
- Subtle elevation.
- Smooth transition.
- Minimal scale adjustment.

Buttons should avoid aggressive animations.

The primary button should use the dominant blue colour.

Secondary actions may use orange or neutral styling depending on context.

Destructive actions such as deleting data should use an appropriate warning/error colour rather than the primary blue or secondary orange.

---

# 16. Customer Features

## 16.1 Browse Canteens

Customers can view canteens registered within their school environment.

Each canteen card may display:

- Canteen name.
- Location.
- Description.
- Availability status.
- Menu preview.

---

## 16.2 Browse Menu

Customers can view menus offered by a canteen.

Each menu item may contain:

- Menu name.
- Description.
- Price.
- Availability.
- Optional image.
- Add-to-cart button.

---

## 16.3 Cart

Customers can:

- Add menu items.
- Increase quantity.
- Decrease quantity.
- Remove items.
- View subtotal.
- View delivery fee.
- View total.

---

## 16.4 Checkout

The checkout page displays:

- Canteen.
- Ordered items.
- Quantity.
- Price.
- Food subtotal.
- Delivery fee.
- Total.
- Delivery destination.
- Cash payment method.

The customer confirms the order before submission.

---

# 17. Seller Features

## 17.1 Canteen Registration

A seller can register a canteen by entering:

- Canteen name.
- School.
- Canteen location.
- Description.

The canteen may require System Manager verification before becoming publicly available.

---

## 17.2 Menu Management

The seller dashboard should provide a simple list-based menu management interface.

Example:

```text
Kantin Bu Sari

[ + Tambah Menu ]

Nasi Goreng
Rp10.000
Tersedia
[Edit] [Hapus]

Mie Goreng
Rp8.000
Tersedia
[Edit] [Hapus]

Es Teh
Rp3.000
Tidak Tersedia
[Edit] [Hapus]
```

The interface should prioritise simplicity and fast management.

---

# 18. Courier Features

## 18.1 Courier Registration

Users can register as couriers by providing:

- Name.
- School.
- Contact information.
- Courier availability.

The System Manager may verify courier accounts.

---

## 18.2 Courier Availability

Couriers can switch between:

```text
AVAILABLE
UNAVAILABLE
```

The courier should generally activate availability when they are able to deliver orders.

The system is designed to support the concept that student couriers may primarily operate during school breaks.

---

## 18.3 Available Orders

Available orders should display:

- Order number.
- Canteen.
- Food items.
- Delivery destination.
- Delivery fee.
- Relevant order information.

The courier can select:

> **Ambil Pesanan**

The order then becomes associated with the selected courier.

---

## 18.4 Delivery Flow

```text
READY_FOR_PICKUP
       ↓
Courier Accepts Order
       ↓
DELIVERING
       ↓
Customer Receives Food
       ↓
COMPLETED
```

The courier earns:

> **Rp2.000**

for each completed delivery order.

---

# 19. User Management

User Management is a core system feature.

The System Manager can:

- View users.
- Search users.
- Filter users by role.
- Filter users by school.
- Edit user information.
- Change user roles where authorised.
- Activate or deactivate accounts.
- Delete accounts where appropriate.

User roles:

```text
CUSTOMER
SELLER
COURIER
SYSTEM_MANAGER
```

Each role has different access permissions.

The system must enforce role-based access control to prevent users from accessing features outside their permissions.

---

# 20. CRUD Requirements

CRUD functionality is a core requirement of NitipAbiz.

## 20.1 School

- Create school.
- Read/view school.
- Update school.
- Delete school.

## 20.2 User

- Create user.
- Read/view user.
- Update user.
- Delete/deactivate user.

## 20.3 Canteen

- Create canteen.
- Read/view canteen.
- Update canteen.
- Delete canteen.

## 20.4 Menu

- Create menu.
- Read/view menu.
- Update menu.
- Delete menu.

## 20.5 Orders

- Create order.
- Read/view order.
- Update order status.
- Delete/cancel order according to rules.

## 20.6 Delivery

- Create delivery assignment.
- Read/view delivery.
- Update delivery status.
- Manage delivery records.

---

# 21. Search and Data Display

The system should provide search functionality where relevant.

Searchable data may include:

- Schools.
- Canteens.
- Menu items.
- Users.
- Orders.
- Delivery records.

Data should be displayed using clean tables, cards, or lists depending on the context.

For example:

### Seller Menu

```text
| Menu | Price | Stock | Status | Action |
|------|------:|------:|--------|--------|
| Nasi Goreng | Rp10.000 | 10 | Available | Edit/Delete |
```

### System Manager User Management

```text
| Name | School | Role | Status | Action |
|------|--------|------|--------|--------|
| Andi | SMK X | Courier | Active | Edit/Delete |
```

---

# 22. Core Database Entities

The initial database should contain the following entities:

```text
users
schools
canteens
menus
orders
order_items
deliveries
```

## users

```text
id
name
email
password
role
school_id
status
created_at
updated_at
```

## schools

```text
id
name
address
status
created_at
updated_at
```

## canteens

```text
id
owner_id
school_id
name
location
description
status
created_at
updated_at
```

## menus

```text
id
canteen_id
name
category
description
price
stock
status
created_at
updated_at
```

## orders

```text
id
customer_id
canteen_id
courier_id
status
subtotal
delivery_fee
total
created_at
updated_at
```

## order_items

```text
id
order_id
menu_id
quantity
price
subtotal
created_at
updated_at
```

## deliveries

```text
id
order_id
courier_id
status
earnings
created_at
updated_at
```

---

# 23. Key Business Rules

1. A user must have an account before using the ordering system.
2. After authentication, the user is directed to the **Pesanan** page.
3. The Pesanan page displays ongoing orders.
4. If there are no ongoing orders, the empty state displays **"Belum pesan. Nitip yuk!"**.
5. A canteen belongs to a specific school.
6. A menu belongs to a specific canteen.
7. One order can only contain items from one canteen.
8. Unavailable menu items cannot be ordered.
9. Ordered quantities cannot exceed available stock.
10. The delivery fee is fixed at Rp2.000 per order.
11. The courier receives Rp2.000 for each completed delivery.
12. Payment is cash only in the MVP.
13. Couriers should only receive relevant orders within their school environment.
14. Courier availability can be toggled by the courier.
15. Order status must follow the defined workflow.
16. Role-based access control must be enforced.
17. Users cannot access management functions outside their authorised role.
18. Canteens may require verification before appearing to customers.
19. Couriers may require verification before accepting delivery orders.

---

# 24. MVP Scope

The first version of NitipAbiz should include:

## Authentication

- Registration.
- Login.
- Logout.
- Role-based access.
- School association.

## Customer

- Pesanan page as default authenticated page.
- Empty order state.
- Canteen browsing.
- Menu browsing.
- Cart.
- Checkout.
- Cash payment selection.
- Order status.
- Order history.

## Seller

- Canteen registration.
- Canteen management.
- Menu CRUD.
- Order management.

## Courier

- Courier registration.
- Availability status.
- Available order list.
- Order acceptance.
- Delivery status update.
- Delivery history.
- Earnings history.

## System Manager

- User management.
- School CRUD.
- Canteen management.
- Canteen verification.
- Courier verification.
- Order monitoring.

---

# 25. Out of Scope for MVP

The following features are intentionally excluded from the first version:

- Digital payments.
- Payment gateways.
- E-wallet integration.
- Bank transfer integration.
- Real-time GPS tracking.
- Google Maps integration.
- Real-time courier location.
- In-app chat.
- Push notifications.
- AI recommendations.
- Discount and voucher systems.
- Complex rating systems.
- Multi-canteen orders.
- Professional courier fleet management.

These features may be considered for future development.

---

# 26. Future Development

Potential future features include:

1. Digital payment integration.
2. QR-based cashless payment.
3. Courier location tracking.
4. Real-time delivery tracking.
5. Push notifications.
6. Customer and seller ratings.
7. Promotional vouchers.
8. Food recommendations.
9. Order scheduling.
10. School-wide analytics.
11. Sales reports for sellers.
12. Courier performance reports.

---

# 27. Non-Functional Requirements

## Performance

The application should respond quickly to normal user interactions and avoid unnecessary loading times.

## Usability

The interface should be simple enough for first-time users to understand without extensive instructions.

## Responsiveness

The application should work on:

- Desktop.
- Laptop.
- Tablet.
- Mobile browser.

## Security

The system should implement:

- Secure authentication.
- Password hashing.
- Role-based access control.
- Input validation.
- Authorisation checks.
- Protection against unauthorised CRUD operations.

## Maintainability

The codebase should follow consistent naming conventions, modular architecture, readable code, and established development best practices.

---

# 28. UI/UX Principles

NitipAbiz should follow these principles:

1. **Minimalism** — show only information relevant to the current task.
2. **Clarity** — users should immediately understand what each page does.
3. **Consistency** — buttons, cards, forms, and navigation should behave consistently.
4. **Efficiency** — common actions should require minimal interaction.
5. **Visual Hierarchy** — important information should be visually prioritised.
6. **Locality** — school context should remain clear throughout the ordering experience.
7. **Feedback** — actions such as ordering, accepting, editing, and deleting should provide clear feedback.

---

# 29. Success Criteria

NitipAbiz is considered successful when:

- Users can register and log in.
- Users are correctly assigned to a school and role.
- Authenticated users land on the Pesanan page.
- Users can browse local school canteens.
- Customers can order available menu items.
- Sellers can perform CRUD operations on their menus.
- Sellers can process incoming orders.
- Couriers can register and become available.
- Couriers can accept delivery orders.
- Orders follow the correct status workflow.
- Completed deliveries record Rp2.000 courier earnings.
- System Managers can manage users and core platform data.
- CRUD functionality is implemented correctly.
- The interface follows the minimalist blue-and-orange design system.
- The application is usable on both desktop and mobile browsers.

---

# 30. Product Summary

NitipAbiz is a localised school food ordering and delivery platform designed around the unique conditions of a school environment.

Its core model is:

```text
CUSTOMER
    │
    │ Orders Food
    ▼
CANTEEN
    │
    │ Prepares Food
    ▼
COURIER
    │
    │ Delivers Food
    ▼
CUSTOMER
```

The system combines:

- School-localised food discovery.
- Canteen menu management.
- Food ordering.
- Cash-based transactions.
- Student-based courier delivery.
- Fixed Rp2.000 delivery compensation.
- User management.
- Role-based access control.
- CRUD functionality.
- Order status management.
- Minimalist blue-and-orange UI.

The core product philosophy is:

> **"Belum pesan. Nitip yuk!"**

NitipAbiz is intended to make school food ordering more convenient while creating a simple, localised ecosystem where members of the same school community can buy, sell, and deliver food efficiently.
"""

path = Path("/mnt/data/NitipAbiz_PRD.md")
path.write_text(content, encoding="utf-8")
print(path, path.exists(), path.stat().st_size)

# 31. Security, Identity Verification, and Transaction Integrity

NitipAbiz operates within a school community and uses cash-based transactions. Therefore, the primary security concerns are not complex cybersecurity threats or digital payment security, but rather **identity fraud, account abuse, delivery disputes, payment disputes, and dishonest behaviour between users**.

The security model of NitipAbiz focuses on establishing accountability through verified identities, role-based verification, transaction records, and mutual confirmation.

The core principle is:

> **Every important transaction should be traceable to a verified person, and every party involved should have accountability for their actions.**

---

## 31.1 School-Based Identity Verification

Every user must register with a school-based identity.

The minimum identity information includes:

- Full name.
- NIS (Nomor Induk Siswa).
- School.
- Face photo.
- Contact information.
- Password.

The primary identity association is:

```text
School ID
+
NIS
+
Face Photo
```

The combination of **School ID and NIS** is treated as the user's unique school identity.

NIS is used as the primary student identifier rather than a physical student card because some schools may not immediately provide student cards to all students.

---

## 31.2 Student Registry

The system should maintain an authorised student registry for each school.

Example:

```text
SMK Negeri X
├── NIS 10001
├── NIS 10002
├── NIS 10003
└── NIS 10004
```

When a user registers, the submitted NIS and school are checked against the authorised student records.

The system should prevent users from freely claiming membership in a school by simply selecting a school during registration.

The System Manager can manage the authorised student registry through CRUD functionality:

- Create student records.
- View student records.
- Update student records.
- Delete or deactivate student records.
- Assign students to schools.
- Search students by NIS.

In a future production implementation, this registry could be integrated with an official school student database. For the initial version, the registry may be maintained by the System Manager.

---

## 31.3 User Verification Status

Users should have a verification status:

```text
UNVERIFIED
PENDING_REVIEW
VERIFIED
REJECTED
SUSPENDED
```

The verification status determines which features the user can access.

A verified user may use standard customer functionality, while restricted or suspended accounts cannot perform activities that require an active verified identity.

---

## 31.4 Courier Verification

Becoming a courier requires additional verification because couriers are entrusted with collecting food and completing cash-based transactions.

A user requesting courier access must submit:

- Registered NIS.
- Registered school.
- Face photo.
- Student ID card photo, where applicable.
- Any additional information required by the System Manager.

The courier verification process is:

```text
User
  ↓
Requests Courier Role
  ↓
Submits Verification Data
  ├── NIS
  ├── School
  ├── Face Photo
  └── Student ID Photo
  ↓
System Manager Reviews
  ↓
APPROVED / REJECTED
```

If approved:

```text
CUSTOMER
    ↓
VERIFIED COURIER
```

If rejected:

```text
CUSTOMER
    ↓
COURIER VERIFICATION REJECTED
```

Only approved couriers can access courier functionality and accept delivery orders.

---

## 31.5 Courier Verification Status

Courier accounts should have a separate verification status:

```text
COURIER_PENDING
COURIER_VERIFIED
COURIER_REJECTED
COURIER_SUSPENDED
```

This creates a distinction between:

> **Being a registered NitipAbiz user**

and:

> **Being authorised to operate as a courier.**

A user may remain a normal customer even if their courier application is rejected or suspended, unless their entire account is separately restricted.

---

## 31.6 Identity Binding and Ban Evasion Prevention

To reduce the possibility of users circumventing suspensions by creating new accounts, NitipAbiz associates accounts with verified school identities.

The identity binding is based on:

```text
School ID
+
NIS
+
Face Photo
```

A verified NIS should not be allowed to create an unrelated new account while its associated identity is suspended.

If a courier is suspended, the system should mark the associated verified identity as restricted.

This makes it significantly more difficult for a suspended user to bypass a punishment by simply creating a new account with another email address.

The system should therefore treat account suspension as an identity-level restriction rather than merely an email or username restriction.

This mechanism does not guarantee that ban evasion is impossible, but it significantly increases the difficulty of creating replacement accounts and strengthens accountability within the school community.

---

## 31.7 Account and Role Separation

NitipAbiz should separate general account verification from courier verification.

### Level 1 — User Verification

```text
NIS
+
School
+
Face Photo
```

This establishes that the user belongs to the relevant school community.

### Level 2 — Courier Verification

```text
Verified User
+
Student ID Photo, where applicable
+
System Manager Approval
```

This establishes that the user is trusted to perform courier activities.

The resulting structure is:

```text
                    ACCOUNT
                       │
                       ▼
              NIS + SCHOOL + FACE
                       │
                       ▼
                USER VERIFIED
                       │
             ┌─────────┴─────────┐
             │                   │
          CUSTOMER           COURIER
                                 │
                                 ▼
                      ADDITIONAL VERIFICATION
                                 │
                                 ▼
                      SYSTEM MANAGER APPROVAL
                                 │
                                 ▼
                      COURIER VERIFIED
```

---

## 31.8 Cash Transaction Integrity

NitipAbiz uses cash-only payments in the MVP.

Because there is no digital payment gateway, the system cannot directly verify the physical exchange of money.

Therefore, the system uses **mutual confirmation and transaction records** to establish accountability.

The recommended transaction flow is:

```text
Customer Places Order
        ↓
Canteen Accepts Order
        ↓
Canteen Prepares Food
        ↓
Food Ready for Pickup
        ↓
Courier Accepts Order
        ↓
Courier Collects Food
        ↓
Courier Delivers Food
        ↓
Customer Pays Cash
        ↓
Customer Confirms Receipt
        ↓
Order Completed
```

The system records important events associated with the order, including:

- Order ID.
- Customer.
- Canteen.
- Courier.
- Order status.
- Order amount.
- Delivery fee.
- Relevant timestamps.

This creates a digital record of a transaction even though the actual payment occurs physically in cash.

---

## 31.9 Order Completion and Mutual Confirmation

The system should distinguish between an order being **delivered** and an order being **completed**.

The recommended status flow is:

```text
PENDING
   ↓
ACCEPTED
   ↓
PREPARING
   ↓
READY_FOR_PICKUP
   ↓
DELIVERING
   ↓
DELIVERED
   ↓
COMPLETED
```

### DELIVERED

The courier indicates that the food has reached the customer.

At this stage, the transaction is not yet considered fully completed.

### COMPLETED

The customer confirms that:

1. The order was received.
2. The required cash payment was made.

Only after confirmation should the order be marked as completed.

This creates mutual accountability between the courier and customer.

The courier cannot independently declare a disputed delivery as successfully completed without customer confirmation.

---

## 31.10 Payment and Delivery Disputes

The system should provide a mechanism for reporting transaction problems.

Possible dispute types include:

```text
PAYMENT_DISPUTED
DELIVERY_DISPUTED
ORDER_NOT_RECEIVED
INCORRECT_ORDER
OTHER_ISSUE
```

For example, if a courier claims that an order was delivered but the customer states that the food was never received, the customer can report a delivery dispute.

If a customer refuses to pay after receiving the food, the courier can report a payment dispute.

Disputed orders should be recorded and made available to the System Manager for review.

The system should preserve relevant information such as:

- Order ID.
- Customer.
- Courier.
- Canteen.
- Order value.
- Delivery fee.
- Current status.
- Dispute type.
- Dispute description.
- Time of report.

The System Manager may review the dispute and determine the appropriate action.

---

## 31.11 Transaction History and Accountability

NitipAbiz should maintain a history of important actions associated with an order.

Example:

```text
10:00 — Andi created Order #1024
10:02 — Kantin Bu Sari accepted the order
10:05 — Kantin Bu Sari marked the order as ready
10:07 — Budi accepted the delivery
10:09 — Budi marked the order as delivering
10:15 — Budi marked the order as delivered
10:16 — Andi confirmed receipt
10:16 — Order completed
```

This transaction history creates a basic digital chain of custody.

The system should be able to identify:

```text
WHO
WHAT
WHEN
STATUS
```

This allows the System Manager to investigate disputes based on recorded events rather than relying entirely on conflicting verbal claims.

---

## 31.12 Courier Accountability

Couriers are responsible for the order after accepting and collecting it from the canteen.

A courier's record may include:

- Number of completed deliveries.
- Number of cancelled deliveries.
- Number of reported disputes.
- Number of successful transactions.
- Current courier status.

Repeated problematic behaviour may result in:

```text
First Report
    ↓
Review / Warning

Repeated Reports
    ↓
Temporary Courier Suspension

Confirmed Serious Abuse
    ↓
Permanent Courier Suspension
```

The purpose is to discourage dishonest behaviour while allowing legitimate disputes to be reviewed fairly.

---

## 31.13 Customer Accountability

Customers are also subject to transaction accountability.

A customer who repeatedly:

- Refuses to pay.
- Claims false non-delivery.
- Abuses cancellation functionality.
- Creates repeated disputes without valid reasons.

may receive:

```text
Warning
    ↓
Temporary Restriction
    ↓
Account Suspension
```

This ensures that the security system does not unfairly place all responsibility on couriers.

Both sides of a transaction must be accountable.

---

## 31.14 Cancellation Rules

Order cancellation should depend on the current status of the order.

Recommended rules:

| Order Status     | Customer Cancellation           |
| ---------------- | ------------------------------- |
| PENDING          | Allowed                         |
| ACCEPTED         | Restricted or subject to review |
| PREPARING        | Not allowed                     |
| READY_FOR_PICKUP | Not allowed                     |
| DELIVERING       | Not allowed                     |
| DELIVERED        | Not allowed                     |
| COMPLETED        | Not allowed                     |

This prevents customers from cancelling orders after the canteen has prepared the food or after a courier has already taken responsibility for the delivery.

---

## 31.15 Security Principles

The overall NitipAbiz security model follows five principles:

### 1. Identity

Users are associated with a verified school identity.

### 2. Accountability

Important actions are associated with specific users.

### 3. Mutual Confirmation

Customers and couriers both participate in confirming successful transactions.

### 4. Traceability

Orders maintain a history of relevant status changes and events.

### 5. Consequences

Repeated abuse can result in warnings, restrictions, or account suspension.

The core security philosophy is:

> **NitipAbiz does not rely on complex cybersecurity mechanisms to prevent ordinary transactional abuse. Instead, it reduces opportunities for abuse through verified identity, accountability, transaction records, mutual confirmation, and enforceable consequences.**

This approach is designed specifically for the school environment, where users are members of a relatively closed community and where establishing accountability can be more effective than implementing unnecessarily complex technical security systems.
