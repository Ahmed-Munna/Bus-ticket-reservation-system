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
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->enum('seat_layout', ['2 x 2', '2 x 3','3 x 2', '3 x 3', '1 x 2', '1 x 3'])->default('2 x 2');
            $table->string('number_of_seats');
            $table->boolean('status')->default(1);
            $table->boolean('has_ac')->default(0);
            $table->timestamps();

            $table->index(['id', 'slug', 'status', 'has_ac']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};
