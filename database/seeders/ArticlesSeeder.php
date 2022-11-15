<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'title' => 'Laravel 9.0',
            'content' => 'As you may know, Laravel transitioned to yearly releases with the release of Laravel 8. Previously, major versions were released every 6 months. This transition is intended to ease the maintenance burden on the community and challenge our development team to ship amazing, powerful new features without introducing breaking changes. Therefore, we have shipped a variety of robust features to Laravel 8 without breaking backwards compatibility, such as parallel testing support, improved Breeze starter kits, HTTP client improvements, and even new Eloquent relationship types such as "has one of many".

            Therefore, this commitment to ship great new features during the current release will likely lead to future "major" releases being primarily used for "maintenance" tasks such as upgrading upstream dependencies, which can be seen in these release notes.
            
            Laravel 9 continues the improvements made in Laravel 8.x by introducing support for Symfony 6.0 components, Symfony Mailer, Flysystem 3.0, improved route:list output, a Laravel Scout database driver, new Eloquent accessor / mutator syntax, implicit route bindings via Enums, and a variety of other bug fixes and usability improvements.',
            'image' => 'uploads/articles/example.png',
            'users_id' => '1',
            'categories_id' => '1',

        ]);
    }
}
