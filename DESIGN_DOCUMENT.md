# VoteSecure — Online Voting System
## System Design Document
**Course:** Emerging Web Technologies  
**Project:** Online Voting System  
**Framework:** Laravel 11 (PHP)  
**Database:** SQLite  
**Frontend:** Bootstrap 5 + Tailwind CSS  

---

## 1. SYSTEM OVERVIEW

VoteSecure is a web-based online voting platform that allows administrators to create
and manage elections, register candidates, and upload voter lists. Registered voters
can log in, verify their identity, cast votes for candidates across multiple positions,
and view results once an election has ended.

The system enforces strict rules:
- Only admins can manage elections and candidates
- Only verified voters can cast votes
- Each voter can only vote once per position per election
- Results are hidden from everyone until the election officially ends

---

## 2. SYSTEM ARCHITECTURE

The system follows the MVC (Model-View-Controller) architectural pattern provided
by the Laravel framework.

```
┌─────────────────────────────────────────────────────────┐
│                        BROWSER                          │
│              (Voter or Admin using the app)             │
└─────────────────────┬───────────────────────────────────┘
                      │  HTTP Request (GET / POST / PUT / DELETE)
                      ▼
┌─────────────────────────────────────────────────────────┐
│                    routes/web.php                       │
│         Maps every URL to a Controller method           │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                   MIDDLEWARE LAYER                      │
│   AdminMiddleware — checks role === 'admin'             │
│   VoterMiddleware — checks role === 'voter'             │
│   auth            — checks user is logged in            │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                  CONTROLLER LAYER                       │
│  AdminController        — dashboard stats               │
│  ElectionController     — elections CRUD                │
│  CandidateController    — candidates CRUD + photos      │
│  VoterUploadController  — CSV/Excel voter import        │
│  VoteController         — voter dashboard + casting     │
│  VoterVerificationController — identity verification   │
│  ResultController       — election results              │
│  ProfileController      — user profile management      │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                    MODEL LAYER                          │
│  Election   — elections table                           │
│  Candidate  — candidates table                          │
│  Position   — positions table                           │
│  Vote       — votes table                               │
│  User       — users table                               │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                     DATABASE                            │
│              SQLite (database/database.sqlite)          │
└─────────────────────────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                    VIEW LAYER                           │
│  resources/views/                                       │
│  ├── layouts/admin.blade.php  — admin sidebar layout   │
│  ├── layouts/app.blade.php    — voter layout            │
│  ├── admin/                   — all admin pages         │
│  ├── voter/                   — all voter pages         │
│  └── welcome.blade.php        — public homepage         │
└─────────────────────────────────────────────────────────┘
```

---

## 3. DATABASE DESIGN

### 3.1 Entity Relationship Diagram

```
USERS                    ELECTIONS
──────                   ─────────
id (PK)                  id (PK)
name                     title
email (unique)           description
password                 start_date
role (admin|voter)       end_date
election_id (FK) ───┐    voters_file
is_active            │    unique_column
                     │    voters_data (JSON)
                     │
                     └──► ELECTIONS.id


POSITIONS                CANDIDATES
─────────                ──────────
id (PK)                  id (PK)
election_id (FK) ──────► ELECTIONS.id
name                     election_id (FK) ──► ELECTIONS.id
                         position_id (FK) ──► POSITIONS.id
                         name
                         photo
                         bio


VOTES
─────
id (PK)
user_id (FK) ──────────► USERS.id
election_id (FK) ──────► ELECTIONS.id
candidate_id (FK) ─────► CANDIDATES.id
position_id (FK) ──────► POSITIONS.id
voted_at
UNIQUE (user_id, election_id, position_id)
```

### 3.2 Table Descriptions

#### users
| Column           | Type      | Description                              |
|------------------|-----------|------------------------------------------|
| id               | integer   | Primary key, auto-increment              |
| name             | string    | Full name of the user                    |
| email            | string    | Unique email address used for login      |
| password         | string    | Bcrypt hashed password                   |
| role             | enum      | Either 'admin' or 'voter'                |
| election_id      | integer   | FK — which election this voter belongs to|
| is_active        | boolean   | Whether the account is active            |
| created_at       | timestamp | When the account was created             |

#### elections
| Column           | Type      | Description                              |
|------------------|-----------|------------------------------------------|
| id               | integer   | Primary key, auto-increment              |
| title            | string    | Name of the election                     |
| description      | text      | Optional description                     |
| start_date       | datetime  | When voting opens                        |
| end_date         | datetime  | When voting closes                       |
| voters_file      | string    | Path to uploaded voter list file         |
| unique_column    | string    | Column name used for voter verification  |
| voters_data      | JSON      | Full parsed voter list stored as JSON    |
| created_at       | timestamp | When the election was created            |

#### positions
| Column           | Type      | Description                              |
|------------------|-----------|------------------------------------------|
| id               | integer   | Primary key, auto-increment              |
| election_id      | integer   | FK — which election this position is for |
| name             | string    | Position title e.g. "President"          |
| created_at       | timestamp | When the position was created            |

#### candidates
| Column           | Type      | Description                              |
|------------------|-----------|------------------------------------------|
| id               | integer   | Primary key, auto-increment              |
| election_id      | integer   | FK — which election this candidate is in |
| position_id      | integer   | FK — which position they are running for |
| name             | string    | Candidate's full name                    |
| photo            | string    | File path to uploaded photo              |
| bio              | text      | Optional biography                       |
| created_at       | timestamp | When the candidate was added             |

#### votes
| Column           | Type      | Description                              |
|------------------|-----------|------------------------------------------|
| id               | integer   | Primary key, auto-increment              |
| user_id          | integer   | FK — who cast this vote                  |
| election_id      | integer   | FK — which election                      |
| candidate_id     | integer   | FK — who they voted for                  |
| position_id      | integer   | FK — which position this vote is for     |
| voted_at         | timestamp | Exact time the vote was cast             |
| UNIQUE           | constraint| (user_id, election_id, position_id) — prevents double voting at DB level |

---

## 4. USER ROLES & PERMISSIONS

| Feature                        | Admin | Voter |
|-------------------------------|-------|-------|
| View public homepage           | ✓     | ✓     |
| Login / Register               | ✓     | ✓     |
| View admin dashboard           | ✓     | ✗     |
| Create / Edit / Delete elections| ✓    | ✗     |
| Create / Edit / Delete candidates| ✓  | ✗     |
| Upload voter lists             | ✓     | ✗     |
| View voter dashboard           | ✗     | ✓     |
| Verify identity before voting  | ✗     | ✓     |
| Cast votes                     | ✗     | ✓     |
| View results (after election ends)| ✗  | ✓     |
| View results (admin anytime)   | ✓     | ✗     |

---

## 5. URL STRUCTURE (ROUTES)

### Public Routes
| Method | URL          | Description                    |
|--------|--------------|--------------------------------|
| GET    | /            | Public homepage with live stats|
| GET    | /login       | Login page                     |
| GET    | /register    | Registration page              |
| GET    | /features    | Static features page           |
| GET    | /about       | Static about page              |
| GET    | /dashboard   | Smart redirect by role         |

### Admin Routes (requires auth + admin role)
| Method | URL                          | Controller Method              |
|--------|------------------------------|--------------------------------|
| GET    | /admin                       | AdminController@dashboard      |
| GET    | /admin/elections             | ElectionController@index       |
| GET    | /admin/elections/create      | ElectionController@create      |
| POST   | /admin/elections             | ElectionController@store       |
| GET    | /admin/elections/{id}        | ElectionController@show        |
| GET    | /admin/elections/{id}/edit   | ElectionController@edit        |
| PUT    | /admin/elections/{id}        | ElectionController@update      |
| DELETE | /admin/elections/{id}        | ElectionController@destroy     |
| GET    | /admin/candidates            | CandidateController@index      |
| GET    | /admin/candidates/create     | CandidateController@create     |
| POST   | /admin/candidates            | CandidateController@store      |
| GET    | /admin/candidates/{id}/edit  | CandidateController@edit       |
| PUT    | /admin/candidates/{id}       | CandidateController@update     |
| DELETE | /admin/candidates/{id}       | CandidateController@destroy    |
| GET    | /admin/voters/upload         | VoterUploadController@create   |
| POST   | /admin/voters/upload         | VoterUploadController@store    |

### Voter Routes (requires auth + voter role)
| Method | URL                          | Controller Method                    |
|--------|------------------------------|--------------------------------------|
| GET    | /voter                       | VoteController@index                 |
| GET    | /voter/verify/{election}     | VoterVerificationController@show     |
| POST   | /voter/verify/{election}     | VoterVerificationController@verify   |
| GET    | /voter/election/{id}         | VoteController@show                  |
| POST   | /voter/vote                  | VoteController@store                 |
| GET    | /voter/confirmation          | VoteController@confirmation          |
| GET    | /voter/results/{id}          | ResultController@show                |

---

## 6. CONTROLLER DESCRIPTIONS

### AdminController
**File:** app/Http/Controllers/AdminController.php  
**Purpose:** Handles the admin dashboard  
**Methods:**
- `dashboard()` — Queries counts of elections, candidates, voters, and votes.
  Also fetches the 5 most recent elections with candidate counts.
  Returns all data to admin/dashboard.blade.php.

### ElectionController
**File:** app/Http/Controllers/ElectionController.php  
**Purpose:** Full CRUD management of elections  
**Methods:**
- `index()` — Lists all elections
- `create()` — Shows blank election form
- `store()` — Validates and saves new election + positions
- `show()` — Shows detailed election view with voters, results, positions
- `edit()` — Shows pre-filled edit form
- `update()` — Saves changes, syncs positions (create/update/delete)
- `destroy()` — Deletes election and all related data (cascade)

### CandidateController
**File:** app/Http/Controllers/CandidateController.php  
**Purpose:** Full CRUD management of candidates including photo uploads  
**Methods:**
- `index()` — Lists all candidates with their election and position
- `create()` — Shows form with election/position dropdowns
- `store()` — Validates, uploads photo to storage, saves candidate
- `edit()` — Shows pre-filled form
- `update()` — Updates candidate, replaces photo if new one uploaded
- `destroy()` — Deletes candidate record

### VoterUploadController
**File:** app/Http/Controllers/VoterUploadController.php  
**Purpose:** Handles CSV/Excel voter list uploads  
**Methods:**
- `create()` — Shows upload form with election dropdown
- `store()` — Parses CSV or Excel file, auto-detects unique identifier
  column, stores voter data as JSON on the election, creates/updates
  User accounts for each voter row

### VoterVerificationController
**File:** app/Http/Controllers/VoterVerificationController.php  
**Purpose:** Verifies voter identity before allowing them to vote  
**Methods:**
- `show()` — Checks election is active, checks voter hasn't already voted,
  shows verification form
- `verify()` — Matches submitted value against voters_data JSON,
  cross-checks name against logged-in user's name,
  stores verification in session if passed

### VoteController
**File:** app/Http/Controllers/VoteController.php  
**Purpose:** Manages the voter dashboard and vote casting  
**Methods:**
- `index()` — Shows active elections and past elections with vote progress
- `show()` — Shows candidates for a specific election (requires verification)
- `store()` — Validates and saves a vote, checks election is active,
  checks session verification, prevents double voting,
  redirects to confirmation when all positions voted
- `confirmation()` — Shows voting receipt page

### ResultController
**File:** app/Http/Controllers/ResultController.php  
**Purpose:** Displays election results  
**Methods:**
- `show()` — Blocks access if election is still ongoing,
  groups results by position with vote counts and percentages,
  highlights the voter's own choices

---

## 7. MODEL DESCRIPTIONS

### Election Model
**File:** app/Models/Election.php  
**Table:** elections  
**Key Features:**
- `$fillable` — whitelists safe columns for mass assignment
- `$casts` — converts start_date/end_date to Carbon datetime objects,
  voters_data JSON string to PHP array automatically
- `getStatusAttribute()` — computed property returning 'active',
  'upcoming', or 'closed' based on current time vs start/end dates
- Relationships: hasMany Candidates, hasMany Positions, hasMany Votes,
  hasMany Users (voters)

### Candidate Model
**File:** app/Models/Candidate.php  
**Table:** candidates  
**Key Features:**
- `$fillable` — election_id, position_id, name, photo, bio
- Relationships: belongsTo Election, belongsTo Position, hasMany Votes

### Position Model
**File:** app/Models/Position.php  
**Table:** positions  
**Key Features:**
- `$fillable` — election_id, name
- Relationships: belongsTo Election, hasMany Candidates

### Vote Model
**File:** app/Models/Vote.php  
**Table:** votes  
**Key Features:**
- `$fillable` — user_id, election_id, candidate_id, position_id
- Database-level UNIQUE constraint on (user_id, election_id, position_id)
  prevents double voting even if application logic is bypassed
- Relationships: belongsTo User, belongsTo Election,
  belongsTo Candidate, belongsTo Position

### User Model
**File:** app/Models/User.php  
**Table:** users  
**Key Features:**
- Standard Laravel authentication model
- role column (enum: admin | voter) controls access throughout the system
- election_id links a voter to their specific election

---

## 8. MIDDLEWARE DESCRIPTIONS

### AdminMiddleware
**File:** app/Http/Middleware/AdminMiddleware.php  
**Applied to:** All /admin/* routes  
**Logic:** Checks Auth::check() AND Auth::user()->role === 'admin'.
If either fails, redirects to /dashboard with 'Access denied' error.

### VoterMiddleware
**File:** app/Http/Middleware/VoterMiddleware.php  
**Applied to:** All /voter/* routes  
**Logic:** Checks Auth::check() AND Auth::user()->role === 'voter'.
If either fails, redirects to /dashboard with 'Access denied' error.

### auth (Laravel built-in)
**Applied to:** All protected routes  
**Logic:** Checks if user is logged in. If not, redirects to /login.
Runs before AdminMiddleware and VoterMiddleware.

---

## 9. KEY SYSTEM FLOWS

### 9.1 Admin Creates an Election
```
1. Admin visits /admin/elections/create
2. AdminMiddleware checks role === 'admin' ✓
3. ElectionController@create() returns blank form
4. Admin fills title, dates, positions and submits
5. POST /admin/elections → ElectionController@store()
6. Validation runs — stops here if any field invalid
7. Election::create() saves to elections table
8. Loop creates each Position linked to election
9. Redirect to /admin/elections with success message
```

### 9.2 Admin Uploads Voter List
```
1. Admin visits /admin/voters/upload
2. Admin selects election and uploads CSV/Excel file
3. POST → VoterUploadController@store()
4. File is parsed (CSV or Excel handled separately)
5. System auto-detects the unique identifier column
6. voters_data saved as JSON on the election record
7. User accounts created/updated for each voter row
8. Admin sees success message with detected identifier
```

### 9.3 Voter Casts a Vote
```
1. Voter logs in → redirected to /voter (dashboard)
2. VoterMiddleware checks role === 'voter' ✓
3. VoteController@index() shows active + past elections
4. Voter clicks "Vote Now" on an active election
5. GET /voter/verify/{id} → VoterVerificationController@show()
   - Checks election is active
   - Checks voter hasn't already voted
   - Shows verification form
6. Voter submits their unique ID (e.g. student number)
7. POST /voter/verify/{id} → VoterVerificationController@verify()
   - Searches voters_data JSON for matching value
   - Cross-checks name against logged-in user name
   - Stores verified_election_{id} = true in session
8. Redirect to /voter/election/{id} → VoteController@show()
9. Voter sees candidates grouped by position
10. Voter selects a candidate and clicks "Cast Vote"
11. Confirmation modal appears — voter confirms
12. POST /voter/vote → VoteController@store()
    - Checks election still active
    - Checks session verification exists
    - Checks no existing vote for this position
    - Vote::create() saves to votes table
13. If all positions voted → redirect to confirmation page
    If more positions remain → redirect back to vote page
```

### 9.4 Voter Views Results
```
1. Voter visits /voter/results/{id}
2. ResultController@show() checks now() > election->end_date
   - If election still running:
     * If voter already voted → "You have already voted.
       Please wait for results when the election closes."
     * If voter hasn't voted → "Results will be available
       once the election ends."
   - If election ended → proceed
3. Results grouped by position with vote counts,
   percentages, bar charts, and voter's own choices highlighted
```

---

## 10. SECURITY MEASURES

| Threat                    | Protection                                              |
|---------------------------|---------------------------------------------------------|
| Unauthorized admin access | AdminMiddleware checks role on every admin request      |
| Unauthorized voter access | VoterMiddleware checks role on every voter request      |
| Double voting             | DB UNIQUE constraint + application-level check          |
| Voting without verifying  | Session check in VoteController@store()                 |
| Fake voter verification   | Name cross-check against registered voters list         |
| Mass assignment attacks   | $fillable whitelist on every model                      |
| CSRF attacks              | @csrf token required on every form                      |
| Invalid form data         | $request->validate() on every store/update method       |
| Viewing live results      | ResultController blocks access until end_date passes    |
| Homepage showing live data| web.php only passes closed election data to homepage    |
| File upload abuse         | Validation: image type, max size, allowed extensions    |

---

## 11. FILE & FOLDER STRUCTURE

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php          ← dashboard stats
│   │   ├── ElectionController.php       ← elections CRUD
│   │   ├── CandidateController.php      ← candidates CRUD
│   │   ├── VoterUploadController.php    ← voter list import
│   │   ├── VoteController.php           ← voter dashboard + voting
│   │   ├── VoterVerificationController.php ← identity check
│   │   ├── ResultController.php         ← results display
│   │   └── ProfileController.php        ← user profile
│   └── Middleware/
│       ├── AdminMiddleware.php          ← admin access guard
│       └── VoterMiddleware.php          ← voter access guard
├── Models/
│   ├── Election.php                     ← elections table
│   ├── Candidate.php                    ← candidates table
│   ├── Position.php                     ← positions table
│   ├── Vote.php                         ← votes table
│   └── User.php                         ← users table

database/
├── migrations/                          ← table creation scripts
└── database.sqlite                      ← the actual database file

resources/views/
├── layouts/
│   ├── admin.blade.php                  ← admin sidebar + navbar
│   └── app.blade.php                    ← voter layout
├── admin/
│   ├── dashboard.blade.php              ← admin home
│   ├── elections/
│   │   ├── index.blade.php              ← elections list
│   │   ├── create.blade.php             ← create form
│   │   ├── edit.blade.php               ← edit form
│   │   └── show.blade.php               ← election detail
│   ├── candidates/
│   │   ├── index.blade.php              ← candidates list
│   │   ├── create.blade.php             ← create form
│   │   └── edit.blade.php               ← edit form
│   └── voters/
│       └── upload.blade.php             ← voter upload form
├── voter/
│   ├── dashboard.blade.php              ← voter home
│   ├── verify.blade.php                 ← identity verification
│   ├── candidates.blade.php             ← voting page
│   ├── confirmation.blade.php           ← vote receipt
│   └── results.blade.php                ← election results
└── welcome.blade.php                    ← public homepage

routes/
└── web.php                              ← all URL definitions

storage/app/public/
├── candidates/                          ← uploaded candidate photos
└── voters_files/                        ← uploaded voter list files
```

---

## 12. TEAM RESPONSIBILITIES

| Member       | Responsibility                                          |
|--------------|---------------------------------------------------------|
| Ojok Erick   | Admin Panel — Elections & Candidates CRUD               |
| Opoka Eric   | Initial Laravel setup, authentication, database schema  |
| Others       | Voter verification, voting flow, results, voter upload  |

---

## 13. TECHNOLOGY STACK

| Layer          | Technology                                    |
|----------------|-----------------------------------------------|
| Backend        | PHP 8.2, Laravel 11                           |
| Database       | SQLite                                        |
| Frontend       | Bootstrap 5.3, Tailwind CSS, Bootstrap Icons  |
| Charts         | Chart.js (results page)                       |
| File Parsing   | Maatwebsite/Laravel-Excel (CSV + Excel)       |
| Authentication | Laravel Breeze (session-based)                |
| File Storage   | Laravel Storage (local public disk)           |
| Dev Server     | php artisan serve                             |

---

*Document generated from actual source code — VoteSecure Online Voting System*
