<?php

use App\Company;
use App\Country;
use App\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factory;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies')->delete();
        \DB::statement('ALTER TABLE companies AUTO_INCREMENT = 1');

        $package = \App\Package::orderBy('id', 'asc')->first();
        $packages = \App\Package::pluck('id');

        $company = Company::create([
            'company_name' => 'froiden',
            'company_email' => 'admin@example.com',
            'company_phone' => '1212121212',
            'address' => 'Company address',
            'website' => 'www.froiden.com',
            'timezone' => 'Asia/Kolkata',
            'package_id' => $package->id
        ]);

        // Add default company

        // $companies = factory(Company::class, 5)->create([
        //     'package_id' => $packages->random(),
        // ]);

        // $companies->prepend($company);
    }
}
