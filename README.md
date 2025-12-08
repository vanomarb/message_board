# Message Board

A simple message board application built with CakePHP 2 framework as a learning project.

## 📋 About

This project was developed as my first hands-on experience learning the CakePHP 2 framework. It demonstrates basic CRUD operations, MVC architecture, and the fundamentals of building a web application with CakePHP.

## 🛠️ Tech Stack

- **Framework:** CakePHP 2.x
- **Language:** PHP
- **Database:** MySQL
- **Containerization:** Docker & Docker Compose
- **Frontend:** HTML, CSS, JavaScript

## 📂 Project Structure

```
message_board/
├── php/                    # PHP configuration and scripts
├── test_db-master/        # Database test files and schemas
├── workspace/             # CakePHP application workspace
│   ├── app/              # Main application folder
│   │   ├── Config/       # Configuration files
│   │   ├── Controller/   # Controllers
│   │   ├── Model/        # Models
│   │   ├── View/         # Views and templates
│   │   ├── webroot/      # Public files (CSS, JS, images)
│   │   └── tmp/          # Temporary files and cache
│   └── lib/              # CakePHP core libraries
├── docker-compose.yml     # Docker configuration
└── README.md             # This file
```

## 🚀 Getting Started

### Prerequisites

- Docker
- Docker Compose
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/vanomarb/message_board.git
   cd message_board
   ```

2. **Start Docker containers**
   ```bash
   docker-compose up -d
   ```

3. **Access the application**
   
   Open your browser and navigate to `http://localhost` (or the port specified in your docker-compose.yml)

4. **Database setup**
   
   The database schema and test data can be found in the `test_db-master/` directory. Import the SQL files to set up your database.

## 💡 Features

- Create, read, update, and delete messages
- User-friendly interface
- MVC architecture following CakePHP conventions
- Dockerized development environment

## 📚 Learning Objectives

This project helped me understand:

- **MVC Pattern:** Separation of concerns in web applications
- **CakePHP Conventions:** Naming conventions, file structure, and routing
- **Database Integration:** Using CakePHP's ORM for database operations
- **Docker:** Containerizing PHP applications for consistent development environments
- **CRUD Operations:** Implementing basic create, read, update, and delete functionality

## 🔧 Configuration

### Database Configuration

Edit `workspace/app/Config/database.php` to configure your database connection:

```php
public $default = array(
    'datasource' => 'Database/Mysql',
    'persistent' => false,
    'host' => 'localhost',
    'login' => 'your_username',
    'password' => 'your_password',
    'database' => 'your_database',
    'prefix' => '',
);
```

### Debug Mode

In `workspace/app/Config/core.php`, you can adjust the debug level:

```php
Configure::write('debug', 2); // Set to 0 for production
```

## 🐛 Known Issues

- This is a learning project and may not follow all production-ready best practices
- Security features may be minimal as this was built for educational purposes

## 📝 Notes

- This project uses CakePHP 2, which is now in maintenance mode. For new projects, consider using the latest version of CakePHP.
- The code structure follows CakePHP 2.x conventions and may differ from newer versions.

## 🤝 Contributing

This is a personal learning project, but suggestions and feedback are welcome! Feel free to:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/improvement`)
3. Commit your changes (`git commit -am 'Add some improvement'`)
4. Push to the branch (`git push origin feature/improvement`)
5. Create a Pull Request

## 📄 License

This project is open source and available for educational purposes.

## 👤 Author

**vanomarb**

- GitHub: [@vanomarb](https://github.com/vanomarb)

## 🙏 Acknowledgments

- CakePHP community and documentation
- All resources that helped me learn PHP and MVC frameworks

---

**Note:** This project was created as a learning exercise with CakePHP 2. The code represents my understanding and implementation at the time of learning and may contain areas for improvement.
