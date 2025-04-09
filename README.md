# Dartom Barbería

A modern web platform for a traditional barbershop — built with Laravel and Tailwind CSS.

## Description

Dartom Barbería is a full-stack web application developed for a traditional barbershop located in Mar del Plata. The project was designed to modernize the client experience by allowing online appointment bookings, while also simplifying management tasks for the business through a centralized admin interface.

The platform was developed using Laravel, MySQL, and Tailwind CSS, with a strong focus on responsive design, usability, and modern frontend interaction.

## Features

### 🧑 For Clients

- 📅 Schedule appointments
- ❌ Cancel appointments
- 📋 View appointment history
- ✏️ Edit personal profile

### 🛠️ For Administrators

- 🧔 Manage barbers
- 📅 Manage appointments

### 🔐 Access & Security

- 🛡️ Role-based access control
- 🔐 Secure authentication with Laravel Breeze
- 🛡️ CSRF protection and session security using Laravel’s built-in features
- ✉️ Email verification enforcement

### 💻 UI & UX

- ⚙️ Fully responsive design
- 🧠 Accessibility best practices
- 🎬 Smooth animations using AOS and Alpine.js

## Tech Stack

- **Laravel** – Backend framework
- **MySQL** – Relational database
- **Tailwind CSS** – Utility-first CSS framework
- **Laravel Breeze** – Lightweight authentication starter kit
- **Alpine.js** – Minimal JavaScript framework for interactivity
- **AOS (Animate On Scroll)** – Library for scroll animations

## Prerequisites

Make sure you have the following installed on your machine:

- PHP 8.1 or higher
- Composer
- MySQL or a compatible database
- Node.js and npm
- Git

## Installation and usage

Follow these steps to set up the project locally:

### 1. **Clone the repository**

```bash
git clone https://github.com/federicogildemuro/dartom.git
cd dartom
```

### 2. **Install dependencies**

```bash
composer install
npm install
```

### 3. **Copy the example environment file and update it with your local configuration**

```bash
cp .env.example .env
```

Then edit the .env file to set your environment-specific settings.

### 4. **Generate application key**

```bash
php artisan key:generate
```

### 5. **Create the database**

Create a MySQL database (e.g., `dartom`) and update the `.env` file with the correct database credentials:

```env
DB_DATABASE=dartom
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### 6. **Run migrations and seeders**

This will create the necessary tables and populate them with initial data (such as admin users and barbers):

```bash
php artisan migrate --seed
```

### 7. **Run the development server**

```bash
php artisan serve
```

### 8. **Build frontend assets**

```bash
npm run dev
```

Your application should now be running at `http://localhost:8000`.

## Contributing

Contributions are welcome! If you find a bug or have suggestions, feel free to create an issue or submit a pull request.

## Author

This project was developed by Federico Gil de Muro.

## License

Licensed under the [MIT License](LICENSE).
