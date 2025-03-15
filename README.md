# Timesheet API Project

This document outlines how to set up and use the API for the timesheet project.

## Setup

1.  **Requirements:**
    * PHP >= 8.1
    * Composer
    * MySQL

2.  **Clone the Project:**

    ```bash
    git clone https://github.com/masrudmubarok/task-flow.git
    cd task-flow
    ```

3.  **Install Composer Dependencies:**

    ```bash
    composer install
    ```

4.  **Copy the `.env` File:**

    ```bash
    cp .env.example .env
    ```

5.  **Configure `.env`:**

    * Adjust database configurations like `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_DATABASE`.
    * Customize other configurations as needed.

6.  **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

7.  **Run Database Migrations:**

    ```bash
    php artisan migrate
    ```

8.  **Run Seeders (Optional):**

    ```bash
    php artisan db:seed
    ```

9. **Start the Development Server:**

    ```bash
    php artisan serve
    ```

## API Documentation

### Authentication

* **Register:**
    * `POST /api/register`
    * Parameters: `first_name`, `last_name`, `email`, `password`
* **Login:**
    * `POST /api/login`
    * Parameters: `email`, `password`
* **Logout:**
    * `POST /api/logout`
    * Header: `Authorization: Bearer [token]`

### Projects

* **List Projects:**
    * `GET /api/projects`
* **Project Details:**
    * `GET /api/projects/{id}`
* **Create Project:**
    * `POST /api/projects`
    * Parameters: `name`, `status`, `attributes` (array)
* **Update Project:**
    * `PUT /api/projects/{id}`
    * Parameters: `name`, `status`, `attributes` (array)
* **Delete Project:**
    * `DELETE /api/projects/{id}`
* **Filter Projects:**
    * `GET /api/projects/filter`
    * Parameters: `name`, `status`, `start_date`, `end_date`, `department`, `sort_by`, `sort_order`

### Timesheets

* **List Timesheets:**
    * `GET /api/timesheets`
* **Timesheet Details:**
    * `GET /api/timesheets/{id}`
* **Create Timesheet:**
    * `POST /api/timesheets`
    * Parameters: `user_id`, `project_id`, `task_name`, `date`, `hours`
* **Update Timesheet:**
    * `PUT /api/timesheets/{id}`
    * Parameters: `user_id`, `project_id`, `task_name`, `date`, `hours`
* **Delete Timesheet:**
    * `DELETE /api/timesheets/{id}`

### Attributes

* **List Attributes:**
    * `GET /api/attributes`
* **Attribute Details:**
    * `GET /api/attributes/{id}`
* **Create Attribute:**
    * `POST /api/attributes`
    * Parameters: `name`, `type`
* **Update Attribute:**
    * `PUT /api/attributes/{id}`
    * Parameters: `name`, `type`
* **Delete Attribute:**
    * `DELETE /api/attributes/{id}`

### Attribute Values

* **List Attribute Values:**
    * `GET /api/attribute-values`
* **Attribute Value Details:**
    * `GET /api/attribute-values/{id}`
* **Create Attribute Value:**
    * `POST /api/attribute-values`
    * Parameters: `attribute_id`, `entity_id`, `value`
* **Update Attribute Value:**
    * `PUT /api/attribute-values/{id}`
    * Parameters: `attribute_id`, `entity_id`, `value`
* **Delete Attribute Value:**
    * `DELETE /api/attribute-values/{id}`

## API Testing with Postman

1.  **Install Postman:**
    * Download and install Postman from [www.getpostman.com](https://www.getpostman.com/).

2.  **Import Postman Collection (Optional):**
    * If a Postman collection file exists, import it into Postman.

3.  **Test Authentication:**
    * Use the `POST /api/register` endpoint to register a new user.
    * Use the `POST /api/login` endpoint to obtain an authentication token.
    * Copy the authentication token.
    * Set the `Authorization: Bearer [token]` header for requests that require authentication.

4.  **Test Other Endpoints:**
    * Use the other API endpoints to test the application's functionality.
    * Inspect the API responses to ensure the returned data is as expected.

## Notes

* Ensure the Laravel server is running while testing the API.
* Adjust the `.env` configuration according to your environment.
* This documentation may be updated to reflect changes to the API.