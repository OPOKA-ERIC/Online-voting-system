<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">🗳️ VoteSecure — Online Voting System</h1>

<p align="center">
  A secure, transparent, and modern web-based voting platform built with Laravel 11.
  <br>
  Designed for universities, student councils, and organizations.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=flat-square&logo=laravel" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Database-SQLite-lightgrey?style=flat-square&logo=sqlite" alt="SQLite">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-purple?style=flat-square&logo=bootstrap" alt="Bootstrap 5">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="MIT License">
</p>

---

## 📋 Table of Contents

- [About the Project](#about-the-project)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [System Architecture](#system-architecture)
- [Database Structure](#database-structure)
- [User Roles](#user-roles)
- [Installation & Setup](#installation--setup)
- [Usage Guide](#usage-guide)
- [Project Structure](#project-structure)
- [Team](#team)

---

## About the Project

VoteSecure is a full-stack online voting system that allows administrators to create
elections, manage candidates, and upload voter lists. Registered voters can log in,
verify their identity, cast votes across multiple positions, and view results once
an election has officially ended.

The system is built as a final exam project for the **Emerging Web Technologies** course
(BSSE2) and demonstrates a complete MVC web application using the Laravel framework.

---

## Features

### Admin Panel
- ✅ Secure admin dashboard with live stats (elections, candidates, voters, votes)
- ✅ Full Elections CRUD — create, view, edit, delete elections with positions
- ✅ Full Candidates CRUD — add candidates with photo uploads and biographies
- ✅ Upload voter lists via CSV or Excel — system auto-detects the unique identifier column
- ✅ View per-election results, voter turnout, and poll breakdowns by position
- ✅ Election status automatically computed (Upcoming / Active / Closed) based on dates

### Voter Portal
- ✅ Voter dashboard showing active and past elections separately
- ✅ Identity verification before voting — voter must match their registered unique ID
- ✅ Vote across multiple positions per election with confirmation modal
- ✅ Voting progress bar showing how many positions have been voted
- ✅ Vote receipt / confirmation page after completing all positions
- ✅ Results locked during active elections — only visible after election ends
- ✅ Past elections section with View Results button

### Security
- ✅ Role-based access control (admin vs voter middleware)
- ✅ CSRF protection on all forms
- ✅ Database-level unique constraint prevents double voting
- ✅ Session-based verification prevents voting without identity check
- ✅ Name cross-check against registered voter list
- ✅ Homepage never shows live/ongoing election results

---

## Technology Stack

| Layer          | Technology                          |
|----------------|-------------------------------------|
| Backend        | PHP 8.2, Laravel 11                 |
| Database       | SQLite                              |
| Frontend       | Bootstrap 5.3, Tailwind CSS         |
| Icons          | Bootstrap Icons 1.11                |
| Charts         | Chart.js                            |
| File Parsing   | Maatwebsite/Laravel-Excel           |
| Authentication | Laravel Breeze (session-based)      |
| File Storage   | Laravel Storage (local public disk) |

---

## System Architecture

The system follows the **MVC (Model-View-Controller)** pattern:

```
Browser Request
      ↓
routes/web.php          — maps URLs to controllers
      ↓
Middleware              — AdminMiddleware / VoterMiddleware / auth
      ↓
Controllers             — business logic
      ↓
Models                  — database interaction
      ↓
Views (Blade)           — HTML output returned to browser
```

### Controllers
| Controller                    | Responsibility                              |
|-------------------------------|---------------------------------------------|
| AdminController               | Admin dashboard stats                       |
| ElectionController            | Elections CRUD                              |
| CandidateController           | Candidates CRUD + photo uploads             |
| VoterUploadController         | CSV/Excel voter list import                 |
| VoteController                | Voter dashboard + vote casting              |
| VoterVerificationController   | Identity verification before voting         |
| ResultController              | Election results (post-election only)       |
| ProfileController             | User profile management                     |

---

## Database Structure

```
users
 ├── id, name, email, password
 ├── role (admin | voter)
 └── election_id (FK)

elections
 ├── id, title, description
 ├── start_date, end_date
 ├── voters_file, unique_column
 └── voters_data (JSON)

positions
 ├── id, name
 └── election_id (FK → elections)

candidates
 ├── id, name, photo, bio
 ├── election_id (FK → elections)
 └── position_id (FK → positions)

votes
 ├── id, voted_at
 ├── user_id (FK → users)
 ├── election_id (FK → elections)
 ├── candidate_id (FK → candidates)
 ├── position_id (FK → positions)
 └── UNIQUE (user_id, election_id, position_id)
```

---

## User Roles

### Admin
- Accesses the system at `/admin`
- Can create and manage elections, candidates, and voter lists
- Can view results at any time

### Voter
- Accesses the system at `/voter`
- Must verify identity before voting
- Can only vote once per position per election
- Can only view results after the election has ended

---

## Installation & Setup

### Requirements
- PHP >= 8.2
- Composer
- Node.js & NPM

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/OPOKA-ERIC/Online-voting-system.git
cd Online-voting-system

# 2. Install PHP dependencies
composer install

# 3. Install frontend dependencies
npm install && npm run build

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Run database migrations
php artisan migrate

# 7. Create storage symlink for uploaded files
php artisan storage:link

# 8. Start the development server
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

### Default Admin Account
After running migrations and seeding, log in with the admin credentials
set up during the initial database seed.

---

## Usage Guide

### As Admin

1. Log in and you will be redirected to `/admin/dashboard`
2. Go to **Elections** → **New Election** to create an election with positions
3. Go to **Candidates** → **Add Candidate** to add candidates and assign them to positions
4. Go to **Voters** → **Upload Voters** to upload a CSV or Excel voter list
5. The system auto-detects the unique identifier column (e.g. Student Number)
6. Once the election `end_date` passes, results are automatically available to voters

### As Voter

1. Log in and you will be redirected to `/voter` (dashboard)
2. Active elections appear under **Active Elections**
3. Click **Vote Now** on an election
4. Enter your unique identifier (e.g. Student Number) to verify your identity
5. Select your preferred candidate for each position and confirm your vote
6. After voting for all positions you will receive a confirmation receipt
7. Once the election ends, the **View Results** button becomes available under **Past Elections**

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/         — all controller files
│   └── Middleware/          — AdminMiddleware, VoterMiddleware
├── Models/                  — Election, Candidate, Position, Vote, User

database/
├── migrations/              — table creation scripts
└── database.sqlite          — SQLite database file

resources/views/
├── layouts/                 — admin.blade.php, app.blade.php
├── admin/                   — dashboard, elections, candidates, voters
├── voter/                   — dashboard, verify, candidates, confirmation, results
└── welcome.blade.php        — public homepage

routes/
└── web.php                  — all application routes

storage/app/public/
├── candidates/              — uploaded candidate photos
└── voters_files/            — uploaded voter list files
```

---

## Team

| Name         | Role                                              |
|--------------|---------------------------------------------------|
| Ojok Erick   | Admin Panel — Elections & Candidates CRUD         |
| Opoka Eric   | Initial setup, authentication, database schema    |

**Course:** Emerging Web Technologies — BSSE2  
**Institution:** Uganda Christian University  

---

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
