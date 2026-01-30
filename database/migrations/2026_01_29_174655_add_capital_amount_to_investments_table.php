<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->decimal('capital_amount', 15, 2)->nullable(); // adjust precision if needed
        });
    }

    public function down()
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn('capital_amount');
        });
    }
};
