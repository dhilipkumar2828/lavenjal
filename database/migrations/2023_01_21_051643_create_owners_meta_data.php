<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    

    public function up()
    {
        Schema::create('owners_meta_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('user_type', ['distributor','delivery_agent','retailer']);
            $table->string('name_of_shop');
            $table->string('nature_of_shop');
            $table->enum('ownership_type', ['Proprietorshhip', 'Partnership']);
            $table->string('name_of_owner');
            $table->string('owner_contact_no');
            $table->text('owner_email');
            $table->text('full_address');
            $table->text('pincode');
            $table->text('lat');
            $table->text('lang');
            $table->text('landmark');
            $table->text('area_sqft');
            $table->text('storage_capacity');
            $table->integer('selling_jars_weekly');
            $table->text('delivery_type');
            $table->integer('no_of_delievery_boys');
            $table->text('delievery_range');
            $table->text('gst_no');
            $table->text('gst_certificate');
            $table->text('govt_certificate');
            $table->nullableTimestamps('shop_started_at');//ts
            $table->text('shop_photo');
            $table->nullableTimestamps('agreement_date');//ts
            $table->text('additional_info');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owners_meta_data');
    }
};
