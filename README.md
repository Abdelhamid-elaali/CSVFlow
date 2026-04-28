# 🌊 CSVFlow — Modern CSV Data Management

![CSVFlow Hero](file:///C:/Users/LBOSS/.gemini/antigravity/brain/83f3b9c0-6b22-487d-9909-5f4c2ddf3cb1/csvflow_hero_1777067949102.png)

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

**CSVFlow** is a premium, high-performance web application designed to streamline the process of importing, verifying, and managing user data from CSV files. Built with a focus on **User Experience** and **Visual Excellence**, it features a stunning glassmorphism interface and robust background processing.

---

## ✨ Key Features

- 🚀 **Seamless CSV Upload**: Instant file ingestion with support for various CSV formats.
- ⚙️ **Background Processing**: Uses Laravel Queues for high-concurrency import processing without blocking the UI.
- 🛡️ **Data Verification**: Interactive staging area to review, edit, or reject imported records before final confirmation.
- 🛠️ **Bulk Actions**: Efficiently confirm or delete multiple records with a single click.
- 💎 **Premium UI/UX**: Modern dark mode aesthetic with vibrant gradients, glassmorphism, and smooth micro-animations.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Frontend**: Blade, Vanilla JavaScript, Tailwind CSS
- **Database**: MySQL / PostgreSQL / SQLite
- **Job Runner**: Laravel Queue (Redis / Database)
- **Bundler**: Vite

---

## 🚀 Installation & Setup

Follow these steps to get your local development environment running:

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/CSVFlow.git
cd CSVFlow
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```
*Configure your database settings in the `.env` file.*

### 4. Database Migrations
```bash
php artisan migrate
```

### 5. Start the Application
Open two terminal windows:
**Terminal 1 (Vite Dev Server):**
```bash
npm run dev
```
**Terminal 2 (Local Server):**
```bash
php artisan serve
```

---

## 📖 Usage Guide

1. **Upload**: Navigate to the home page and drag & drop your CSV file.
2. **Verify**: Once processed, go to the **Verify** page to see your pending records.
3. **Manage**: Use the checkboxes to select records. Click **Confirm Selected** to save them or **Delete Selected** to remove them.
4. **Individual Actions**: Use the trash icon in the actions column for quick per-row deletion.

---

## 🎨 Design Philosophy

CSVFlow follows modern design principles to ensure a premium feel:
- **Glassmorphism**: Layered transparency and blur effects for depth.
- **Dynamic Feedback**: Interactive hover states and loading pulses.
- **Typography**: Clean, readable **Inter** font family for professional clarity.

---

## 📄 License

This project is open-source and licensed under the [MIT License](LICENSE).

---

<p align="center">
  Developed with LBOSS by the CSVFlow Team
</p>
