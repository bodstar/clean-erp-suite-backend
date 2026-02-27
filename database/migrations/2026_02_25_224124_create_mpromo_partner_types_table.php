<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mpromo_partner_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();   // CHILLER, ICE_WATER_SELLER
            $table->string('label');            // Chiller, Ice Water Seller
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpromo_partner_types');
    }
};
