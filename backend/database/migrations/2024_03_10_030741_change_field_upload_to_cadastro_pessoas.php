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
        Schema::table('cadastro_pessoas', function (Blueprint $table) {
            $table->dropColumn('upload');
            $table->json('uploads')->nullable();
        });;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cadastro_pessoas', function (Blueprint $table) {
            $table->dropColumn('uploads');
            $table->string('upload');
        });
    }
};