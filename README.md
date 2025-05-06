
Built by https://www.blackbox.ai

---

# Project Name

## Project Overview
This project is a web application that provides various functionalities, including user authentication, a product dashboard, cart management, subscriptions, payments, order management, and address handling. Built with PHP, this application manages routing through a structured routing system, handling different requests via controllers.

## Installation
To get started with this project, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/your-repo.git
   cd your-repo
   ```

2. **Set up your environment:**
   - Ensure that you have PHP installed on your machine.
   - Create a `.env` file or make necessary configuration settings in `config/config.php`.

3. **Configure database settings:**
   - Update the database connection details in `config/database.php`.

4. **Run the application:**
   - You can start a local PHP server by executing:
     ```bash
     php -S localhost:8000 index.php
     ```

5. **Access the application:**
   - Open your web browser and navigate to `http://localhost:8000`.

## Usage
Once the application is running, you can use the following endpoints for various functionalities:

- **Authentication**
  - GET `/login` - Show login page
  - POST `/login/otp/send` - Send OTP
  - POST `/login/otp/verify` - Verify OTP
  - GET `/logout` - Log out user
  
- **Dashboard**
  - GET `/dashboard` - Access dashboard
  - GET `/products` - List products
  - GET `/product/{id}` - View product details

- **Cart Management**
  - GET `/cart` - View cart
  - POST `/cart/add` - Add item to cart
  - POST `/cart/remove` - Remove item from cart
  
- **Order Management**
  - GET `/orders` - List orders
  - POST `/order/create` - Create a new order

... and more, as defined in the routing configuration.

## Features
- User authentication with OTP and Truecaller integration
- Product catalog and details viewing
- Cart functionalities including addition, removal, and quantity updates
- Subscription management
- Payment processing and wallet management
- Order tracking and management
- Address management including adding, updating, and deleting addresses
- User referral system
- Delivery partner updates

## Dependencies
This project relies heavily on PHP for server-side scripting and may use a few additional libraries which are often defined in `composer.json`. However, since there were no libraries found in the provided `package.json`, please ensure to check for any PHP dependencies that might enhance your development experience as needed.

## Project Structure
The application is structured as follows:

```
├── config
│   ├── config.php           # Configuration settings
│   └── database.php         # Database connection settings
├── controllers              # Directory for controller classes
│   ├── AuthController.php
│   ├── CartController.php
│   ├── DashboardController.php
│   ├── OrderController.php
│   ├── ProductController.php
│   ├── PaymentController.php
│   ├── SubscriptionController.php
│   ├── AddressController.php
│   ├── ReferralController.php
│   └── DeliveryController.php
├── utilities
│   └── ErrorHandler.php      # Error handling utility
├── routes.php               # Application routing logic
└── index.php                # Main entry point of the application
```

Feel free to explore and modify the project as needed. Fork it, contribute, or customize it for your use! Enjoy building web applications with PHP.