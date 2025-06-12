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
        Schema::create('userorders', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->unsignedInteger('id_order')->unique('id_order');
            $table->unsignedInteger('id_user')->unique('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userorders');
    }
};
