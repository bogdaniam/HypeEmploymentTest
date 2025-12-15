# User Authentication System (PHP)

This project is a simple yet secure user authentication system built with PHP and MySQL. It includes user signup, login, a dashboard, and demonstrates key security best practices. It was created to fulfill a technical test assessing PHP and web development fundamentals.

## Features

- **User Signup:** New users can register with a username, email, and password.
- **User Login:** Registered users can log in to access a protected dashboard.
- **Dashboard:** A successful login redirects to a dashboard that displays a list of all registered users.
- **Security:**
    - **Password Hashing:** Passwords are securely hashed using the modern `PASSWORD_ARGON2ID` algorithm.
    - **Cross-Site Scripting (XSS) Prevention:** All user-generated output is sanitized using `htmlspecialchars()` to prevent XSS attacks.
    - **Cross-Site Request Forgery (CSRF) Prevention:** Forms are protected with CSRF tokens to prevent unauthorized actions.
    - **SQL Injection Prevention:** Database queries are performed using prepared statements with PDO, eliminating the risk of SQL injection.
- **Dockerized Environment:** The entire application stack (PHP, Apache, MySQL) is containerized with Docker for easy setup and consistent deployment.

## Database Schema

The application uses a single table, `users`, with the following structure:

```sql
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## How to Run the Project

There are two ways to run this project: with Docker (recommended) or manually.

### Option 1: Setup with Docker (Recommended)

This is the simplest way to get the application running.

**Prerequisites:**
- [Docker](https://www.docker.com/get-started)

**Instructions:**
1. Clone this repository or download the source code.
2. Navigate to the project's root directory in your terminal.
3. Run the following command to build the Docker images and start the containers in the background:
   ```bash
   docker compose up --build -d
   ```
4. The application will be accessible at `http://localhost`.

### Option 2: Manual Setup (Without Docker)

If you cannot use Docker, you can run the project on a local server environment like XAMPP, WAMP, or MAMP.

**Prerequisites:**
- PHP (version 8.0 or newer)
- MySQL
- A web server (like Apache)

**Instructions:**
1. **Database Setup:**
   - Start your MySQL server.
   - Create a new database. You can name it `auth_system`.
   - Execute the SQL script from the `init.sql` file to create the `users` table in your new database.

2. **Application Configuration:**
   - Navigate to the `src/` directory.
   - Open the `db.php` file in a text editor.
   - Modify the database connection variables at the top of the file to match your local MySQL setup:
     ```php
     // src/db.php

     // ...
     $host = '127.0.0.1'; // Or your MySQL host
     $dbname = 'auth_system'; // The database name you created
     $user = 'root'; // Your MySQL username
     $pass = ''; // Your MySQL password
     // ...
     ```

3. **Run the Application:**
   - Place the entire project folder in the web root of your local server (e.g., `htdocs` for XAMPP).
   - Start your Apache and MySQL services from your server's control panel.
   - Open your web browser and navigate to the project's directory, for example: `http://localhost/hype-test/src/`.

---

**Note on `HTTP` Protocole:** For this project's local development and testing phase, the HTTP protocol was used for the following reasons:

   - Simplicity: It simplifies the initial setup, allowing developers to run the application quickly without the need to configure SSL certificates for a local-only environment.
   - Controlled Environment: The development server runs on localhost, meaning it is only accessible from the local machine. It is not exposed to the public internet, which mitigates the risk of external threats.
   - No Sensitive Data: The local instance is intended for functionality testing and typically operates with test data, not real user credentials or sensitive information.


**Note on `.env` file:** For the convenience of this technical test, the `.env` file is included in the project. Please be aware that in a real-world production environment, this file should **never** be committed to version control or included in a project archive, as it contains sensitive credentials. It is included here solely to make the evaluation process as smooth as possible.