<<<<<<< HEAD
# Event Booking System (Laravel + MySQL)

# Project Overview
This is a simple **Event Booking System** built with **Laravel 12** and **MySQL**.  
The system allows users to register/login, view events, book tickets, and see statistics on bookings and event occupancy.

# Features Implemented

**Must-have features:**
- **User Authentication:**
  - Email/password login.
  - Social login via Google/GitHub using **Laravel Socialite**.
- **Event Management:**
  - Create, list, and manage events.
  - Event details: title, venue, capacity, date.
- **Booking System:**
  - Users can book tickets for events.
  - Prevents overbooking using database transactions.
- **Dashboard:**
  - Number of events booked by the logged-in user.
  - Top 5 upcoming events.
  - Event occupancy percentage.
  - Users who booked more than 3 events last month.
- **Event Listing:**
  - Search, filter, paginate events.
- Responsive layout using **Bootstrap 5**.

**Bonus / Additional Features:**
- ⚡ Bonus features: caching, queued email notifications, DB optimization.

## Screenshots

### 1. Login Page
### 2. Register Page
### 3. Dashboard Page
### 4. Events  Page
### 5. Bookings Index Page
### 5. Email 
### 6. Booking Test
All the png images are in scrrenshots to experience how the blade files look.



## Project Setup Instructions

### 1. Download the Project
- Download the project ZIP file and extract it to your local machine (e.g., `C:\xampp\htdocs\event-booking`).

### 2. Install Dependencies
Open a terminal in the project folder:

```bash
cd path/to/event-booking
composer install
npm install
npm run build

3. Environment Setup

Copy .env.example → .env

Fill your own database, mail, and OAuth credentials

Run php artisan key:generate

Run migrations & seeders: php artisan migrate --seed

Update .env with your database credentials:

The .env file will look like:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_booking
DB_USERNAME=root
DB_PASSWORD=

# Mail (Gmail SMTP)
Important for Gmail SMTP

Enable 2FA on your Gmail account.
Generate an App Password from Google Account → Security → App Password.
Use that password in MAIL_PASSWORD.

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your_gmail@gmail.com
MAIL_PASSWORD=your_app_password   # Use Gmail App Password
MAIL_FROM_ADDRESS=your_gmail@gmail.com
MAIL_FROM_NAME="Event Booking App"

Add OAuth keys for Google and GitHub:

# Google
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT=http://127.0.0.1:8000/login/google/callback

# GitHub
GITHUB_CLIENT_ID=your-github-client-id
GITHUB_CLIENT_SECRET=your-github-client-secret
GITHUB_REDIRECT=http://127.0.0.1:8000/login/github/callback

Use=php artisan key:generate 

then,
Update config/services.php:

return [
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT'),
    ],
];

4. Generate Application Key
php artisan key:generate

5. Run Migrations and Seeders
php artisan migrate --seed

6. Before Serving application
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

7. Serve the Application
php artisan serve


Open http://127.0.0.1:8000 in your browser.

Database Structure

Tables:

users

id, name, email, password, email_verified_at, timestamps

events

id, title, venue, capacity, event_date, timestamps

bookings

id, user_id (FK), event_id (FK), tickets, timestamps

Important Queries Implemented:

Top 5 events by bookings in the last 30 days:

$topEvents = Event::withCount('bookings')
    ->whereHas('bookings', function($q) {
        $q->where('created_at', '>=', now()->subDays(30));
    })
    ->orderBy('bookings_count', 'desc')
    ->take(5)
    ->get();


Users who booked >3 events last month:

$activeUsers = User::whereHas('bookings', function($q) {
    $q->whereBetween('created_at', [
        now()->subMonth()->startOfMonth(),
        now()->subMonth()->endOfMonth()
    ]);
}, '>=', 3)->withCount(['bookings as bookings_count' => function($q) {
    $q->whereBetween('created_at', [
        now()->subMonth()->startOfMonth(),
        now()->subMonth()->endOfMonth()
    ]);
}])->get();


Event occupancy %:

$eventsWithOccupancy = Event::all()->map(function($event){
    $booked = $event->bookings()->sum('tickets');
    $event->occupancy = $event->capacity > 0 ? round(($booked / $event->capacity) * 100, 2) : 0;
    return $event;
});

8. Cache Event Listings (Implemented)
To improve performance and reduce database load, event listings are cached using Laravel’s `Cache::remember()`:

- ### EventController@index ### 
  - Queries are cached for 5 minutes (`300 seconds`) using a unique cache key that depends on filters (search, pagination, date, location).  
  - This ensures frequently accessed event listings load faster without hitting the database every time.

- ### EventController@store, update, destroy ###
  - Cache is cleared (`Cache::flush()`) whenever an event is created, updated, or deleted.  
  - This ensures users always see fresh event data and prevents stale cache issues.

🔹 Result: Faster response times on event listing pages and reduced database queries under high load.

9. Unit Test:Cannot Book When Event is Full

We have written a feature test to ensure that users cannot book tickets once an event has reached its full capacity.

Test File Location

tests/Feature/BookingTest.php

Test Code:Available in tests/Feature/BookingTest.php


# Run this Test

php artisan test --filter=BookingTest

# When Correct you will see a passing result

PASS  Tests\Feature\BookingTest
✓ user cannot book when event is full


10.⚡ Database Indexes & Optimization

To ensure fast lookups and efficient queries, the following indexes are used in the Event Booking System:

1. Users Table

email → unique index for login & duplicate prevention.

provider + provider_id → composite index for faster social login authentication.

2. Events Table

event_date → index for quickly fetching upcoming events.

title → optional FULLTEXT index (MySQL) to speed up keyword search.

3. Bookings Table

user_id → index to optimize user → bookings relationship.

event_id → index to speed up event capacity checks.

(event_id, user_id) composite index → prevents duplicate bookings per user/event and improves query performance.

4. Queue & Jobs Table

queue & reserved_at → indexes to improve Laravel’s background job dispatching performance.

🔎 Why Indexes Matter?

Without indexes → MySQL scans the whole table (slow on large datasets).

With indexes → MySQL directly locates the rows (fast lookups).

Example:

-- Before: full table scan
SELECT * FROM bookings WHERE event_id = 5;

-- After: indexed query (instant lookup)
-- Index: idx_event_id on bookings(event_id)

⚙️ How to Verify Index Usage

Run:

EXPLAIN SELECT * FROM bookings WHERE event_id = 5;


If the index is used, you’ll see it listed in the key column.

11. Simple Sql queries are given in text-file named as Database Queries.txt in the same event_booking folder for the Database Queries:
● Top 5 events by bookings in the last 30 days.
● Users who booked >3 events last month.
● % occupancy for each event.


Thankyou very much For the opportunity.

=======
# Event-Booking
Event Booking System built with Laravel 12 and MySQL, allowing users to browse and book events online. Features include social login via Socialite, caching for faster event listings, unit testing for core functionality, and a clean Blade-based interface for seamless user experience.
>>>>>>> fd6157c10ff8b1c1d50386d64001e0ce05933af7
