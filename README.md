# NitipAbiz

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2.12-blue?style=flat-square&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MariaDB-10.4.32-blue?style=flat-square&logo=mariadb" alt="MariaDB">
  <img src="https://img.shields.io/badge/Node.js-22.20.0-green?style=flat-square&logo=node.js" alt="Node.js">
  <img src="https://img.shields.io/badge/Status-Development-yellow?style=flat-square" alt="Status">
</p>

## 📖 Tentang NitipAbiz

NitipAbiz adalah platform pemesanan dan pengiriman makanan berbasis web yang dirancang khusus untuk lingkungan sekolah. Platform ini menghubungkan **Customer**, **Canteen Sellers**, dan **Couriers** dalam ekosistem lokal sekolah, memungkinkan siswa untuk memesan makanan dari kantin sekolah dengan sistem pengiriman yang aman dan terpercaya.

### 🎯 Fitur Utama

- **Multi-Role System**: Customer, Seller, Courier, dan System Manager
- **School-Based Locality**: Semua transaksi berbasis sekolah
- **Identity Verification**: Validasi NIS dan verifikasi identitas
- **Real-time Order Tracking**: Pelacakan status pesanan secara real-time
- **Cash Payment System**: Sistem pembayaran tunai yang sederhana
- **Dispute Management**: Sistem pelaporan dan penyelesaian sengketa

## 🚀 Tech Stack

- **Backend**: Laravel 12.x
- **PHP**: 8.2.12
- **Database**: MariaDB 10.4.32 (MySQL-compatible)
- **Frontend**: Blade Templates + Vite + Tailwind CSS
- **Node.js**: v22.20.0

## 📋 Prerequisites

Sebelum memulai, pastikan Anda sudah menginstall:

- [PHP 8.2+](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [Node.js 22.x+](https://nodejs.org/)
- [XAMPP](https://www.apachefriends.org/) (untuk MariaDB/MySQL)
- Git

## 🛠️ Installation

### 1. Clone Repository

```bash
git clone <repository-url>
cd nitipabiz-app
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

**PENTING**: Pastikan XAMPP MySQL service sudah berjalan!

```bash
# Buat database melalui XAMPP phpMyAdmin atau command line
mysql -u root -e "CREATE DATABASE nitipabiz;"

# Update .env file dengan konfigurasi database:
# DB_CONNECTION=mariadb
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=nitipabiz
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate
```

### 5. Run Development Server

```bash
# Terminal 1 - Laravel Server
php artisan serve

# Terminal 2 - Vite Dev Server
npm run dev
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 📁 Project Structure

```
nitipabiz-app/
├── app/
│   ├── Http/
│   │   └── Controllers/     # Application controllers
│   └── Models/              # Eloquent models
├── config/                  # Configuration files
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories
├── public/                  # Public assets
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheets
│   └── js/                  # JavaScript files
├── routes/                  # Application routes
├── storage/                 # Storage files (logs, cache, uploads)
└── tests/                   # Application tests
```

## 🗃️ Database Schema

### Main Tables

1. **schools** - Data sekolah
2. **users** - Data pengguna dengan roles
3. **student_registry** - Registry siswa untuk validasi NIS
4. **canteens** - Data kantin sekolah
5. **menus** - Menu makanan
6. **orders** - Data pesanan
7. **order_items** - Detail item pesanan
8. **deliveries** - Data pengiriman
9. **order_history** - History status pesanan
10. **disputes** - Laporan dispute transaksi

## 👥 User Roles

| Role | Deskripsi |
|------|-----------|
| **Customer** | Siswa yang memesan makanan |
| **Seller** | Pemilik/pengelola kantin |
| **Courier** | Kurir pengiriman pesanan |
| **System Manager** | Administrator platform |

## 🔐 Security Features

### ⚠️ CRITICAL FILES - NEVER COMMIT TO GIT

- `.env` - Contains database credentials and app secrets
- `storage/*.key` - Private encryption keys
- `/auth.json` - Composer authentication
- Any backup files (`.sql`, `.dump`)

### 🛡️ Security Measures Implemented

1. **Environment Variables**: All sensitive data in `.env` (never committed)
2. **Identity Verification**: NIS validation + photo verification
3. **Ban Evasion Prevention**: School ID + NIS binding
4. **Transaction Logging**: Complete order history tracking
5. **Secure File Storage**: User uploads isolated in storage directory
6. **CSRF Protection**: Laravel CSRF tokens on all forms
7. **SQL Injection Prevention**: Eloquent ORM and prepared statements

## 📝 Development Guidelines

### Code Standards

- Follow PSR-12 coding standards
- Use Laravel best practices
- Write meaningful commit messages
- Keep controllers thin, models fat

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/your-feature-name

# Make changes and commit
git add .
git commit -m "feat: add your feature description"

# Push to remote
git push origin feature/your-feature-name
```

### Commit Message Convention

- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation changes
- `style:` Code style changes (formatting)
- `refactor:` Code refactoring
- `test:` Adding tests
- `chore:` Maintenance tasks

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TestName
```

## 🚢 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Generate new `APP_KEY`
- [ ] Configure production database credentials
- [ ] Set up proper file permissions (`storage/` and `bootstrap/cache/`)
- [ ] Enable HTTPS
- [ ] Configure proper CORS settings
- [ ] Set up automated backups
- [ ] Configure proper logging
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm run build`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`

## 🤝 Contributing

Contributions are welcome! Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## 🔒 Security Vulnerabilities

If you discover a security vulnerability, please send an email to the development team. All security vulnerabilities will be promptly addressed.

**DO NOT** create public GitHub issues for security vulnerabilities.

## 📄 License

This project is proprietary software. All rights reserved.

## 👨‍💻 Development Team

- **Project Name**: NitipAbiz
- **Version**: 1.0.0 (MVP)
- **Status**: Development Phase 1
- **Started**: July 27, 2026

## 📚 Additional Documentation

- [PROJECT_SETUP.md](PROJECT_SETUP.md) - Detailed setup and architecture documentation
- [SECURITY.md](SECURITY.md) - Security guidelines and policies
- [CONTRIBUTING.md](CONTRIBUTING.md) - Contribution guidelines

## 🆘 Support

For support and questions:
- Check [PROJECT_SETUP.md](PROJECT_SETUP.md) for detailed documentation
- Review existing GitHub issues
- Create a new issue with detailed information

---

Made with ❤️ for Indonesian School Communities
