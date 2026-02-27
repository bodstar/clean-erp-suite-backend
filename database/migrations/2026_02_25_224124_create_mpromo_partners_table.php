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
        Schema::create('mpromo_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('partner_type_id');
            $table->unsignedInteger('status_id');

            $table->string('name');
            $table->string('phone', 30)->index();
            $table->string('location_text')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamp('geolocation_captured_at')->nullable();

            $table->timestamp('last_activity_at')->nullable()->index();

            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('partner_type_id')->references('id')->on('mpromo_partner_types')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('mpromo_partner_statuses')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index(['team_id', 'partner_type_id']);
            $table->index(['team_id', 'status_id']);
            $table->index(['team_id', 'partner_type_id', 'status_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpromo_partners');
    }
};
