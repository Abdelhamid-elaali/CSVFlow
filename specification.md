# CSVFlow - Project Specification

## Overview

**CSVFlow** is a Laravel 12 web application for importing, processing, and verifying CSV data containing user information. The application provides a streamlined workflow for uploading CSV files, processing them asynchronously via Laravel queues, and manually verifying imported records.

---

## Technology Stack

| Layer | Technology |
|-------|------------|
| **Framework** | Laravel 12 |
| **PHP Version** | 8.2+ |
| **Authentication** | Laravel Breeze |
| **Frontend** | Blade Templates + TailwindCSS |
| **Build Tool** | Vite |
| **Queue** | Laravel Queue (database driver) |
| **Database** | SQLite (default) |

---

## Architecture

### Directory Structure

```
CSVFlow/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/                    # Breeze authentication controllers
│   │   ├── CsvImportController.php  # Main CSV upload/verify logic
│   │   └── ProfileController.php    # User profile management
│   ├── Jobs/
│   │   └── ProcessCsvImport.php     # Background CSV processing
│   └── Models/
│       ├── ImportedUser.php         # Imported CSV data model
│       └── User.php                 # Authentication user model
├── database/migrations/
│   └── 2025_02_26_170714_create_imported_users_table.php
├── resources/views/
│   ├── csv/
│   │   ├── upload.blade.php         # CSV upload form
│   │   └── verify.blade.php         # Data verification table
│   ├── components/                  # Blade components (buttons, inputs, etc.)
│   ├── layouts/                     # App and guest layouts
│   ├── auth/                        # Authentication views
│   └── profile/                     # Profile management views
└── routes/
    ├── web.php                      # Main application routes
    └── auth.php                     # Authentication routes
```

---

## Core Features

### 1. CSV Import Workflow

The main application flow consists of four stages:

| Stage | Route | Method | Description |
|-------|-------|--------|-------------|
| **Upload Form** | `/` | GET | Display CSV upload form |
| **Process Upload** | `/csv/upload` | POST | Validate and queue CSV for processing |
| **Verify Data** | `/csv/verify` | GET | Display unverified records |
| **Confirm Records** | `/csv/confirm` | POST | Mark selected records as verified |

### 2. Authentication System

Standard Laravel Breeze authentication with:
- User registration
- Login/Logout
- Password reset
- Email verification
- Profile management (edit/delete account)

---

## Data Models

### ImportedUser

Represents CSV-imported user data.

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `first_name` | string | User's first name |
| `last_name` | string | User's last name |
| `telephone` | string | Phone number |
| `verified` | boolean | Manual verification status (default: false) |
| `created_at` | timestamp | Record creation time |
| `updated_at` | timestamp | Last update time |

### User

Standard Laravel authentication user with Breeze defaults.

---

## Background Processing

### ProcessCsvImport Job

Processes uploaded CSV files asynchronously:

1. Reads CSV from storage
2. Parses rows (expects header row)
3. Creates `ImportedUser` records for each row
4. Deletes source file after processing
5. Logs errors on failure

**Expected CSV Format:**
```csv
first_name,last_name,telephone
John,Doe,123-456-7890
Jane,Smith,098-765-4321
```

---

## Routes Summary

### Web Routes (`web.php`)

| Method | URI | Controller@Action | Name |
|--------|-----|-------------------|------|
| GET | `/` | `CsvImportController@index` | `csv.index` |
| POST | `/csv/upload` | `CsvImportController@upload` | `csv.upload` |
| GET | `/csv/verify` | `CsvImportController@verify` | `csv.verify` |
| POST | `/csv/confirm` | `CsvImportController@confirm` | `csv.confirm` |

### Auth Routes (`auth.php`)

Standard Breeze authentication routes for registration, login, password reset, email verification, and logout.

---

## Development Commands

```bash
# Start development server with all services
composer dev

# Individual services
php artisan serve          # Web server
php artisan queue:listen   # Queue worker
npm run dev               # Vite dev server

# Database
php artisan migrate        # Run migrations

# Testing
php artisan test           # Run PHPUnit tests
```

---

## Testing

### Existing Tests

Located in `tests/Feature/`:
- `Auth/` - Authentication flow tests (6 tests)
- `ProfileTest.php` - Profile management tests
- `ExampleTest.php` - Basic application test

---

## Known Areas for Improvement

1. **No CSV validation** - CSV format/content not validated before processing
2. **No progress tracking** - No way to track import job status
3. **No duplicate detection** - Same CSV can be imported multiple times
4. **No authentication on CSV routes** - Main routes are publicly accessible
5. **No pagination** - Verify page loads all unverified records at once
6. **No CSV export** - Cannot export verified data
