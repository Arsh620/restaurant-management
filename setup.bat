@echo off
echo Setting up Restaurant Management Backend...

echo Installing dependencies...
call composer install

echo Creating database...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS restaurant_management;"

echo Running migrations...
call php artisan migrate:fresh

echo Seeding database...
call php artisan db:seed

echo Setup complete!
echo.
echo API Endpoints:
echo GET /api/restaurants - List restaurants with search/filter/sort
echo GET /api/restaurants/{id} - Get restaurant details
echo GET /api/restaurants/{id}/trends - Get order trends for restaurant
echo GET /api/analytics/top-restaurants - Get top 3 restaurants by revenue
echo GET /api/analytics/orders - Get filtered orders
echo.
echo Start the server with: php artisan serve
pause