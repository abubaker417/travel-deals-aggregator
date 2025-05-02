**Travel Deals Aggregator**

A Laravel-based REST API that aggregates travel deals from Skyscanner RapidAPI, allowing users to browse, search, and bookmark deals.

**Requirements**
PHP >= 8.2
Composer
MySQL

**Amadeus Travel Keys:**
AMADEUS_CLIENT_ID
AMADEUS_CLIENT_SECRET

**Setup Instructions**
1. Clone the repository:
```
git clone https://github.com/abubaker417/travel-deals-aggregator.git
cd travel-deals-aggregator
```

2. Install dependencies:
```
composer install
```

3. Copy .env.example to .env and configure:
```
cp .env.example .env
```
Update DB_* and AMADEUS_CLIENT_ID and AMADEUS_CLIENT_SECRET in .env

4. Generate application key:
```
php artisan key:generate
```

5. Run migrations and seed database:
```
php artisan migrate --seed
```

6. Start queue worker:
```
php artisan queue:work
```

7. Serve the application:
```
php artisan serve
```

**API Endpoints**
POST /api/register - Register a user
POST /api/login - Login a user
POST /api/logout - Logout (requires auth)
GET /api/deals - List deals (max 1000)
GET /api/deals/{id} - View a deal
POST /api/deals/{id}/bookmark - Bookmark a deal
GET /api/user/bookmarks - List user bookmarks

**Running the Deal Fetcher**
Manually run:
```
php artisan deals:fetch
```
Scheduled hourly via Laravel Scheduler.


**Testing**
```
php artisan test
```
