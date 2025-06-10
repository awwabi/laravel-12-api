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
    git clone <repository-url>
    cd laravel-simple-api
    ```

2. **Install Dependencies**
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Environment Setup**
    Copy the `.env.example` file to create your own `.env` configuration:
    ```bash
    cp .env.example .env
    ```
    Modify the necessary environment variables.

4. **Run Migrations**
    ```bash
    php artisan migrate
    ```

5. **Run Tests**
    Execute the test suite to ensure everything is working:
    ```bash
    php artisan test
    ```

## How to Run this API Locally using Docker

- [ ] Setup Docker configuration for local development

## API Endpoints

- **Register New User**: POST `/api/register`
- **Retrieve User Info**: GET `/api/user/{id}`

## Conclusion

This API is built to be robust, maintainable, and scalable, utilizing modern PHP practices and architectural patterns. 
