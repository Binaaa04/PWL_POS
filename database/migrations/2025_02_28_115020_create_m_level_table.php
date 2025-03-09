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
        Schema::create('m_level', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id'); 
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
            $table->id('level_id');
            $table->string('level_kode',10)->unique();
            $table->string('level_nama',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_level');
    }
};
