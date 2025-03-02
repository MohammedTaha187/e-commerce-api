# E-commerce API

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## About the Project

This is a RESTful API for an E-commerce platform built with Laravel. The API allows users to register, log in, manage products, categories, cart, and orders. It includes authentication via Laravel Sanctum, role-based access control, and payment integration with PayPal and Stripe.

## Features
- **User Authentication** (Register, Login, Logout, Google OAuth)
- **Category Management** (CRUD operations)
- **Product Management** (CRUD operations with filtering and pagination)
- **Shopping Cart Management** (Add, Update, Delete, Clear)
- **Order & Checkout** (Order creation, payment handling via Stripe & PayPal)
- **Role-Based Access Control (RBAC)**
- **Localization** (Support for English and Arabic via Accept-Language header)
- **API Documentation via Postman Collection**

## Installation

```sh
git clone your-repo-link.git
cd your-project-folder
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## API Documentation

You can test the API using Postman:

🔗 (https://drive.google.com/file/d/16IUCNmHMlRJtvq2FgcmW9Rw6MvVrRaQG/view?usp=drive_link)]

## API Endpoints

| Method | Endpoint | Description |
|--------|------------|-------------|
| `POST` | `/api/register` | Register a new user |
| `POST` | `/api/login` | Authenticate user |
| `GET` | `/api/user` | Retrieve authenticated user details |
| `POST` | `/api/products` | Create a new product |
| `GET` | `/api/products` | Retrieve all products |
| `PUT` | `/api/products/{id}` | Update product details |
| `DELETE` | `/api/products/{id}` | Delete a product |
| `POST` | `/api/orders` | Create a new order |
| ... | ... | ... |

## License



