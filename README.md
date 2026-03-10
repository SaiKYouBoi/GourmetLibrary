# GourmetLibrary API Documentation

Base URL: `http://localhost/api`  
Authentication: **Laravel Sanctum Bearer Token** required for protected endpoints.

---

## Authentication

### Register User

- **Endpoint:** `/register`  
- **Method:** `POST`

#### Request Body

```json
{
  "name": "Ilias",
  "email": "ilias@test.com",
  "password": "password123"
}

* **Response:**

```json
{
  "user": {
    "id": 1,
    "name": "Ilias",
    "email": "ilias@test.com",
    "role": "admin",
    "created_at": "2026-03-10T10:00:00Z"
  },
  "token": "plain-text-token"
}
```

### Login User

* **Endpoint:** `/login`
* **Method:** POST
* **Body:**

```json
{
  "email": "ilias@test.com",
  "password": "password123"
}
```

* **Response:**

```json
{
  "user": { ... },
  "token": "plain-text-token"
}
```

### Get Authenticated User

* **Endpoint:** `/user`
* **Method:** GET
* **Headers:** `Authorization: Bearer {token}`
* **Response:**

```json
{
  "id": 1,
  "name": "Ilias",
  "email": "ilias@test.com",
  "role": "admin"
}
```

---

## Categories

| Action          | Endpoint           | Method | Auth |
| --------------- | ------------------ | ------ | ---- |
| List categories | `/categories`      | GET    | Yes  |
| Create category | `/categories`      | POST   | Yes  |
| Update category | `/categories/{id}` | PUT    | Yes  |
| Delete category | `/categories/{id}` | DELETE | Yes  |

### Example: Create Category

```json
POST /categories
{
  "name": "Italian Cuisine",
  "description": "Traditional Italian recipes"
}
```

Response:

```json
{
  "id": 1,
  "name": "Italian Cuisine",
  "description": "Traditional Italian recipes"
}
```

---

## Cookbooks

| Action                   | Endpoint                             | Method | Auth |
| ------------------------ | ------------------------------------ | ------ | ---- |
| List all cookbooks       | `/cookbooks`                         | GET    | Yes  |
| Create cookbook          | `/cookbooks`                         | POST   | Yes  |
| Update cookbook          | `/cookbooks/{id}`                    | PUT    | Yes  |
| Delete cookbook          | `/cookbooks/{id}`                    | DELETE | Yes  |
| Browse by category       | `/categories/{id}/cookbooks`         | GET    | Yes  |
| Search cookbooks         | `/cookbooks/search?q=`               | GET    | Yes  |
| Most popular in category | `/categories/{id}/cookbooks/popular` | GET    | Yes  |
| New arrivals in category | `/categories/{id}/cookbooks/new`     | GET    | Yes  |
| Degraded books           | `/cookbooks/degraded`                | GET    | Yes  |

### Example: Create Cookbook

```json
POST /cookbooks
{
  "title": "Italian Pasta Mastery",
  "chef": "Massimo Bottura",
  "description": "Modern pasta recipes",
  "category_id": 1
}
```

Response:

```json
{
  "id": 1,
  "title": "Italian Pasta Mastery",
  "chef": "Massimo Bottura",
  "category_id": 1
}
```

---

## Copies

| Action                    | Endpoint                 | Method | Auth |
| ------------------------- | ------------------------ | ------ | ---- |
| Create copy               | `/copies`                | POST   | Yes  |
| List copies of a cookbook | `/cookbooks/{id}/copies` | GET    | Yes  |
| Update copy               | `/copies/{id}`           | PUT    | Yes  |
| Delete copy               | `/copies/{id}`           | DELETE | Yes  |

### Example: Create Copy

```json
POST /copies
{
  "cookbook_id": 1,
  "status": "available",
  "condition": "good"
}
```

Response:

```json
{
  "id": 1,
  "cookbook_id": 1,
  "status": "available",
  "condition": "good"
}
```

---

## Borrowing System

| Action         | Endpoint               | Method | Auth |
| -------------- | ---------------------- | ------ | ---- |
| Borrow a copy  | `/borrows`             | POST   | Yes  |
| Return a copy  | `/borrows/{id}/return` | PUT    | Yes  |
| Borrow history | `/borrows`             | GET    | Yes  |

### Example: Borrow a Copy

```json
POST /borrows
{
  "copy_id": 1
}
```

Response:

```json
{
  "id": 1,
  "user_id": 2,
  "copy_id": 1,
  "borrow_date": "2026-03-10",
  "return_date": null
}
```

---

## Statistics

| Action                | Endpoint      | Method | Auth |
| --------------------- | ------------- | ------ | ---- |
| Collection statistics | `/statistics` | GET    | Yes  |

### Example Response

```json
{
  "most_consulted_books": [
    { "id": 1, "title": "French Pastry Mastery", "chef": "Pierre Hermé", "borrows_count": 12 }
  ],
  "collection_condition": [
    { "condition": "good", "total": 40 },
    { "condition": "damaged", "total": 6 }
  ],
  "most_represented_categories": [
    { "id": 2, "name": "Italian Cuisine", "cookbooks_count": 12 }
  ]
}
```

---

## Degraded Books

| Action                    | Endpoint              | Method | Auth |
| ------------------------- | --------------------- | ------ | ---- |
| Degraded copies per title | `/cookbooks/degraded` | GET    | Yes  |

### Example Response

```json
[
  { "id": 1, "title": "Italian Pasta Mastery", "chef": "Massimo Bottura", "degraded_count": 2 },
  { "id": 2, "title": "French Pastry Mastery", "chef": "Pierre Hermé", "degraded_count": 1 }
]
```

---

## Notes

* All **POST/PUT** requests require `Content-Type: application/json`.
* All **protected endpoints** require `Authorization: Bearer {token}`.
* Dates are in **ISO 8601 format** (`YYYY-MM-DD`).
* `condition` field in **copies** can be: `"good"`, `"damaged"`, `"stained"`.
* Pagination can be added for **cookbooks and copies** if needed.

---
```
