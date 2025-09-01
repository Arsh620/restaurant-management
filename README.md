# Restaurant Management Analytics Dashboard - Backend

A Laravel-based backend API for restaurant analytics dashboard that provides order trends, revenue analytics, and restaurant management features.

## Features

- Restaurant listing with search, sort, and filter capabilities
- Order trends analytics (daily orders, revenue, average order value)
- Peak hour analysis per day
- Top 3 restaurants by revenue
- Advanced filtering (restaurant, date range, amount range, hour range)
- Efficient data handling with pagination and caching

## Quick Setup

### Prerequisites
- PHP 8.1+
- Composer
- MySQL
- Laravel 10.x

### Installation

1. **Clone and setup:**
   ```bash
   git clone <repository-url>
   cd restaurant-management
   ```

2. **Run setup script (Windows):**
   ```bash
   setup.bat
   ```

   **Or manual setup:**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure database in .env:**
   ```
   DB_DATABASE=restaurant_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations and seed data:**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start server:**
   ```bash
   php artisan serve
   ```

## API Endpoints

### Authentication

**POST /api/register**
- Register a new user
- Body: `name`, `email`, `password`
- Returns: User data and Bearer token

**POST /api/login**
- Login user
- Body: `email`, `password`
- Returns: User data and Bearer token

**POST /api/logout** (Protected)
- Logout current user
- Requires: Bearer token
- Returns: Success message

**GET /api/user** (Protected)
- Get current user data
- Requires: Bearer token

### Restaurants (Protected)

**GET /api/restaurants**
- List restaurants with pagination
- Requires: Bearer token
- Query parameters:
  - `search` - Search in name, location, cuisine
  - `cuisine` - Filter by cuisine type
  - `location` - Filter by location
  - `sort_by` - Sort field (name, location, cuisine)
  - `sort_order` - asc/desc
  - `per_page` - Items per page

**GET /api/restaurants/{id}**
- Get restaurant details with orders
- Requires: Bearer token

### Analytics (Protected)

**GET /api/restaurants/{id}/trends**
- Get order trends for specific restaurant
- Requires: Bearer token
- Query parameters:
  - `start_date` - Start date (Y-m-d)
  - `end_date` - End date (Y-m-d)
- Returns: Daily orders count, revenue, average order value, peak hours

**GET /api/analytics/top-restaurants**
- Get top 3 restaurants by revenue
- Requires: Bearer token
- Query parameters:
  - `start_date` - Start date (Y-m-d)
  - `end_date` - End date (Y-m-d)

**GET /api/analytics/orders**
- Get filtered orders with pagination
- Requires: Bearer token
- Query parameters:
  - `restaurant_id` - Filter by restaurant
  - `start_date` - Start date
  - `end_date` - End date
  - `min_amount` - Minimum order amount
  - `max_amount` - Maximum order amount
  - `start_hour` - Start hour (0-23)
  - `end_hour` - End hour (0-23)
  - `per_page` - Items per page

## Sample Data

The application includes:
- 4 restaurants (Tandoori Treats, Sushi Bay, Pasta Palace, Burger Hub)
- 200 orders across 7 days (June 23-30, 2025)
- Mock data matching the assignment requirements

## Database Schema

### Restaurants Table
- id (primary key)
- name
- location
- cuisine
- timestamps

### Orders Table
- id (primary key)
- restaurant_id (foreign key)
- order_amount (decimal)
- order_time (timestamp)
- timestamps

## Performance Optimizations

- Database indexing on frequently queried fields
- Efficient SQL queries with proper joins
- Pagination for large datasets
- Eager loading for relationships
- Query optimization for analytics

## CORS Configuration

CORS is configured to allow frontend integration. Update `config/cors.php` if needed.

## Testing

Test the API endpoints using tools like Postman or curl:

```bash
# Register user
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123"}'

# Login user
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'

# Get restaurants (with token)
curl -H "Authorization: Bearer YOUR_TOKEN" http://localhost:8000/api/restaurants

# Get restaurant trends (with token)
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "http://localhost:8000/api/restaurants/101/trends?start_date=2025-06-23&end_date=2025-06-30"
```

## Frontend Integration

This backend is designed to work with Next.js/React frontend. All endpoints return JSON responses suitable for frontend consumption.

## Assignment Completion

✅ Laravel/PHP Backend  
✅ User registration and login with token authentication  
✅ Protected API routes with Bearer token  
✅ Restaurant listing with search/sort/filter  
✅ Order trends analytics  
✅ Revenue and average order value calculation  
✅ Peak hour analysis  
✅ Top 3 restaurants by revenue  
✅ Advanced filtering capabilities  
✅ Efficient data handling  
✅ Mock data integration  
✅ API documentation  
✅ Setup instructions