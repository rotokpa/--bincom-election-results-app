# Bincom Election Results Application

A web-based election results management application built with **PHP, Laravel, and MySQL** as part of the Bincom technical assessment.

The application allows users to view polling-unit election results, retrieve aggregated election results by Local Government Area (LGA), and submit new polling-unit results with party scores.

## Live Demo

**[View Live Application](https://bincom-election-results-app-production.up.railway.app/)**

## Features

### 1. Individual Polling-Unit Results
- Retrieve election results for an individual polling unit.
- Display the polling-unit details and associated party scores.

### 2. LGA Aggregated Results
- View election results aggregated by Local Government Area.
- Calculate and display total votes for political parties across polling units within an LGA.

### 3. Add New Polling-Unit Results
- Submit new polling-unit information.
- Associate a polling unit with an existing ward and LGA.
- Enter election scores for multiple political parties.
- Save polling-unit details and party results to the database.

## Technologies Used

- **PHP 8.3** – Backend programming language
- **Laravel** – PHP web application framework
- **MySQL** – Relational database management system
- **HTML** – Web page structure
- **Git and GitHub** – Version control and source code management
- **Railway** – Application deployment and hosting

## Database

The application uses MySQL and the `bincom_test` database.

Election data is organized into related tables containing polling-unit information, wards, LGAs, and party election results.

## Installation and Setup

### Prerequisites

- PHP 8.3 or compatible version
- Composer
- MySQL
- Git

### 1. Clone the repository

```bash
git clone https://github.com/rotokpa/--bincom-election-results-app.git
```

### 2. Navigate into the project

```bash
cd --bincom-election-results-app
```

### 3. Install dependencies

```bash
composer install
```

### 4. Configure environment variables

Copy the example environment file:

```bash
cp .env.example .env
```

Update the database configuration in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bincom_test
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password
```

Import the provided election database SQL dump into MySQL before running the application.

### 5. Generate the application key

```bash
php artisan key:generate
```

### 6. Start the development server

```bash
php artisan serve
```

Open the application at:

```text
http://127.0.0.1:8000
```

## Application Routes

| Route | Description |
|---|---|
| `/` | Redirects to LGA results |
| `/polling-units/{id}` | Displays individual polling-unit results |
| `/lga-results` | Displays aggregated LGA results |
| `/polling-units/create` | Form for adding polling-unit results |

## Deployment

The application is deployed on Railway and connected to the GitHub repository for deployment updates.

**Live URL:** https://bincom-election-results-app-production.up.railway.app/

## Author

**Raymond Orinya Otokpa**

- GitHub: [@rotokpa](https://github.com/rotokpa)

---
