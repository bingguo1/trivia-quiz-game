# Trivia Quiz Game

A full-stack web application for personal trivia study and self-testing. Questions are organized into hierarchical categories (e.g. Computer Science → Python, SQL, Linux), support rich content via Markdown and LaTeX math, and are served with a cache-first architecture to minimize database round-trips.

---

## Overview

- Browse and select question categories (with subcategories)
- Quiz yourself with keyboard, swipe, and button navigation
- Answers and detail explanations render Markdown and LaTeX math
- Add and edit questions through an admin-gated interface
- Questions and category data are cached in `localStorage` — the DB is only hit on the first load or explicit refresh
- Deployed to **Google App Engine** (PHP 8.3 standard environment) backed by **Supabase PostgreSQL**

---

## Project Structure

```
trivia/
├── index.html               # Landing / redirect page
├── index.php                # GAE front-controller (routes all requests)
├── quiz.html                # Main quiz page (the core app)
├── editAddQuestion.html     # Add or edit a single question (admin)
├── addTwoMoreQuestion.html  # Add two questions with shared context (admin)
├── signadmin.html           # Admin sign-in page
├── redirect_addquestion.html
├── 404.html
├── app.yaml                 # Google App Engine configuration
├── .env                     # Local dev credentials (not committed)
│
├── api/                     # PHP backend endpoints
│   ├── connect.php          # DB router — reads .env / GAE env vars
│   ├── connect_pgsql.php    # PDO connection to Supabase PostgreSQL
│   ├── connect_mysql.php    # PDO connection to local MySQL
│   ├── connect_sqlite3.php  # PDO connection to SQLite (dev/testing)
│   ├── askphp.php           # Main question fetch API
│   ├── getAllCategories.php  # Fetch full category tree
│   ├── getCategory.php      # Get category for a single question
│   ├── updateAddQuestion.php # Insert / update a question
│   ├── validateaccount.php  # Admin login (SHA-512 salted hash)
│   ├── adduser.php          # Create a new user
│   ├── signup_success.php
│   ├── phpmail.php          # Email helper
│   ├── phpsessionwork.php
│   └── clearsession.php
│
├── css/
│   ├── quiz.css             # Main quiz styles
│   ├── admin.css            # Admin / sign-in styles
│   ├── addquestion.css
│   └── ...
│
├── js/
│   └── myfunctions.js       # Cookie helpers (getit / setit / removeit)
│
├── images/
├── docs/                    # Developer notes
└── archive/                 # Old files kept for reference
```

---

## Frontend

All application logic lives in `quiz.html` as inline JavaScript (jQuery).

### Pages

| Page | Purpose |
|---|---|
| `quiz.html` | Main quiz — category selection, question display, all-questions list |
| `editAddQuestion.html` | Admin form to add a new question or edit an existing one |
| `addTwoMoreQuestion.html` | Admin form to add two related questions at once |
| `signadmin.html` | Admin sign-in (required before editing/adding questions) |

### Key Libraries (all loaded from CDN)

| Library | Version | Use |
|---|---|---|
| Bootstrap | 5.1.3 | Layout and UI components |
| jQuery | 3.5.1 | DOM manipulation and AJAX |
| js-cookie | 3 | Cookie-based session state |
| KaTeX | 0.15.3 | LaTeX math rendering (`$...$`, `$$...$$`) |
| marked.js | latest | Markdown-to-HTML rendering |
| Font Awesome | via kit | Icons (prev/next arrows) |

### Client-Side Caching

Questions and categories are cached in `localStorage` to avoid repeated DB queries:

| Key | Contents |
|---|---|
| `questionCache` | `{ [questionNumber]: [question, answer, detail, categoryId] }` |
| `category2questionIds` | `{ [categoryId]: [questionNumber, ...] }` |
| `category_contents` | Full category tree (top + subcategories) |
| `state` | `"running"` when a quiz session is active |
| `numberlist` | Current shuffled question order |
| `iQuestion` | Current position in the question list |

Cookies store `categorylist` (id → display name) and `selectedCategoryIds`.

### Navigation

- **Buttons**: Prev / Next / Show Answer
- **Keyboard**: ← prev, → next, ↓ show answer
- **Swipe**: horizontal swipe on the question card (mobile)

### Category Emojis

Each category has an emoji in `categoryEmoji` (in `quiz.html`). `getCatEmoji(name)` does a case-insensitive lookup and prepends the emoji to category labels and the question list.

---

## Backend

### Database Schema

Two primary tables (PostgreSQL schema: `trivia`):

**`tbquiz`** — Questions

| Column | Type | Description |
|---|---|---|
| `number` | integer (PK) | Auto-increment question ID |
| `question` | text | Question text |
| `answer` | text | Answer (supports Markdown + LaTeX) |
| `detail` | text | Extended explanation (Markdown + LaTeX) |
| `category` | integer (FK) | References `categories.id` |

**`categories`** — Category hierarchy

| Column | Type | Description |
|---|---|---|
| `id` | integer (PK) | Category ID |
| `name` | text | Category display name |
| `topcategory` | integer | ID of the parent top-level category |
| `subcategory` | integer | `0` = top-level, non-zero = subcategory |

**`tbusers`** — Admin users

| Column | Type | Description |
|---|---|---|
| `username` | text | Admin username |
| `password` | text | SHA-512 salted hash of password |

### API Endpoints

All endpoints live under `api/` and return JSON.

| Endpoint | Method | Description |
|---|---|---|
| `api/askphp.php` | POST | Fetch questions (`mode`: `byNumber` \| `byCategories` \| `all`) |
| `api/getAllCategories.php` | POST | Return full category tree with subcategories |
| `api/getCategory.php` | POST | Return category ID for a given question number |
| `api/updateAddQuestion.php` | POST | Insert or update a question (`sqlmode`: `insert` \| `update`) |
| `api/validateaccount.php` | POST | Validate admin credentials |
| `api/adduser.php` | POST | Create a new user account |

### Database Connection Routing

`api/connect.php` reads the `DB_CONNECTION` environment variable and includes the appropriate driver file:

```
DB_CONNECTION=pgsql  →  connect_pgsql.php  (Supabase / any PostgreSQL)
DB_CONNECTION=mysql  →  connect_mysql.php  (local MySQL, default)
```

Credentials are read from environment variables (set in `.env` locally or in `app.yaml` on GAE).

---

## Setup

### Prerequisites

- PHP 8.3+ with PDO and `pdo_pgsql` / `pdo_mysql` extensions
- A PostgreSQL or MySQL database with the schema above
- (Optional) [Google Cloud SDK](https://cloud.google.com/sdk/docs/install) for deployment

### Local Development

1. **Clone the repo**
   ```bash
   git clone <repo-url>
   cd trivia
   ```

2. **Create `.env`** in the project root:

   For PostgreSQL (Supabase):
   ```ini
   DB_CONNECTION=pgsql
   PGSQL_HOST=db.<project>.supabase.co
   PGSQL_PORT=5432
   PGSQL_NAME=postgres
   PGSQL_USER=postgres
   PGSQL_PASS=your_password
   PGSQL_SCHEMA=trivia
   ```

   For local MySQL:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_NAME=trivia
   DB_USER=root
   DB_PASS=your_password
   DB_CHARSET=utf8mb4
   ```

3. **Start a local PHP server**
   ```bash
   php -S localhost:8080
   ```
   Then open `http://localhost:8080/quiz.html`.

   Alternatively, configure a virtual host (e.g. `trivia.local`) in Apache/Nginx pointing to the project root.

4. **Seed the database** — import your question data into `tbquiz` and category data into `categories`. A sample data notebook is included at `transfer_data.ipynb`.

### First Use

1. Open `quiz.html` and click **Choose Categories!**
2. Select categories and click **Select Them (DB)** to fetch questions from the database and populate the local cache.
3. After the initial fetch, **Select Them!** (cache-only, no DB) can be used for subsequent sessions.

---

## Deploy & Run

### Google App Engine

The app is configured for GAE standard environment (PHP 8.3) via `app.yaml`.

1. **Install Google Cloud SDK** and authenticate:
   ```bash
   gcloud auth login
   gcloud config set project YOUR_PROJECT_ID
   ```

2. **Review `app.yaml`** — update `env_variables` with your production database credentials, or use [Secret Manager](https://cloud.google.com/secret-manager) to avoid storing credentials in the file.

3. **Deploy**:
   ```bash
   gcloud app deploy
   ```

4. **Open the app**:
   ```bash
   gcloud app browse
   ```
   Or navigate to `https://YOUR_PROJECT_ID.appspot.com/quiz.html`.

### How `index.php` Works on GAE

GAE's PHP runtime requires a single front-controller. `index.php` routes requests:
- `.php` files → `require` the file directly (including files under `api/`)
- `.html` files → `readfile()` with the correct content type
- Everything else → serves `index.html`

Static assets (`css/`, `js/`, `images/`, favicons) are served directly by GAE without hitting PHP, as configured in `app.yaml`.

---

## Admin Workflow

1. Navigate to `signadmin.html` (or click **Admin** in the top bar of `quiz.html`) and sign in.
2. While a quiz is running, click **Edit** on any question to open `editAddQuestion.html` pre-filled with that question's data.
3. Click **Add1** to add a new single question, or **Add2+** to add two related questions.
4. After saving, the local cache is stale — click **Refresh Categories** on the category screen to re-fetch from the DB.

---

## Security Notes

- All DB queries use **PDO prepared statements** — no raw SQL string interpolation.
- Column names in `askphp.php` are validated against an **explicit whitelist** (`ALLOWED_COLUMNS`).
- Category IDs passed to queries are cast to `intval()` before use.
- Admin passwords are stored as **SHA-512 salted hashes** (`validateaccount.php`).
- The `.env` file is listed in `.gitignore` and should never be committed.
