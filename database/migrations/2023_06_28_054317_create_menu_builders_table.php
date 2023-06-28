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
        Schema::create('menu_builders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained();
            $table->foreignId('role_id')->constrained();
            $table->foreignId('route_id')
                ->nullable()
                ->constrained();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('menu_builders');
            $table->string('text', 50);
            $table->string('icon', 50)->nullable();
            $table->string('target', 10)->nullable();
            $table->unsignedInteger('order');
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_builders');
    }
};
