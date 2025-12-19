<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('waste_logs', function (Blueprint $table) {
            $table->id();
            $table->string('food_category');
            $table->float('weight');
            $table->string('image_path');
            $table->text('suggestion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('waste_logs');
    }
};
