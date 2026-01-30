<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->foreignId('fund_id')->nullable()->change();
            $table->foreignId('investor_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->foreignId('fund_id')->nullable(false)->change();
            $table->foreignId('investor_id')->nullable(false)->change();
        });
    }
};
