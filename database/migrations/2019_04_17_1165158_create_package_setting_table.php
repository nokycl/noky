<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `packages` CHANGE `default` `default` ENUM('yes','no','trial') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'no'");

        Schema::create('package_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->integer('no_of_days')->nullable()->default(30);
            $table->string('modules', 1000)->nullable()->default(null);
            $table->timestamps();
        });

        $packageSetting = new \App\PackageSetting();
        $packageSetting->status = 'inactive';
        $packageSetting->no_of_days = 30;
        $packageSetting->modules = null;
        $packageSetting->save();


        $packages = new \App\Package();
        $packages->name                    = 'Trial';
        // $packages->currency_id             = $currency->id;
        $packages->description             = 'Its a trial package';
        $packages->annual_price            = 0;
        $packages->monthly_price           = 0;
        $packages->max_employees           = 20;
        $packages->stripe_annual_plan_id   = 'trial_plan';
        $packages->stripe_monthly_plan_id  = 'trial_plan';
        $packages->default                 = 'trial';
        $packages->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_settings');

    }
}
