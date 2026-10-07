# 🌱 Nursery Attendance Management API

A Laravel‑based multi‑tenant API for managing nursery room attendance. This project enforces strict tenant isolation, ensuring that children, rooms, and staff are always validated against their nursery and tenant before any operation.

---

## 🚀 Getting Started

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/nursery-attendance-api.git
cd nursery-attendance-api
```

### 2. Install dependencies
```bash
composer install
```

### 3. Run Seeders (Dummy Data)
```bash
php artisan db:seed
```


### 🛠️ Repository Pattern
This project uses the Repository Pattern to abstract database operations:

Controllers interact only with repositories, not directly with Eloquent models.

This separation makes the codebase more testable and maintainable


### Tenant Entity
We’ve added a Tenant entity for future scalability:

Each nursery belongs to a tenant.

All operations are scoped by X-Tenant-ID header.

Validation ensures children, rooms, and staff belong to the same nursery and tenant.

This design supports multi‑tenant environments where multiple organizations can use the system independently.


### API Endpoints

Check‑in child  
POST /attendance

Prevents duplicate check‑ins for the same child, room, and staff.

Auto‑checkout from previous room before new check‑in.

Check‑out child  
PUT /attendance/{child_id}/checkout

List room occupants  
GET /rooms/{room_id}/occupants  
Returns children currently checked in, scoped by tenant.
