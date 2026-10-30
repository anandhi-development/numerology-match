# ENN KANITHAM (எண் கணிதம்) — Numerology Compatibility Portal

A full-stack, bilingual (**English & தமிழ்**) numerology compatibility platform built with **Laravel 12**, **Blade**, **Bootstrap 5**, **MySQL**, and **Dompdf**. The application allows users to compare two individuals based on their Date of Birth (Life Path) and Full Names (Destiny, Soul Urge, Personality numbers), preview harmonic compatibility, save reports, generate single-page PDF certificates, and receive approved reports via email with PDF attachments.

---

## 📋 Table of Contents
1. [Tech Stack & Architecture](#-tech-stack--architecture)
2. [What Was Built & Delivered](#-what-was-built--delivered)
3. [Numerology Engine Logic](#-numerology-engine-logic)
4. [Hiring Team & Reviewer Evaluation Guide](#-hiring-team--reviewer-evaluation-guide)
5. [Demo Credentials](#-demo-credentials)
6. [Step-by-Step Test Walkthrough](#-step-by-step-test-walkthrough)
7. [Automated Testing](#-automated-testing)
8. [Folder Structure](#-folder-structure)

---

## 🛠 Tech Stack & Architecture

- **Backend Framework:** Laravel 12.x (PHP 8.2+)
- **Frontend / Templating:** Laravel Blade + Bootstrap 5.3 + Bootstrap Icons
- **Database:** MySQL (`numerology_match`)
- **Authentication & Authorization:** Custom role-based auth (`admin` & `user` roles) with `EnsureAdmin` middleware
- **PDF Engine:** `barryvdh/laravel-dompdf` (v3.1) configured with embedded **Nirmala UI** Unicode font for full Tamil script rendering
- **Email Delivery:** Laravel Mail + SMTP (connected with live Gmail SMTP + log sandbox fallback)
- **Internationalization (i18n):** Complete English & Tamil bilingual localization (`lang/en/messages.php` & `lang/ta/messages.php`) with session-based switching (`SetLocale` middleware)

---

## 🌟 What Was Built & Delivered

### 1. Profile Comparison Feature
- Input: **First Name**, **Last Name**, and **Date of Birth** for two individuals (Person 1 and Person 2).
- Real-time client & server validation (regex for alpha-only names, valid past date validation).
- Form pre-populates with clean placeholder hints (`e.g. Arun`, `e.g. Priya`) without hardcoded values.

### 2. Numerology Calculation Engine (`App\Services\NumerologyService`)
- **Life Path Number:** Sum of all digits of DOB, reduced to a root digit (1–9) while properly preserving Master Numbers (**11, 22, 33**).
- **Destiny / Expression Number:** Full Pythagorean gematria mapping across all consonants and vowels.
- **Soul Urge Number:** Reduced sum of vowels (A, E, I, O, U) representing core inner motivation.
- **Personality Number:** Reduced sum of consonants representing outer persona.
- **Harmonic Compatibility Matrix:** Weighted synthesis of all four core number pairs, calculating a percentage score (e.g. `78%`) and paired with contextual interpretations in both English and Tamil.

### 3. User Portal
- **Signup & Authentication:** Registration, Login with role-based redirection (admin ➔ `/admin/dashboard`, regular user ➔ `/dashboard`).
- **Dashboard:** Welcome header, metrics (Total Reports, Pending, Approved), recent reports table, and clean action shortcuts.
- **Create Report Page:** Side-by-side comparative inputs with breadcrumb navigation.
- **Preview & Save:** Real-time calculation preview (`/reports/calculate`) with option to recalculate or persist to database (status initializes to `pending`).
- **My Reports (`/reports`):** Comprehensive table showing all reports created by the authenticated user with color-coded status badges (`pending`, `approved`, `emailed`, `rejected`) and compact action icons (View, Email, Download).

### 4. Admin Portal & Role-Based Security
- Accessible strictly by users with `role: 'admin'`. Unauthorized regular users are rejected with `403 Forbidden` (`EnsureAdmin` middleware).
- **Admin Dashboard (`/admin/dashboard`):** Real-time counter cards (Pending, Approved, Emailed, Rejected).
- **Reports Review Table:** Tabbed filtering by status (`All`, `Pending`, `Approved`, `Emailed`, `Rejected`).
- **Admin Action Workflow:**
  - **Approve:** Moves status to `approved`, immediately unlocking the email option for the user.
  - **Reject:** Marks status as `rejected` with optional review notes.
  - **Approve & Send Email:** Single-click approval that dispatches the PDF report directly to the user's email address.
- **User Management Directory (`/admin/users`):** Displays all registered users, roles, and report counts.

### 5. Single-Page PDF Report (`Dompdf`)
- Designed to open cleanly on **Desktop, Tablet, and Mobile browsers**.
- Fixed to **exactly 1 page** (A4 Portrait) with auspicious gold double-border framing.
- Solved the standard Dompdf Tamil font limitation by embedding the **Nirmala UI** TrueType font directly into the PDF binary via `@font-face` and enabling subsetting (`isFontSubsettingEnabled => true`), ensuring Tamil glyphs render without box artifacts.

### 6. Email Functionality (Live SMTP + Attached PDF)
- Implementation: `App\Mail\ReportMail` uses Laravel Mailables and attaches the generated PDF on the fly via `Attachment::fromData()`.
- **Enforced Security Gate:** Non-approved reports **cannot** be emailed. Both the UI and backend controller explicitly verify `$report->isApproved()` before dispatching.
- Live verified with Gmail SMTP using a 16-character Google App Password.

---

## 🧮 Numerology Engine Logic

### Pythagorean Letter Gematria Table
| 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 |
|---|---|---|---|---|---|---|---|---|
| A | B | C | D | E | F | G | H | I |
| J | K | L | M | N | O | P | Q | R |
| S | T | U | V | W | X | Y | Z |   |

### Sample Calculation (Arun Kumar & Priya Raman)
- **Arun Kumar (DOB: 12-06-1992):**
  - **Life Path:** `1 + 2 + 0 + 6 + 1 + 9 + 9 + 2 = 30 -> 3 + 0 = 3`
  - **Destiny:** `A(1) + R(9) + U(3) + N(5) = 18 -> 9`; `K(2) + U(3) + M(4) + A(1) + R(9) = 19 -> 10 -> 1`. Total: `9 + 1 = 10 -> 1`
  - **Soul Urge (Vowels A, U, U, A):** `(1 + 3) + (3 + 1) = 8`
  - **Personality (Consonants R, N, K, M, R):** `(9 + 5) + (2 + 4 + 9) = 14 + 15 = 29 -> 11 -> 2`
- **Compatibility Score:** Harmonic combination of all 4 number pairs yielding `78%`.

---

## 👥 Hiring Team & Reviewer Evaluation Guide

Follow these steps to inspect and verify the application:

### Step 1: Start the Local Server
Ensure XAMPP MySQL is running. In your project directory:
```powershell
php artisan serve
```
Open your browser at: **`http://localhost:8000`**

---

### Step 2: Test Bilingual Localization (English / தமிழ்)
1. On the top navigation bar, click **தமிழ்**.
2. Notice the entire interface (navigation, headings, feature cards, numerology descriptions) switches seamlessly to Tamil.
3. Click **English** to switch back anytime.

---

### Step 3: Test the Complete End-to-End User Flow

#### A. Login as a User:
- Click **Login** and enter:
  - **Email:** `anandhi@gmail.com`
  - **Password:** `anandhi123`
- You will be redirected to the **User Dashboard** (`/dashboard`).

#### B. Create a Compatibility Report:
1. Click **Create New Report** (or go to `http://localhost:8000/reports/create`).
2. Notice clean placeholder hints (`e.g. Arun`, `e.g. Priya`) without pre-filled values.
3. Enter details for two people (or use your own names and dates of birth).
4. Click **Calculate Compatibility**.

#### C. Preview & Save:
1. The **Compatibility Result** page displays:
   - Profile badges with avatars
   - Compatibility percentage (e.g. `78%`)
   - Comparative 4-number matrix table (Life Path, Destiny, Soul, Personality)
   - Interpretation summary in English and Tamil
2. Click **Save Report**.
3. Notice the report status is **`Pending`** with message: *"Awaiting administrator review. Once approved, the email option will be activated."*
4. Notice the **Email button is NOT available** yet (verifying the requirement: *"Only approved reports can be sent in email"*).

---

### Step 4: Test the Admin Approval Flow

#### A. Switch to Admin:
1. Click the profile avatar on the top right ➔ **Logout**.
2. Click **Login** and enter Admin credentials:
  - **Email:** `admin@gmail.com`
  - **Password:** `admin123`
3. Notice you are automatically redirected to the **Admin Portal** (`/admin/dashboard`).

#### B. Review and Approve Report:
1. Click **All Reports** (or go to `http://localhost:8000/admin/reports`).
2. Notice the newly submitted report has a yellow **Pending** badge.
3. You have two options:
   - **Click "Approve" (Green button):** Approves the report so the user can now email it themselves.
   - **Click the Eye icon ➔ "Approve & Send Email":** Approves and immediately sends the email with PDF to the user's email address!
4. Click **Approve**. The badge turns green (**Approved**).

---

### Step 5: Verify the Email Gate Unlocks for the User

1. Logout from Admin and log back in as the user (`anandhi@gmail.com` / `anandhi123`).
2. Go to **My Reports** (`http://localhost:8000/reports`).
3. Notice the **Email icon** is now active (unlocked)!
4. Click the **Email icon** or open the report and click **"Send to My Email"**.
5. A green success alert appears: *"Report approved and email sent with PDF attachment!"*

---

### Step 6: Test Single-Page PDF Generation

1. On any report, click **Download** or **View Full PDF**.
2. Notice:
   - It renders on **exactly 1 page** (A4 Portrait).
   - Auspicious gold double-border framing.
   - All Tamil text (if locale is Tamil) renders with clear glyphs using embedded **Nirmala UI** font, with no boxes or broken characters.
   - Opens smoothly on both desktop and mobile browsers.

---

## 🔑 Demo Credentials

| Role | Email | Password | Access Area |
|---|---|---|---|
| **Administrator** | `admin@gmail.com` | `admin123` | Full Admin Portal (`/admin/dashboard`, `/admin/reports`, `/admin/users`) |
| **Demo User 1** | `anandhi@gmail.com` | `anandhi123` | User Portal (`/dashboard`, `/reports/create`, `/reports`) |
| **Demo User 2** | `abe@gmail.com` | `abe123` | User Portal |

*(You can also click **Sign Up** on the home page to register your own account).*

---

## 🧪 Automated Testing

The codebase includes an automated test suite verifying business logic, authorization, and PDF workflows.

Run all tests via Artisan:
```bash
php artisan test
```

### Test Suite Summary:
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
✓ non approved report cannot be sent via email (server-side security gate)
✓ approved report can be sent via email
✓ admin can approve and send email directly
✓ pdf endpoint generates valid pdf for owner

Tests: 15 passed (36 assertions)
```

---

## 📁 Folder Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── AdminReportController.php   # Admin dashboard, approve/reject/email
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php          # Register, Login, role-based redirects
│   │   │   ├── DashboardController.php         # User dashboard & metrics
│   │   │   ├── HomeController.php              # Public landing page
│   │   │   ├── LocaleController.php            # Dynamic English/Tamil switcher
│   │   │   └── ReportController.php            # Calculation, Result, PDF stream & email
│   │   └── Middleware/
│   │       ├── EnsureAdmin.php                 # Role-based admin access control
│   │       └── SetLocale.php                   # Session-based locale detector
│   ├── Mail/
│   │   └── ReportMail.php                      # Mailable with attached PDF
│   ├── Models/
│   │   ├── Report.php                          # Report model, accessors & status scopes
│   │   └── User.php                            # User model with isAdmin() helper
│   └── Services/
│       └── NumerologyService.php               # Core Pythagorean & Vedic calculation engine
├── config/
│   ├── dompdf.php                              # Dompdf font subsetting & remote configs
│   └── mail.php                                # SMTP mailer configuration
├── lang/
│   ├── en/messages.php                         # Full English translations
│   └── ta/messages.php                         # Full Tamil translations
├── public/
│   └── fonts/
│       ├── Nirmala.ttf                         # Nirmala UI Regular (Tamil Unicode)
│       └── NirmalaB.ttf                        # Nirmala UI Bold (Tamil Unicode)
├── resources/views/
│   ├── admin/
│   │   ├── dashboard.blade.php                 # Admin dashboard with status tabs
│   │   ├── show.blade.php                      # Admin report review & approve modal
│   │   └── users.blade.php                     # User directory
│   ├── auth/
│   │   ├── login.blade.php                     # Login view with demo hints
│   │   └── register.blade.php                  # Signup view
│   ├── emails/
│   │   └── report.blade.php                    # Beautiful HTML email template
│   ├── layouts/
│   │   └── app.blade.php                       # Main responsive layout with language switch
│   └── reports/
│       ├── create.blade.php                    # 2-profile comparative input form
│       ├── index.blade.php                     # User's My Reports list
│       ├── pdf.blade.php                       # Single-page A4 PDF template with gold frame
│       └── result.blade.php                    # Compatibility calculation results
└── tests/
    ├── Feature/ReportWorkflowTest.php          # 8 End-to-end integration feature tests
    └── Unit/NumerologyServiceTest.php          # 5 Unit tests for numerology calculations
```

---

## 🏆 Summary Checklist

| Requirement | Status | Implementation Details |
|---|---|---|
| Compare 2 profiles (DOB, First & Last Name) | ✅ Complete | Side-by-side comparative form with regex validation |
| Pythagorean Numerology algorithm | ✅ Complete | 4 core numbers (Life Path, Destiny, Soul, Personality) + percentage score |
| User Portal (Signup, Login, Dashboard) | ✅ Complete | Custom auth, role redirection, summary metrics, My Reports |
| Admin Portal (Role-based access) | ✅ Complete | `EnsureAdmin` middleware, approve, reject, approve & email |
| Email gate: Only approved reports can be emailed | ✅ Complete | Server-side gate in `ReportController` & `AdminReportController` |
| PDF Report Generation | ✅ Complete | Dompdf, **single-page A4**, auspicious gold frame |
| Mobile & Desktop PDF Compatibility | ✅ Complete | Responsive viewport & print-safe layout |
| Tamil & English Bilingual Support | ✅ Complete | Complete i18n switcher across all views and PDF report |
| Embedded Tamil Font in PDF | ✅ Complete | TrueType Nirmala UI font embedded; no boxes/squares |
| SMTP Email Delivery | ✅ Complete | Tested & verified with live Gmail SMTP + PDF attachment |
| Automated Test Suite | ✅ Complete | 15 tests, 36 assertions passing |
