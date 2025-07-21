<p align="center">
  <img src="https://raw.githubusercontent.com/RzlAm/incomex/refs/heads/main/public/web-app-manifest-512x512.png" alt="Incomex Logo" width="100" height="100" />
</p>

<h1 align="center">Incomex</h1>
<p align="center"><i>Personal daily income and expense tracker</i></p>

<p align="center">
  <a href="https://github.com/RzlAm/incomex/stargazers"><img src="https://img.shields.io/github/stars/RzlAm/incomex?style=social" alt="Stars"></a>
  <a href="https://github.com/RzlAm/incomex/network/members"><img src="https://img.shields.io/github/forks/RzlAm/incomex?style=social" alt="Forks"></a>
  <a href="https://github.com/RzlAm/incomex/graphs/contributors"><img src="https://img.shields.io/github/contributors/RzlAm/incomex" alt="Contributors"></a>
  <br>
  <a href="https://github.com/RzlAm/incomex/issues"><img src="https://img.shields.io/github/issues/RzlAm/incomex" alt="Issues"></a>
  <a href="https://github.com/RzlAm/incomex/blob/main/LICENSE"><img src="https://img.shields.io/github/license/RzlAm/incomex" alt="License"></a>
  <a href="https://trakteer.id/rzlam/tip"><img src="https://img.shields.io/badge/Donate-Trakteer-orange" alt="Donate"></a>
</p>

---

## 🧾 About Incomex

**Incomex** is a web app for tracking your daily income and expenses with ease. It supports multiple wallets and provides basic statistics to help you manage your finances.

---

## ✨ Features

-   🔐 Single-user support
-   👛 Custom wallets
-   📊 Basic financial statistics
-   🌍 Timezone and currency configuration
-   🏷️ Custom categories
-   💯 100% open source

---

## 🚀 Installation

Incomex is self-hosted only. You can run it locally or on your preferred hosting service.

### 📥 Installation Steps

1. **Clone the repository**
    ```bash
    git clone https://github.com/RzlAm/incomex
    cd incomex
    ```
2. Copy the .env file
    ```bash
    php -r "file_exists('.env') || copy('.env.example', '.env');"
    ```
3. Generate the app key
    ```bash
    php artisan key:generate
    ```
4. Configure `.env`
   Example setup:

    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=incomex
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. Install dependencies
    ```bash
    composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
    ```
6. Optimize Filament
    ```bash
    php artisan filament:optimize
    ```
7. Run database migration and seed
    ```bash
    php artisan migrate:fresh --seed
    ```
8. Start the application
    ```bash
    php artisan serve
    ```
9. Open `http://localhost:8000` in your browser.

---

## 🤝 Contributing

1. Fork this repository
2. Clone your fork locally
3. Create a new branch for your feature/fix
4. Make your changes and commit them
5. Push your branch to your fork
6. Create a Pull Request to the main repo

📝 Feel free to open Issues for feature requests, questions, or discussions.

---

## 📄 License

This project is licensed under the [MIT License](https://github.com/RzlAm/incomex/blob/main/LICENSE)

---

☕ Support Us

Like this project? Consider supporting us on [Trakteer](https://trakteer.id/rzlam/tip) 😄
