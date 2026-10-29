# ENN KANITHAM (எண் கணிதம்) — Numerology Compatibility Portal

A bilingual (English & Tamil) web application built with **Laravel 12**, **Blade**, **Bootstrap 5**, and **MySQL** that computes numerological compatibility between two individuals based on their Date of Birth (Life Path) and Full Names (Destiny, Soul Urge, and Personality numbers).

Includes a full role-gated **Admin Portal** where submitted reports are reviewed and approved, generating high-quality **PDF reports** (via Dompdf) that can only be emailed once approved by an administrator.

---

## 🌟 Key Features

1. **Compare 2 Profiles**:
   - Compares Person 1 and Person 2 using:
     - **Date of Birth (DOB)**
     - **First Name**
     - **Last Name**
2. **Numerology Calculation Engine (`App\Services\NumerologyService`)**:
   - **Life Path Number**: Sum of all DOB digits, repeatedly reduced to a single digit (preserving Master Numbers 11, 22, 33).
   - **Destiny / Expression Number**: Pythagorean letter map (A=1...I=9, J=1...R=9, S=1...Z=8) over full name.
   - **Soul Urge Number**: Calculated strictly from the vowels (A, E, I, O, U) representing inner heart's desire.
   - **Personality Number**: Calculated from the consonants representing public persona.
   - **Compatibility Matrix**: Weighted harmonic synthesis yielding a compatibility percentage (e.g. 78%) with rich bilingual interpretations (English & Tamil).
3. **Bilingual Support (English & தமிழ்)**:
   - One-click language toggle across both User and Admin portals.
   - Dynamic localized strings, messages, labels, and numerological readings.
4. **User Portal**:
   - Clean authentication (Register, Login, Logout).
   - User Dashboard with summary stats: Total Reports, Pending, Approved.
   - Create Compatibility Report with client & server-side validation.
   - Real-time compatibility results preview before saving.
   - "My Reports" page with status badges (`Pending`, `Approved`, `Emailed`, `Rejected`).
   - PDF streaming & downloading.
   - Email report trigger (strictly gated to approved reports).
5. **Admin Portal (`role:admin`)**:
   - Dashboard with stats: Pending, Approved, Emailed, Rejected.
   - Report review panel with PDF preview.
   - Single-click **"Approve & Send Email"** action (attaches PDF to user's registered email).
   - Reject workflow with optional administrative notes.
   - User management directory.
6. **PDF Generation (`barryvdh/laravel-dompdf`)**:
   - Auspicious traditional decorative border framing.
   - Fully responsive, print-safe layout optimized for desktop, tablet, and mobile viewers.

---

## 🧮 Numerology Method & Worked Example

### 1. Pythagorean Letter Values
| 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 |
|---|---|---|---|---|---|---|---|---|
| A | B | C | D | E | F | G | H | I |
| J | K | L | M | N | O | P | Q | R |
| S | T | U | V | W | X | Y | Z |   |

### 2. Worked Example (from UI Mockup)
**Person 1: Arun Kumar (DOB: 12-06-1992)**
- **Life Path**: `1 + 2 + 0 + 6 + 1 + 9 + 9 + 2 = 30 -> 3 + 0 = 3`
- **Destiny**:
  - `A(1) + R(9) + U(3) + N(5) = 18 -> 9`
  - `K(2) + U(3) + M(4) + A(1) + R(9) = 19 -> 1 + 9 = 10 -> 1`
  - Total: `9 + 1 = 10 -> 1`
- **Soul Urge (Vowels A, U, U, A)**:
  - `A(1) + U(3) = 4` (Arun)
  - `U(3) + A(1) = 4` (Kumar)
  - Total: `4 + 4 = 8`
- **Personality (Consonants R, N, K, M, R)**:
  - `R(9) + N(5) = 14 -> 5` (Arun)
  - `K(2) + M(4) + R(9) = 15 -> 6` (Kumar)
  - Total: `14 + 15 = 29 -> 11 -> 2`

---

## 🚀 Setup & Installation Instructions

### 1. Prerequisites
- **PHP 8.2+** with `pdo_mysql`, `mbstring`, `openssl`, `gd` extensions enabled.
- **MySQL 8.0+** (running via XAMPP or standalone).
- **Composer 2.x**.

### 2. Database Configuration
Ensure MySQL is running in XAMPP. Create database `numerology_match`:
```sql
CREATE DATABASE numerology_match CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Update your `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=numerology_match
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
```

### 3. Run Migrations and Seeders
```bash
php artisan migrate --force
php artisan db:seed
```

### 4. Start the Application Server
```bash
php artisan serve
```
Open **[http://localhost:8000](http://localhost:8000)** in your browser.

---

## 🔑 Login Credentials

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@gmail.com` | `admin123` |
| **Demo User** | `anandhi@gamil.com` | `anandhi123` |
| **Demo User 2** | `abe@gamil.com` | `abe123` |

*(You can also click "Sign Up" to register any new user account directly.)*

---

## 🧪 Running Automated Tests

Run the full test suite with PHPUnit / Artisan:
```bash
php artisan test
```
All **15 tests (36 assertions)** verify:
- Accurate Life Path, Destiny, Soul, and Personality calculations
- Role-based authorization (`EnsureAdmin` middleware protecting admin routes)
- Server-side gate ensuring non-approved reports cannot be emailed
- PDF generation stream & mime type checks
- Immediate dispatch of email with PDF attachment upon Admin approval

---

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── AdminReportController.php   # Admin dashboard, approve/reject/email
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php          # Register, Login, Role redirection
│   │   │   ├── DashboardController.php         # User dashboard & stats
│   │   │   ├── HomeController.php              # Public landing page
│   │   │   ├── LocaleController.php            # Dynamic English/Tamil switcher
│   │   │   └── ReportController.php            # Comparison, Preview, PDF & email
│   │   └── Middleware/
│   │       ├── EnsureAdmin.php                 # Admin gatekeeper
│   │       └── SetLocale.php                   # Session locale middleware
│   ├── Mail/
│   │   └── ReportMail.php                      # Mailable with PDF attachment
│   ├── Models/
│   │   ├── Report.php                          # Report model & scopes
│   │   └── User.php                            # User model with role helper
│   └── Services/
│       └── NumerologyService.php               # Core numerology algorithm
├── lang/
│   ├── en/messages.php                         # English translations
│   └── ta/messages.php                         # Tamil translations
├── resources/views/
│   ├── admin/                                  # Admin portal Blade templates
│   ├── auth/                                   # Login & Register views
│   ├── emails/                                 # Email template (Screen 9)
│   ├── layouts/app.blade.php                   # Main Bootstrap 5 layout
│   └── reports/                                # Form, Result (Screen 6), PDF (Screen 7)
└── tests/
    ├── Feature/ReportWorkflowTest.php          # Feature tests
    └── Unit/NumerologyServiceTest.php          # Pure logic tests
```
