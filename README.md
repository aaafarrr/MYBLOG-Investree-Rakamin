
# MY BLOG - Investree Fullstack Developer - Rakamin.com
## Virtual Internship Program

Blog application development project using laravel.

## Installation

Clone the project
```bash
  git clone https://link-to-project
```

Go to the project directory
```bash
  cd my-project
```

Install Dependencies
```bash
  composer install
  composer update
```

Configure .env
```bash
  cp .env.example .env
```

Migration with seeders and Passport installation
```bash
  php artisan migrate --seed
  php artisan passport:install
```





## Usage

```bash
  php artisan serve
```


## API Reference

#### API Prefix

```http
  /api/v1/
```

#### Login

```http
  POST /api/v1/auth/login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email`      | `string` | **Required**. Email Address.|
| `password`      | `string` | **Required**. Password Account.|

#### Another example of using API in a test case file


## Screenshots

![App Screenshot](https://via.placeholder.com/468x300?text=App+Screenshot+Here)

