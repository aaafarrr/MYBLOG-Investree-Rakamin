
# MY BLOG - Investree Fullstack Developer - Rakamin.com
## Virtual Internship Experience (Investree) - Fullstack - Farhan Al Fayyadh

Blog application development project using laravel.

## Installation

Clone the project
```bash
git clone https://github.com/aaafarrr/MYBLOG-Investree-Rakamin.git
```

Go to the project directory
```bash
cd MYBLOG-Investree-Rakamin
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
php artisan key:generate
```

## Usage

```bash
php artisan serve
```

## Demo

```bash
Email: admin@example.com
Password: password
```

## API Reference

#### API Prefix

```bash
/api/v1/
```

#### Login

```bash
POST /api/v1/auth/login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email`      | `string` | **Required**. Email Address.|
| `password`      | `string` | **Required**. Password Account.|

#### Another example of using API in a [Postman Collection](https://raw.githubusercontent.com/aaafarrr/MYBLOG-Investree-Rakamin/main/testcase/MY%20BLOG.postman_collection.json)


## Screenshots

![BLOG HOME](https://github.com/aaafarrr/MYBLOG-Investree-Rakamin/blob/main/testcase/blog-home.png?raw=true)
![LOGIN](https://github.com/aaafarrr/MYBLOG-Investree-Rakamin/blob/main/testcase/login.png?raw=true)
![ADMIN HOME](https://github.com/aaafarrr/MYBLOG-Investree-Rakamin/blob/main/testcase/admin-home.png?raw=true)
![ADMIN ARTCLE](https://github.com/aaafarrr/MYBLOG-Investree-Rakamin/blob/main/testcase/admin-article.png?raw=true)
![ADMIN CATEGORY](https://github.com/aaafarrr/MYBLOG-Investree-Rakamin/blob/main/testcase/admin-category.png?raw=true)


## Documentation

[Postman Collection](https://raw.githubusercontent.com/aaafarrr/MYBLOG-Investree-Rakamin/main/testcase/MY%20BLOG.postman_collection.json)

