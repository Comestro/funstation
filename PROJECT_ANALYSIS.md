# Core PHP Project Analysis: FunStation (Game Zone Management)

## 1. Project Overview

This is a custom-built, core PHP application designed to manage a "Game Zone" or arcade. It handles kid registration, session tracking (check-in/check-out), time management, and point-of-sale features (snacks/socks).

## 2. Technology Stack

### Backend

- **Language**: Native PHP (No framework).
- **Database**: MySQL (accessed via `mysqli` extension).
- **Dependency Management**: Composer.
- **Dependencies**: `phpoffice/phpspreadsheet` (for Excel reports).

### Frontend

- **Markup**: HTML5.
- **Styling**: Tailwind CSS (v3.4.15) & Flowbite (v2.5.2) via CDN.
- **Scripting**: jQuery (v3.7.1).
- **Interaction**: AJAX-driven UI updates for session management.

## 3. Architecture & Structure

The project follows a **file-based routing** and **procedural** architecture, organized into logical directories:

- **Root (`/`)**: specific pages (e.g., `index.php` for dashboard, `login.php` for auth).
- **`config/`**: Configuration files. `database.php` handles the DB connection and global settings initialization.
- **`api/`**: JSON endpoints (e.g., `get_sessions.php`, `checkout.php`) used by the frontend AJAX calls.
- **`function/`**: Action scripts for handling form submissions (e.g., `process_admin_login.php`, `add_session.php`).
- **`include/`**: Reusable UI partials (`header.php`, `sidebar.php`) and logic (`login_required.php`).
- **`vendor/`**: Composer libraries.

## 4. Key Mechanisms

### Database Connection

- Defined in `config/database.php`.
- Uses `mysqli` in object-oriented mode.
- **Note**: Credentials are currently hardcoded (`root`/`''`), and the database name is `game_zone1`.
- Sets timezone to `Asia/Kolkata`.

### Authentication

- Session-based authentication (`session_start()`).
- Admin credentials stored in `admin` table.
- Passwords hashed using `password_hash()` and verified with `password_verify()` (Good security practice).

### Session Logic (Core Business Logic)

- **Data Flow**: The frontend (`index.php`) polls `api/get_sessions.php` every 60 seconds.
- **Optimization**: Sessions are split into `current_sessions` (active) and `checked_out_sessions` (historical) in the API response.
- **Filtering**: Supports robust date filtering (Today, Yesterday, Last 7 Days, etc.) directly in SQL queries.

## 5. Code Quality Assessment

### Strengths

- **Simplicity**: Easy to understand and modify without framework overhead.
- **Security**: Uses `password_verify` for login. Attempts variable escaping for search inputs.
- **Modern UI**: Uses Tailwind and Flowbite for a responsive, clean interface.
- **AJAX**: dynamic searching and loading without page refreshes improves UX.

### Areas for Improvement

1.  **Security**:
    - While login uses prepared statements, `api/get_sessions.php` uses `$db->real_escape_string` for the search term. It is highly recommended to use **Prepared Statements** everywhere to prevent SQL injection effectively.
    - Database credentials should be moved to an environment file (`.env`) instead of being hardcoded in `config/database.php`.
2.  **Maintainability**:
    - Logic is mixed with presentation (PHP `echo` inside HTML structures).
    - Manual SQL string concatenation makes queries hard to read and debug.
3.  **Error Handling**:
    - `die()` is used for connection errors, which is abrupt. A graceful error page would be better.

## 6. Recommendations

1.  **Environment Variables**: Introduce a `.env` file for DB credentials.
2.  **Refactor Queries**: Switch all raw SQL queries to `prepare()` / `bind_param()` methods.
3.  **Validation**: Ensure all API inputs (like `session_id`, `extra_hours`) are strictly validated on the server side before processing.
