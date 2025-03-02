# E-commerce API

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

🔗 **(https://drive.google.com/file/d/16IUCNmHMlRJtvq2FgcmW9Rw6MvVrRaQG/view?usp=drive_link**

## API Endpoints

### **Authentication**

| Method | Endpoint        | Description         |
|--------|---------------|---------------------|
| `POST` | `/api/register` | Register a new user |
| `POST` | `/api/login` | Authenticate user |
| `GET`  | `/api/user` | Retrieve authenticated user details |
| `POST` | `/api/logout` | Logout user |

**Example Request:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Example Response:**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "token": "abcdef123456"
  }
}
```

---

### **Category Management**

| Method | Endpoint             | Description |
|--------|----------------------|-------------|
| `GET`  | `/api/categories`    | Retrieve all categories |
| `POST` | `/api/categories`    | Create a new category |
| `GET`  | `/api/categories/{id}` | Retrieve category by ID |
| `PUT`  | `/api/categories/{id}` | Update category details |
| `DELETE` | `/api/categories/{id}` | Delete a category |

**Example Response:**
```json
{
  "id": 1,
  "name": "Electronics",
  "description": "All electronic items",
  "image": "electronics.jpg",
  "status": "active"
}
```

---

### **Product Management**

| Method | Endpoint            | Description |
|--------|--------------------|-------------|
| `GET`  | `/api/products`   | Retrieve all products |
| `POST` | `/api/products`   | Create a new product |
| `GET`  | `/api/products/{id}` | Retrieve product by ID |
| `PUT`  | `/api/products/{id}` | Update product details |
| `DELETE` | `/api/products/{id}` | Delete a product |

**Example Response:**
```json
{
  "id": 1,
  "name": "iPhone 15",
  "description": "Latest Apple iPhone",
  "price": 1200,
  "discounted_price": 1100,
  "quantity": 50,
  "status": "active"
}
```

---

### **Shopping Cart**

| Method | Endpoint            | Description |
|--------|--------------------|-------------|
| `POST` | `/api/cart`       | Add a product to the cart |
| `GET`  | `/api/cart`       | Retrieve all cart items |
| `PUT`  | `/api/cart/{id}`  | Update cart item quantity |
| `DELETE` | `/api/cart/{id}` | Remove a product from the cart |
| `POST` | `/api/cart/clear` | Clear the cart |

**Example Response:**
```json
{
  "cart": [
    {
      "product_id": 1,
      "name": "iPhone 15",
      "quantity": 2,
      "price": 2200
    }
  ],
  "total": 2200
}
```

---

### **Order & Checkout**

| Method | Endpoint           | Description |
|--------|-------------------|-------------|
| `POST` | `/api/orders`     | Create a new order |
| `GET`  | `/api/orders`     | Retrieve all orders for a user |
| `GET`  | `/api/orders/{id}` | Retrieve order details |
| `PUT`  | `/api/orders/status/{id}` | Update order status |

**Example Response:**
```json
{
  "order_number": "ORD12345",
  "user": "John Doe",
  "products": [
    { "name": "iPhone 15", "quantity": 1, "price": 1100 }
  ],
  "status": "pending",
  "total_price": 1100
}
```

---

