<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->integer('api_id')->nullable()->unique();
            $table->string('uid');
            $table->date('start_date');
            $table->decimal('capital_amount', 12, 2);
            $table->string('status');
            $table->foreignId('fund_id')->constrained()->cascadeOnDelete();
            $table->foreignId('investor_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
