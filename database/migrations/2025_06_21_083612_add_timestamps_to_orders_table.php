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
          if (!Schema::hasColumn('orders', 'created_at') && !Schema::hasColumn('orders', 'updated_at')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      if (Schema::hasColumn('orders', 'created_at') && Schema::hasColumn('orders', 'updated_at')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }
    }
};