# Simple API for User Management

This project is a simple API for registering new users and retrieving user information. It was developed as a technical test for the Senior Fullstack PHP Engineer position at CheckProof.

## Technologies

- **Framework:** Laravel 12
- **Architecture:** Hexagonal Architecture with Domain-Driven Design (DDD)
- **Pattern:** CQRS (Command Query Responsibility Segregation)
- **Testing:** Both unit and feature tests for automation

## Project Structure

The project is organized following the principles of Hexagonal Architecture, aiming to separate core business logic from infrastructure concerns. This structure supports scalability and maintenance.

## Getting Started

1. **Clone the Repository**
    ```bash
    git clone git@github.com:awwabi/laravel-12-api.git
    cd laravel-simple-api
    ```

2. **Install Dependencies**
    ```bash
    composer install
    ```

3. **Environment Setup**
    Copy the `.env.example` file to create your own `.env` configuration:
    ```bash
    cp .env.example .env
    ```
    Modify the necessary environment variables.

4. **Run Migrations**
    ```bash
    php artisan migrate:fresh --seed
    ```

5. **Run Tests**
    Execute the test suite to ensure everything is working:
    ```bash
    php artisan test
    ```

## How to Get API Token
    Since we are not providing endpoint for login, we can get api token by execute this command:
    ```bash
    php artisan login:user {role}
    ```
    Available role: `user`, `manager`, `admin`

## API Endpoints

- **Register New User**: POST `/api/users`
```bash
curl --location 'localhost:8000/api/users' \
--header 'Authorization: Bearer {token}'
```
- **Retrieve User Info**: GET `/api/users`
```bash
curl --location 'localhost:8000/api/users' \
--header 'Authorization: Bearer {token}'
```

## Conclusion

This API is built to be robust, maintainable, and scalable, utilizing modern PHP practices and architectural patterns. 

## Email Test Result
- Email sent to admin:
![Screenshot](image.png)
- Email sent to new user:
![Screenshot](image-1.png)