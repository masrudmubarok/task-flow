# Task Flow API Project

This document outlines how to set up and use the API for the timesheet project.

---

## Setup

### Requirements
- PHP >= 8.1
- Composer 2.7.1
- MySQL >= 8..0

### Clone the Project
```bash
git clone https://github.com/masrudmubarok/task-flow.git
cd task-flow
```

### Install Composer Dependencies
```bash
composer install
```

### Copy the .env File
```bash
cp .env.example .env
```

### Configure .env
Adjust database configurations like `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_DATABASE`.
Customize other configurations as needed.

### Generate Application Key
```bash
php artisan key:generate
```

### Run Database Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

### Install Passport
```bash
php artisan passport:client --personal
```

### Start the Development Server
```bash
php artisan serve
```

---

## API Documentation

### Authentication

#### Register
**POST** `/api/register`
- Parameters: `first_name`, `last_name`, `email`, `password`

#### Login
**POST** `/api/login`
- Parameters: `email`, `password`

#### Logout
**POST** `/api/logout`
- Header: `Authorization: Bearer [token]`

---

### Project

#### List Projects
**GET** `/api/project`
- Header: `Authorization: Bearer [token]`

#### Project Detail
**GET** `/api/project/{id}`
- Header: `Authorization: Bearer [token]`

#### Create Project
**POST** `/api/project`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `status`, `attributes` (array)

#### Update Project
**PUT** `/api/project/{id}`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `status`, `attributes` (array)

#### Delete Project
**DELETE** `/api/project/{id}`
- Header: `Authorization: Bearer [token]`

#### Filter Projects
**GET** `/api/project/filter`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `status`, `start_date`, `end_date`, `department`, `sort_by`, `sort_order`

---

### Timesheet

#### List Timesheets
**GET** `/api/timesheet`
- Header: `Authorization: Bearer [token]`

#### Timesheet Detail
**GET** `/api/timesheet/{id}`
- Header: `Authorization: Bearer [token]`

#### Create Timesheet
**POST** `/api/timesheet`
- Header: `Authorization: Bearer [token]`
- Parameters: `user_id`, `project_id`, `task_name`, `date`, `hours`

#### Update Timesheet
**PUT** `/api/timesheet/{id}`
- Header: `Authorization: Bearer [token]`
- Parameters: `user_id`, `project_id`, `task_name`, `date`, `hours`

#### Delete Timesheet
**DELETE** `/api/timesheet/{id}`
- Header: `Authorization: Bearer [token]`

---

### Attribute

#### List Attributes
**GET** `/api/attribute`
- Header: `Authorization: Bearer [token]`

#### Attribute Detail
**GET** `/api/attribute/{id}`
- Header: `Authorization: Bearer [token]`

#### Create Attribute
**POST** `/api/attribute`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `type`

#### Update Attribute
**PUT** `/api/attribute/{id}`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `type`

#### Delete Attribute
**DELETE** `/api/attribute/{id}`
- Header: `Authorization: Bearer [token]`

---

## Notes
- Ensure the Laravel server is running while testing the API.
- Adjust the `.env` configuration according to your environment.
- This documentation may be updated to reflect changes to the API.