# Mobee Assignment — Backend

Laravel 13 + Inertia.js + React 19 full-stack application with an admin dashboard and a REST API.

---

## Requirements

- PHP 8.3
- Composer
- Node.js 20+
- MySQL 8+

---

## Local Setup

```bash
composer run setup
```

This installs all dependencies, copies `.env`, generates the app key, runs migrations, and builds assets.

Then seed the database:

```bash
php artisan db:seed
```

Start all dev processes (PHP server, queue, log viewer, Vite):

```bash
composer run dev
```

App runs at **http://localhost:8000**.

---

## Default Admin Account

| Field    | Value               |
|----------|---------------------|
| Email    | admin@example.com   |
| Password | password            |

---

## Admin Dashboard

All dashboard routes are under `/admin` and require an authenticated admin session.

| Route                     | Description                                      |
|---------------------------|--------------------------------------------------|
| `GET /admin/dashboard`    | Overview: user count, car count, total likes, top preferences, recent registrations |
| `GET /admin/users`        | List all users with like counts                  |
| `GET /admin/users/{id}`   | User detail with full liked-cars list            |
| `GET /admin/reports`      | Per-user report: most liked brand, model, type   |
| `GET /admin/cars`         | Car inventory with search, edit, delete          |
| `GET /admin/cars/create`  | Add a new car (image upload)                     |
| `GET /admin/cars/{id}/edit` | Edit an existing car                           |

---

## REST API

Base URL: `http://localhost:8000/api`

All protected routes require the header:

```
Authorization: Bearer <token>
```

### Authentication

#### Login
```
POST /api/login
```

Body:
```json
{
    "email": "admin@example.com",
    "password": "password"
}
```

Response:
```json
{
    "token": "1|abc123...",
    "user": { "id": 1, "name": "Admin", "email": "admin@example.com", "is_admin": true }
}
```

#### Logout
```
POST /api/logout
```
Requires auth. Invalidates the current token.

#### Get Authenticated User
```
GET /api/user
```

---

### Cars

#### List All Cars
```
GET /api/cars
```

Response: array of car objects.
```json
[
    {
        "id": 1,
        "brand": "Toyota",
        "model": "Camry",
        "type": "Sedan",
        "image_url": "/storage/cars/abc.jpg"
    }
]
```

#### Get Single Car
```
GET /api/cars/{id}
```

---

### User Preferences (Likes)

#### Get Liked Cars
```
GET /api/user/preferences
```

Returns the list of cars the authenticated user has liked.

#### Like a Car
```
POST /api/cars/{id}/like
```

Idempotent — liking an already-liked car has no effect.

Response `201`:
```json
{ "message": "Car liked." }
```

#### Unlike a Car
```
DELETE /api/cars/{id}/like
```

Response `204 No Content`.

---

### Admin — Users *(requires admin token)*

#### List All Users
```
GET /api/admin/users
```

Response: array of users with `car_likes_count`.

#### Get User Detail
```
GET /api/admin/users/{id}
```

Response:
```json
{
    "user": { "id": 2, "name": "Jane", "email": "jane@example.com" },
    "liked_cars": [ { "id": 1, "brand": "Toyota", ... } ]
}
```

---

### Admin — Reports *(requires admin token)*

#### All Users Report
```
GET /api/admin/reports
```

Response: array of preference reports per user.
```json
[
    {
        "user": { "id": 2, "name": "Jane", "email": "jane@example.com" },
        "preferences": {
            "most_liked_brand": "Toyota",
            "most_liked_model": "Camry",
            "most_liked_type": "Sedan"
        }
    }
]
```

#### Single User Report
```
GET /api/admin/reports/{id}
```

---

## Running Tests

```bash
php artisan test
```

Tests use an in-memory SQLite database and do not affect the MySQL database.

---

## Deployment (Vercel)

Set the following environment variables in the Vercel dashboard before deploying:

| Key              | Value                        |
|------------------|------------------------------|
| `APP_KEY`        | your `base64:...` key        |
| `APP_ENV`        | `production`                 |
| `APP_URL`        | your Vercel deployment URL   |
| `DB_CONNECTION`  | `mysql`                      |
| `DB_HOST`        | your remote MySQL host       |
| `DB_PORT`        | `3306`                       |
| `DB_DATABASE`    | database name                |
| `DB_USERNAME`    | database username            |
| `DB_PASSWORD`    | database password            |
| `SESSION_DRIVER` | `database`                   |

After the first deployment, run migrations against your remote database:

```bash
php artisan migrate --seed --force
```
