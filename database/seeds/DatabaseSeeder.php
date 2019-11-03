<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {

        $this->call(GlobalCurrencySeeder::class);
        $this->call(GlobalSettingTableSeeder::class);
        $this->call(PackageTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(EmailSettingSeeder::class);
        // $this->call(FrontSeeder::class);

        if (!App::environment('codecanyon')) {
            $this->call(ProjectSeeder::class);
        }
    }

}
