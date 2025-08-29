# Restaurant Management API Documentation

## Base URL
```
http://localhost:8000/api
```

## Rate Limiting
- 60 requests per minute per IP

## Endpoints

### Restaurants

#### GET /restaurants
List all restaurants with filtering and pagination.

**Query Parameters:**
- `search` (string): Search in name, location, cuisine
- `cuisine` (string): Filter by cuisine type
- `location` (string): Filter by location  
- `sort_by` (string): Sort field (name, location, cuisine)
- `sort_order` (string): asc/desc
- `per_page` (integer): Items per page (default: 10)

**Response:**
```json
{
  "data": [
    {
      "id": 101,
      "name": "Tandoori Treats",
      "location": "Bangalore", 
      "cuisine": "North Indian"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 4
  }
}
```

#### GET /restaurants/{id}
Get restaurant details with orders.

### Analytics

#### GET /restaurants/{id}/trends
Get order trends for specific restaurant.

**Query Parameters:**
- `start_date` (date): Start date (Y-m-d)
- `end_date` (date): End date (Y-m-d)

#### GET /analytics/top-restaurants
Get top 3 restaurants by revenue.

#### GET /analytics/orders
Get filtered orders with pagination.

#### GET /dashboard/overview
Get dashboard overview statistics.

## Error Responses

```json
{
  "error": "Validation failed",
  "message": "The given data was invalid.",
  "errors": {
    "start_date": ["The start date field is required."]
  }
}
```