# ENN KANITHAM (எண் கணிதம்) — Numerology Compatibility Portal

A full-stack, bilingual (**English & தமிழ்**) numerology compatibility application built with **Laravel 12**, **Blade**, **Bootstrap 5**, **MySQL**, and **Dompdf**.

---

## 1. 📌 Project Overview and Objectives

### Overview
**ENN KANITHAM** is an interactive web portal designed to compute harmonic compatibility between two individuals based on their Date of Birth (Life Path) and Full Names (Destiny, Soul Urge, and Personality numbers). Inspired by classical Pythagorean numerology and Vedic principles, the application provides detailed, actionable relationship insights presented in both English and Tamil.

### Objectives
- **Profile Comparison Engine:** Compare two profiles using Date of Birth (DOB), First Name, and Last Name.
- **Harmonic Compatibility Analysis:** Calculate core numerology numbers (Life Path, Destiny, Soul Urge, Personality) and derive a percentage-based match score.
- **Bilingual Interface:** Support English and Tamil across all public, user, and admin views with dynamic switching.
- **Role-Based Workflow:** Distinct User and Admin portals with role-based access control (`EnsureAdmin` middleware).
- **Single-Page PDF Generation:** Create an auspicious, gold-bordered PDF certificate formatted for desktop and mobile, with embedded Tamil Unicode fonts.
- **Gated Email Delivery:** Ensure that only administrator-approved reports can be emailed to users, backed by server-side security checks and SMTP integration.

---

## 2. 🌟 Main Features and Functionality

### 1. Profile Comparison & Compatibility Calculation
- Compares Person 1 and Person 2 by **First Name**, **Last Name**, and **DOB**.
- Clean form inputs with placeholder hints (`e.g. Arun`, `e.g. Priya`) and alphabet-only validation.
- Calculates 4 core numbers for each person:
  - **Life Path Number:** Reduced sum of DOB digits (preserves Master Numbers 11, 22, 33).
  - **Destiny / Expression Number:** Pythagorean gematria mapping over the full name.
  - **Soul Urge Number:** Sum of vowels (A, E, I, O, U) representing inner motivations.
  - **Personality Number:** Sum of consonants representing outward persona.
- Computes weighted compatibility score (e.g. `78%`) with detailed bilingual interpretations.

### 2. User Portal
- **Authentication:** Registration, login, and secure logout.
- **User Dashboard:** Summary metrics (Total Reports, Pending, Approved) and recent reports table.
- **Calculation Preview:** Real-time preview (`/reports/calculate`) with options to recalculate or save.
- **My Reports (`/reports`):** Comprehensive table showing all user reports with status badges and action icons (View, Email, Download).

### 3. Admin Portal (`role: admin`)
- **Protected Access:** Enforced by `EnsureAdmin` middleware (unauthorized users receive `403 Forbidden`).
- **Admin Dashboard (`/admin/dashboard`):** Real-time status metric cards (Pending, Approved, Emailed, Rejected).
- **Report Management (`/admin/reports`):** Filter reports by status (`All`, `Pending`, `Approved`, `Emailed`, `Rejected`).
- **Actions:**
  - **Approve:** Approves the report, unlocking the user's ability to email it.
  - **Reject:** Marks report as rejected with optional administrative notes.
  - **Approve & Send Email:** One-click action that approves and immediately dispatches the PDF report to the user's email.
- **User Management (`/admin/users`):** Directory of registered users and their report counts.

### 4. Single-Page PDF Reports
- Auspicious gold double-border framing designed to fit on **exactly 1 page** (A4 Portrait).
- Resolves standard Dompdf Tamil box artifacts by embedding the TrueType **Nirmala UI** Unicode font.
- Print-friendly and mobile-responsive layout.

### 5. Gated Email Functionality
- Reports are dispatched via Laravel Mail with the generated PDF attached (`App\Mail\ReportMail`).
- **Strict Security Gate:** Newly created reports are set to `Pending`. The email option remains locked until an administrator approves the report.

### 6. Bilingual Support (English & தமிழ்)
- One-click language switcher in the top navigation bar.
- Comprehensive translations across all views and generated PDFs (`lang/en/messages.php` and `lang/ta/messages.php`).

---

## 3. 🛠 Technologies Used

| Technology | Purpose |
|---|---|
| **Laravel 12.x** | Core PHP web framework (MVC architecture, routing, middleware, mailables) |
| **PHP 8.2+** | Server-side runtime |
| **MySQL 8.0+** | Relational database (`numerology_match`) |
| **Blade** | Templating engine for clean component and layout rendering |
| **Bootstrap 5.3 & Icons** | Responsive UI styling, components, and icon sets |
| **Barryvdh / Laravel-Dompdf** | Server-side PDF generation engine |
| **Nirmala UI (TrueType Font)** | Embedded font for rendering Tamil characters in PDFs without squares |
| **Laravel Mail + SMTP** | Email delivery with PDF attachment (configured with Gmail SMTP) |
| **PHPUnit / Artisan Test** | Automated testing suite (15 unit and feature tests) |

---

## 4. 👥 For Reviewers

### Demo Credentials

| Role | Email | Password | Access Area |
|---|---|---|---|
| **Administrator** | `admin@gmail.com` | `admin123` | Full Admin Portal (`/admin/dashboard`, `/admin/reports`, `/admin/users`) |
| **Demo User** | `anandhi@gmail.com` | `anandhi123` | User Portal (`/dashboard`, `/reports/create`, `/reports`) |

*(Self-registration is also available via the **Sign Up** button on the home page).*

---

### Reviewer Evaluation Walkthrough

Follow these steps to evaluate the application end-to-end:

#### Step 1: Language Switcher Check
1. In the top navbar, click **தமிழ்**. Notice the whole page, menus, and feature cards translate to Tamil.
2. Click **English** to switch back anytime.

#### Step 2: Create a Compatibility Report
1. Log in as a user (`anandhi@gmail.com` / `anandhi123`).
2. Go to **Create New Report** (`/reports/create`).
3. Fill in Person 1 and Person 2 details and click **Calculate Compatibility**.
4. Review the 4-number matrix, compatibility score, and summary readings on the **Result** page.
5. Click **Save Report**.

#### Step 3: Verify the Email Gate
1. On the saved report page, verify the status badge is **`Pending`**.
2. Notice the message: *"Awaiting administrator review. Once approved, the email option will be activated."*
3. **The Email button is locked**, enforcing the requirement that only approved reports can be sent via email.

#### Step 4: Admin Approval
1. Log out from the user account and log in as Admin (`admin@gmail.com` / `admin123`).
2. Open **All Reports** (`/admin/reports`).
3. Locate the pending report and click **Approve** (or click the Eye icon ➔ **Approve & Send Email**).
4. The report status updates to **Approved**.

#### Step 5: User Email & Single-Page PDF
1. Log back in as `anandhi@gmail.com` / `anandhi123`.
2. Go to **My Reports** (`/reports`). Notice the **Email** icon is now unlocked.
3. Click the **Email** button (or click **Send to My Email** inside the report).
4. A success alert confirms the email with PDF has been sent.
5. Click the **Download** button to view the PDF:
   - Check that it fits on **exactly 1 page** (A4 Portrait).
   - Check the auspicious gold double-border framing.
   - Verify that all Tamil characters render clearly with no square boxes.

---

## 5. ⚙️ Installation and Setup Instructions

### 1. Prerequisites
- **PHP 8.2+** with extensions: `pdo_mysql`, `mbstring`, `openssl`, `gd`
- **Composer 2.x**
- **MySQL 8.0+** (via XAMPP or standalone)

### 2. Database Setup
Create database `numerology_match` in MySQL:
```sql
CREATE DATABASE numerology_match CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Environment Configuration
Verify your `.env` settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=numerology_match
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=anandhi105@gmail.com
MAIL_PASSWORD=bwizhpbuavrukxlp
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="anandhi105@gmail.com"
MAIL_FROM_NAME="ENN KANITHAM"
```

### 4. Run Migrations & Seeders
```bash
php artisan migrate --force
php artisan db:seed
```

### 5. Start Development Server
```bash
php artisan serve
```
Open **[http://localhost:8000](http://localhost:8000)** in your browser.

---

## 6. 🧪 How to Test the Application

The project includes an automated test suite covering numerology business logic, role-based authorization, and email gating.

### Run All Tests:
```powershell
php artisan test
```

### Expected Output:
```
PASS  Tests\Unit\NumerologyServiceTest
✓ it calculates life path number correctly
✓ it calculates destiny number correctly
✓ it calculates soul urge from vowels
✓ it calculates personality from consonants
✓ it compares two profiles with valid score and summaries

PASS  Tests\Feature\ReportWorkflowTest
✓ user can register and login
✓ regular user cannot access admin dashboard (403 check)
✓ admin can access admin dashboard
✓ user can create and save report with pending status
✓ non approved report cannot be sent via email (security gate)
✓ approved report can be sent via email
✓ admin can approve and send email directly
✓ pdf endpoint generates valid pdf for owner

Tests: 15 passed (36 assertions)
```

---

## 7. 🔗 Project Documentation Link

- **Interactive HTML Documentation:** Open [`ENN_KANITHAM_Project_Documentation.html`](./ENN_KANITHAM_Project_Documentation.html) in your browser.
- **Online Web Documentation:** **[http://localhost:8000/documentation](http://localhost:8000/documentation)**
- **Download Markdown File:** **[http://localhost:8000/documentation/download](http://localhost:8000/documentation/download)**
