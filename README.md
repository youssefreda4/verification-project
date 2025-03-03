<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Verification Techniques with Laravel Breeze

This project implements various **Verification Techniques** in a Laravel application using **Breeze** for authentication.

## Features
- **Email Verification**
- **Custom Token Verification (CVT)**
- **Passwordless Authentication**
- **OTP (One-Time Password) using Twilio**
- **Google reCAPTCHA (V2, V3)**

## Installation
### Prerequisites
- PHP >= 8.1
- Composer
- Laravel 10+
- Node.js & npm (for frontend assets)
- Twilio account (for OTP verification)
- Google reCAPTCHA API keys

### Setup
1. **Clone the repository**
   ```sh
   git clone https://github.com/your-username/your-repo.git](https://github.com/youssefreda4/verification-project.git
   cd your-repo
   ```

2. **Install dependencies**
   ```sh
   composer install
   npm install && npm run dev
   ```

3. **Configure environment**
   Copy the `.env.example` file and update the required environment variables:
   ```sh
   cp .env.example .env
   ```
   Update the following in your `.env` file:
   ```env
   APP_URL=http://localhost
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.example.com
   MAIL_PORT=587
   MAIL_USERNAME=your_email@example.com
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_email@example.com
   
   TWILIO_SID=your_twilio_sid
   TWILIO_AUTH_TOKEN=your_twilio_auth_token
   TWILIO_PHONE_NUMBER=your_twilio_phone_number
   
   RECAPTCHA_SITE_KEY=your_google_recaptcha_site_key
   RECAPTCHA_SECRET_KEY=your_google_recaptcha_secret_key
   ```

4. **Run migrations**
   ```sh
   php artisan migrate
   ```

5. **Run the development server**
   ```sh
   php artisan serve
   ```

## Usage
- **Email Verification**: Laravel Breeze provides built-in email verification. Users will receive a verification email after registration.
- **Custom Token Verification (CVT)**: A unique token is generated and sent to the user's email for verification.
- **Passwordless Authentication**: Users can log in using an email link instead of a password.
- **OTP Verification using Twilio**: Users receive a one-time password (OTP) via SMS to authenticate.
- **Google reCAPTCHA**: Added to login and registration forms for spam protection.

## License
This project is open-source and available under the [MIT License](LICENSE).
