<?php
$company = \App\Company::first();
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Project::class, function (Faker\Generator $faker) use ($company) {

    return [
        'company_id' => $company->id,
        'project_name' => $faker->text(20),
        'feedback' => $faker->text(150),
        'project_summary' => 'Obcaecati doloremque consectetur, dolore aute non dolor odio ut aut sed et illo laudantium, aliqua. Minus esse excepturi esse aliquip excepteur labore elit, qui omnis voluptas aut dolorum magnam doloremque irure ut veritatis exercitationem aut occaecat qui praesentium quas sed cum elit, ratione exercitation placeat, pariatur? Quas consectetur, tempor incidunt, aliquid voluptatem, velit mollit et illum, adipisicing ea officia aliquam placeat, laborum. In libero natus velit non est aut libero quo ducimus, voluptate officiis est, ut rem aut quam optio, deleniti.',
        'start_date' => \Carbon\Carbon::now()->subDays(3)->format('Y-m-d'),
        'deadline' => \Carbon\Carbon::now()->addDays(8)->format('Y-m-d'),
        'notes' => 'Quas consectetur, tempor incidunt, aliquid voluptatem, velit mollit et illum, adipisicing ea officia aliquam placeat',
        'completion_percent' => $faker->randomElement(['20', '40', '60', '80']),
    ];
});


