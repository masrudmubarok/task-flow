# Timesheet API Project

This document outlines how to set up and use the API for the timesheet project.

## Setup

### Requirements:
- PHP >= 8.1
- Composer
- MySQL

### Clone the Project:
```bash
git clone https://github.com/masrudmubarok/task-flow.git
cd task-flow
```

### Install Composer Dependencies:
```bash
composer install
```

### Copy the .env File:
```bash
cp .env.example .env
```

### Configure .env:
Adjust database configurations like `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_DATABASE`.
Customize other configurations as needed.

### Generate Application Key:
```bash
php artisan key:generate
```

### Run Database Migrations:
```bash
php artisan migrate
```

### Run Seeders (Optional):
```bash
php artisan db:seed
```

### Install Passport:
```bash
php artisan passport:install
```

### Start the Development Server:
```bash
php artisan serve
```

## API Documentation

### Authentication
#### Register:
**POST** `/api/register`
- Parameters: `first_name`, `last_name`, `email`, `password`

#### Login:
**POST** `/api/login`
- Parameters: `email`, `password`

#### Logout:
**POST** `/api/logout`
- Header: `Authorization: Bearer [token]`

### Projects
#### List Projects:
**GET** `/api/projects`
- Header: `Authorization: Bearer [token]`

#### Project Details:
**GET** `/api/projects/{id}`
- Header: `Authorization: Bearer [token]`

#### Create Project:
**POST** `/api/projects`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `status`, `attributes` (array)

#### Update Project:
**PUT** `/api/projects/{id}`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `status`, `attributes` (array)

#### Delete Project:
**DELETE** `/api/projects/{id}`
- Header: `Authorization: Bearer [token]`

#### Filter Projects:
**GET** `/api/projects/filter`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `status`, `start_date`, `end_date`, `department`, `sort_by`, `sort_order`

### Timesheets
#### List Timesheets:
**GET** `/api/timesheets`
- Header: `Authorization: Bearer [token]`

#### Timesheet Details:
**GET** `/api/timesheets/{id}`
- Header: `Authorization: Bearer [token]`

#### Create Timesheet:
**POST** `/api/timesheets`
- Header: `Authorization: Bearer [token]`
- Parameters: `user_id`, `project_id`, `task_name`, `date`, `hours`

#### Update Timesheet:
**PUT** `/api/timesheets/{id}`
- Header: `Authorization: Bearer [token]`
- Parameters: `user_id`, `project_id`, `task_name`, `date`, `hours`

#### Delete Timesheet:
**DELETE** `/api/timesheets/{id}`
- Header: `Authorization: Bearer [token]`

### Attributes
#### List Attributes:
**GET** `/api/attributes`
- Header: `Authorization: Bearer [token]`

#### Attribute Details:
**GET** `/api/attributes/{id}`
- Header: `Authorization: Bearer [token]`

#### Create Attribute:
**POST** `/api/attributes`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `type`

#### Update Attribute:
**PUT** `/api/attributes/{id}`
- Header: `Authorization: Bearer [token]`
- Parameters: `name`, `type`

#### Delete Attribute:
**DELETE** `/api/attributes/{id}`
- Header: `Authorization: Bearer [token]`

### Attribute Values
#### List Attribute Values:
**GET** `/api/attribute-values`
- Header: `Authorization: Bearer [token]`

#### Attribute Value Details:
**GET** `/api/attribute-values/{id}`
- Header: `Authorization: Bearer [token]`

#### Create Attribute Value:
**POST** `/api/attribute-values`
- Header: `Authorization: Bearer [token]`
- Parameters: `attribute_id`, `entity_id`, `value`

#### Update Attribute Value:
**PUT** `/api/attribute-values/{id}`
- Header: `Authorization: Bearer [token]`
- Parameters: `attribute_id`, `entity_id`, `value`

#### Delete Attribute Value:
**DELETE** `/api/attribute-values/{id}`
- Header: `Authorization: Bearer [token]`

### Test Other Endpoints:
- Use the other API endpoints to test the application's functionality.
- Inspect the API responses to ensure the returned data is as expected.

## Notes
- Ensure the Laravel server is running while testing the API.
- Adjust the `.env` configuration according to your environment.
- This documentation may be updated to reflect changes to the API.