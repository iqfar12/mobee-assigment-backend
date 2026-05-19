<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_likes', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1)->after('car_id');
        });

        Schema::dropIfExists('car_dislikes');
    }

    public function down(): void
    {
        Schema::table('car_likes', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::create('car_dislikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'car_id']);
        });
    }
};
