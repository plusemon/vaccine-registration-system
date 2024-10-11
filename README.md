### Key Sections:

1. **Project Overview**: Describes the purpose and features of the system.
2. **Prerequisites**: Lists all necessary dependencies and tools.
3. **Installation Guide**: Provides a step-by-step guide for setting up the application.
4. **Usage**: Explains the registration and search functionalities.
5. **Cron Job Setup**: Ensures notifications are scheduled correctly.
6. **Future Enhancements**: Notes possible SMS notification integration.
7. **Optimizations**: Suggests ways to optimize the app for better performance.
8. **License**: Instructions for running tests and project licensing.

This structure should guide users on how to install, configure, and use your vaccination registration system.

# Project Overview

A web-based vaccination registration system built with **Laravel 11**, **Vue.js**, **Inertia.js**, and **Tailwind CSS**. This system allows users to register for vaccination, schedule vaccination dates, and view their registration status. Admins can view all registrations with pagination.

## Features

- User registration with NID and vaccine center selection
- Vaccination date scheduling based on center capacity and `first come first serve` rule
- Email notifications sent one day prior to the scheduled vaccination date
- Users can check their registration status using their NID
- Admin view for all registrations with pagination

## Prerequisites

Ensure you have the following installed on your machine:

- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL (or any supported database)
- Laravel 11
- A working mail configuration (e.g., Mailtrap or SMTP setup)

## Installation Guide

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/vaccination-registration-system.git
```
```bash
cd vaccination-registration-system
```
### 2. Install PHP Dependencies
Install the necessary PHP dependencies using Composer:
```bash
composer install
```
### 3. Install JavaScript Dependencies
Use NPM to install frontend dependencies:
```bash
npm install
```

```bash
npm run build
```

### 4. Environment Setup
Copy the .env.example file to create your .env file:
```bash
cp .env.example .env
```
### 5. Configure Environment Variables
Update the following details in the .env file:
```env
APP_NAME="Vaccination Registration System"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vaccine_db
DB_USERNAME=root
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@vaccination.com"
MAIL_FROM_NAME="Vaccination System"
```
### 6. Run Migrations with Seed(10 Vaccine Center) Database
```base
php artisan migrate --seed
```
Note: For seeded Vaccine Center will sufix with the limit of daily capacity like "Vaccine Center 5" will take 5 schedule in a day.

### 7. Generate Application Key
Generate an application key to secure the application:
```base
php artisan key:generate
```

### 8. Compile Frontend Assets
Compile the frontend assets with Vite:
```base
npm run build
```
Alternatively, for development mode with hot-reloading:
```base
npm run dev
```

### 9. Start the Development Server
Start the Laravel development server:
```base
php artisan serve
```
Your application will be accessible at http://localhost:8000.

### 10. Set Up Cron Jobs for Email Notifications
To ensure the email notifications are sent at 9 PM before the user's vaccination date, set up a cron job. Add the following to your server's cron configuration:
```bash
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
This will trigger Laravel's scheduler to run every minute.

### Usage
#### Registration
1. Users can register via the /register page by providing their NID and selecting a vaccine center.
2. The system will assign a vaccination date based on availability and capacity.
3. A confirmation email will be sent to the user with their scheduled vaccination date.
#### Check Vaccination Status
Users can check their vaccination status by entering their NID on the /search page. The system will display one of the following statuses:
- Not Registered: If the NID is not found, the user can follow a link to the registration page.
- Not Scheduled: If the user is registered but not yet scheduled for vaccination.
- Scheduled: If a vaccination date is set, it will be displayed.
- Vaccinated: If the vaccination date has passed, the system assumes the user is vaccinated.

#### View All Registrations
You can view all registered users with pagination by visiting the /registrations page. The page displays users' NIDs, vaccination status, and scheduled dates.

### Additional Notes
#### Optimizations for Large User Base
To handle a large number of users efficiently:

- Database Indexing: Add proper indexing on frequently searched columns such as nid and scheduled_date.
- Caching: Implement caching for common database queries (e.g., center limits, user status).
- Queueing: Use Laravel queues to handle bulk email notifications efficiently.

### License
This project is open-source and available under the MIT License.


