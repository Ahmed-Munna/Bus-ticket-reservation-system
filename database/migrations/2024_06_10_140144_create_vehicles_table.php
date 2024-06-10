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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_name');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->string('registration_number');
            $table->string('chasis_number');
            $table->string('engine_number');
            $table->string('model');
            $table->string('owner_name');
            $table->string('owner_phone');
            $table->string('brand_name');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->index(['id', 'vehicle_type_id', 'status']);

            $table->foreign('vehicle_type_id')
                ->references('id')
                ->on('vehicle_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
