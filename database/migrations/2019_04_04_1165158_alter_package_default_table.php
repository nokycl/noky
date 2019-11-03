<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPackageDefaultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->enum('default', ['yes', 'no'])->nullable()->default('no')->after('stripe_monthly_plan_id');
        });

        // $currency = \App\Currency::first();

        $packages = new \App\Package();
        $packages->name                    = 'Default';
        // $packages->currency_id             = $currency->id;
        $packages->description             = 'Its a default package and cannot be deleted';
        $packages->annual_price            = 0;
        $packages->monthly_price           = 0;
        $packages->max_employees           = 20;
        $packages->stripe_annual_plan_id   = 'default_plan';
        $packages->stripe_monthly_plan_id  = 'default_plan';
        $packages->default                 = 'yes';
        $packages->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('default');
        });
    }
}
