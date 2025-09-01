# 🍽️ Restaurant Management Analytics Dashboard - Backend

> A powerful Laravel-based REST API for restaurant analytics and management

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-13+-blue.svg)](https://postgresql.org)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 Table of Contents
- [Overview](#-overview)
- [Features](#-features)
- [Quick Start](#-quick-start)
- [Installation Guide](#-installation-guide)
- [API Documentation](#-api-documentation)
- [Testing](#-testing)
- [Project Structure](#-project-structure)
- [Troubleshooting](#-troubleshooting)

## 🎯 Overview

This backend API provides comprehensive restaurant analytics including order trends, revenue tracking, and performance metrics. Built with Laravel 10 and optimized for high performance with proper indexing and caching.

### What You Get
- 📊 **Real-time Analytics** - Order trends, revenue, peak hours
- 🔍 **Advanced Filtering** - Search, sort, and filter by multiple criteria
- 🏪 **Restaurant Management** - Complete CRUD operations
- 🔐 **Secure Authentication** - JWT token-based auth
- 📱 **API Ready** - Perfect for frontend integration

## ✨ Features

| Feature | Description |
|---------|-------------|
| 🏪 **Restaurant Listing** | Search, sort, and filter restaurants by cuisine, location |
| 📈 **Order Analytics** | Daily trends, revenue tracking, average order values |
| ⏰ **Peak Hour Analysis** | Identify busiest hours for each restaurant |
| 🏆 **Top Performers** | Top 3 restaurants by revenue |
| 🔍 **Advanced Filters** | Filter by date range, amount, time, restaurant |
| 📄 **Pagination** | Efficient data handling for large datasets |
| 🔐 **Authentication** | Secure user registration and login |
| ⚡ **Performance** | Optimized queries with proper indexing |

## 🚀 Quick Start

### Option 1: Automated Setup (Recommended)

```bash
# Clone the repository
git clone <repository-url>
cd restaurant-management-b

# Run automated setup (Windows)
setup.bat

# Start the server
php artisan serve
```

### Option 2: Manual Setup

Follow the [detailed installation guide](#-installation-guide) below.

## 📦 Installation Guide

### Prerequisites

Before you begin, ensure you have:

- ✅ **PHP 8.1 or higher**
- ✅ **Composer** (PHP dependency manager)
- ✅ **PostgreSQL 13+**
- ✅ **Git** (for cloning)

### Step-by-Step Installation

#### 1️⃣ Clone the Repository
```bash
git clone <repository-url>
cd restaurant-management-b
```

#### 2️⃣ Install Dependencies
```bash
composer install
```

#### 3️⃣ Environment Setup
```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

#### 4️⃣ Database Configuration

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=restaurant_management
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

#### 5️⃣ Database Setup
```bash
# Create database (if using PostgreSQL command line)
psql -U postgres -c "CREATE DATABASE restaurant_management;"

# Run migrations and seed data
php artisan migrate:fresh --seed
```

#### 6️⃣ Start the Server
```bash
php artisan serve
```

🎉 **Success!** Your API is now running at `http://localhost:8000`

## 📚 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication

All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

### 🔐 Authentication Endpoints

| Method | Endpoint | Description | Body |
|--------|----------|-------------|------|
| `POST` | `/register` | Register new user | `name`, `email`, `password` |
| `POST` | `/login` | Login user | `email`, `password` |
| `POST` | `/logout` | Logout user | - |
| `GET` | `/user` | Get current user | - |

### 🏪 Restaurant Endpoints

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| `GET` | `/restaurants` | List all restaurants | `search`, `cuisine`, `location`, `sort_by`, `sort_order`, `per_page` |
| `GET` | `/restaurants/{id}` | Get restaurant details | - |

### 📊 Analytics Endpoints

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| `GET` | `/restaurants/{id}/trends` | Get order trends | `start_date`, `end_date` |
| `GET` | `/analytics/top-restaurants` | Top 3 restaurants | `start_date`, `end_date` |
| `GET` | `/analytics/orders` | Filtered orders | `restaurant_id`, `start_date`, `end_date`, `min_amount`, `max_amount`, `start_hour`, `end_hour` |

### 📝 Example Requests

#### Register a User
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
  }'
```

#### Get Restaurant Trends
```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "http://localhost:8000/api/restaurants/1/trends?start_date=2025-06-23&end_date=2025-06-30"
```

## 🧪 Testing

### Using the Test File

A `test-api.http` file is included for easy testing with REST clients:

```bash
# Open test-api.http in your IDE or REST client
# Update the token and run the requests
```

### Sample Test Data

The application includes realistic test data:
- 🏪 **4 Restaurants**: Tandoori Treats, Sushi Bay, Pasta Palace, Burger Hub
- 📦 **200+ Orders** across 7 days (June 23-30, 2025)
- 💰 **Varied pricing** from $8 to $85 per order
- ⏰ **Different peak hours** for each restaurant

## 📁 Project Structure

```
restaurant-management-b/
├── 📁 app/
│   ├── 📁 Http/Controllers/     # API Controllers
│   ├── 📁 Models/              # Eloquent Models
│   └── 📁 Services/            # Business Logic
├── 📁 database/
│   ├── 📁 migrations/          # Database Schema
│   └── 📁 seeders/            # Test Data
├── 📁 routes/
│   └── 📄 api.php             # API Routes
├── 📁 config/                 # Configuration Files
├── 📄 .env.example           # Environment Template
├── 📄 setup.bat              # Automated Setup
└── 📄 test-api.http          # API Test File
```

## 🔧 Troubleshooting

### Common Issues

#### ❌ "Class not found" Error
```bash
composer dump-autoload
```

#### ❌ Database Connection Error
1. Check PostgreSQL is running
2. Verify `.env` database credentials
3. Ensure database exists

#### ❌ Permission Errors
```bash
# Fix storage permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache

# Windows: Run as Administrator
```

#### ❌ Migration Errors
```bash
# Reset and re-run migrations
php artisan migrate:fresh --seed
```

### Performance Tips

- 🚀 **Enable caching** for production
- 📊 **Use pagination** for large datasets
- 🔍 **Add indexes** for custom queries
- 💾 **Optimize database** regularly

### Getting Help

- 📖 Check Laravel documentation
- 🐛 Review error logs in `storage/logs/`
- 💬 Open an issue for bugs
- 📧 Contact support for assistance

---

## 🎯 What's Included

✅ **Complete Laravel Backend**  
✅ **JWT Authentication System**  
✅ **Restaurant Management**  
✅ **Advanced Analytics**  
✅ **Performance Optimizations**  
✅ **Comprehensive API Documentation**  
✅ **Test Data & Examples**  
✅ **Easy Setup Process**  

---

<div align="center">
  <p>Built with ❤️ using Laravel</p>
  <p>Ready for production • Optimized for performance • Developer friendly</p>
</div>