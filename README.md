# Multi-Tenant Company Dashboard

A full-stack web application with role-based access control, company-based theming, and hierarchical module permissions.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)
![React](https://img.shields.io/badge/React-18-blue.svg)
![Docker](https://img.shields.io/badge/Docker-Ready-brightgreen.svg)

## 🚀 Features

- ✅ **Multi-tenant Architecture** - Multiple companies with isolated data
- ✅ **Dynamic Theming** - Company-based color schemes applied on login
- ✅ **Company Branding** - Logo support with fallback to company name
- ✅ **Role-Based Access Control** - Hierarchical permissions (System → Module → Submodule)
- ✅ **Token Authentication** - Laravel Sanctum for secure API access
- ✅ **Responsive UI** - Modern React interface with expandable navigation
- ✅ **Search Functionality** - Real-time module search and filtering
- ✅ **Docker Containerized** - Easy setup and deployment
- ✅ **Enhanced Visibility** - Improved UI elements for better contrast

## 🏗️ Tech Stack

### Backend
- **Laravel 12** - PHP framework
- **PostgreSQL** - Database
- **Laravel Sanctum** - API authentication
- **PHP 8.3** - Language version

### Frontend
- **React 18** - UI library
- **React Router** - Navigation
- **Axios** - HTTP client
- **CSS3** - Styling with CSS variables for theming

### DevOps
- **Docker** - Containerization
- **Docker Compose** - Multi-container orchestration

## 📋 Prerequisites

- Docker Desktop (version 20.10+)
- Git

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/companydashboard-app.git
cd companydashboard-app
```

### 2. Start Docker Containers

```bash
docker-compose up --build
```

This will:
- Build and start PostgreSQL, Laravel backend, and React frontend
- Install all dependencies
- Start all services

### 3. Run Database Migrations

Open a new terminal and run:

```bash
docker exec -it backend_app bash
php artisan migrate:fresh --seed
exit
```

### 4. Access the Application

- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8000
- **Database**: localhost:5432

## 🔐 Demo Credentials

### User 1 - Schnee Dust Company (Admin Access)
- **Username**: `weissschnee`
- **Password**: `Passw0rd!`
- **Company**: `Schnee Dust Company`
- **Theme**: Light blue/cyan colors
- **Access**: 10 submodules (full admin access)

### User 2 - White Fang Group (Sales & Inventory)
- **Username**: `Adam`
- **Password**: `Passw0rd!`
- **Company**: `White Fang Group`
- **Theme**: Dark navy/red colors
- **Access**: 6 submodules (sales and inventory focused)

### User 3 - Generic Corp (Limited)
- **Username**: `testuser`
- **Password**: `Passw0rd!`
- **Company**: `Generic Corp`
- **Theme**: Default blue colors
- **Access**: 2 submodules (limited access)

## 📁 Project Structure

```
companydashboard-app/
├── backend/              # Laravel API
│   ├── app/
│   │   ├── Http/Controllers/
│   │   └── Models/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── routes/
│   │   └── api.php
│   └── Dockerfile
├── frontend/             # React App
│   ├── src/
│   │   ├── components/
│   │   ├── contexts/
│   │   ├── pages/
│   │   └── services/
│   ├── public/
│   └── Dockerfile
├── docker-compose.yml
└── README.md
```

## 🗄️ Database Schema

### Tables
- **companies** - Company information and theming
- **users** - User accounts
- **systems** - Top-level system categories
- **modules** - Feature modules within systems
- **submodules** - Individual features/pages
- **user_submodule** - Permission assignments

### Relationships
```
Company (1) ──── (N) Users
System (1) ──── (N) Modules
Module (1) ──── (N) Submodules
User (N) ──── (N) Submodules (via user_submodule pivot)
```

## 🔌 API Endpoints

### Public Routes
- `POST /api/login` - Authenticate user
- `GET /api/companies` - Get list of companies

### Protected Routes (require authentication)
- `POST /api/logout` - Logout current user
- `GET /api/user` - Get current user profile
- `GET /api/modules` - Get hierarchical modules for user
- `GET /api/validate` - Health check

## 🎨 Theming System

The application uses CSS variables for dynamic theming:

```css
:root {
  --primary-color: #3490dc;
  --accent-color: #667eea;
}
```

Colors are applied when a user logs in based on their company's configuration stored in the database.

## 🐳 Docker Commands

### Start services
```bash
docker-compose up
```

### Stop services
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f
```

### Rebuild containers
```bash
docker-compose up --build
```

### Access backend container
```bash
docker exec -it backend_app bash
```

### Run migrations
```bash
docker exec -it backend_app php artisan migrate
```

### Seed database
```bash
docker exec -it backend_app php artisan db:seed
```

## 🧪 Testing

### Test API Endpoints

Get companies:
```bash
curl http://localhost:8000/api/companies
```

Login:
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"weissschnee","password":"Passw0rd!","company_code":"SCHNEE"}'
```

## 📸 Screenshots

### Login Page
- Multi-company selection dropdown
- Credential validation
- Demo credentials displayed

### Dashboard
- Dynamic theming based on company colors
- Company logo display in header (with fallback to name badge)
- Hierarchical navigation tree
- Expandable modules and submodules
- Search functionality with real-time filtering
- User profile display with username
- High-contrast logout button for better visibility

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License.

## 👥 Authors

- Lachel03

## 🙏 Acknowledgments

- Laravel Framework
- React.js
- Docker
- PostgreSQL

## 📞 Support

For issues and questions, please open an issue in the GitHub repository.

---

**Made with ❤️ for educational purposes**