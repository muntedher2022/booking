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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment('رقم المستخدم');
            $table->string('department_name')->nullable()->comment('اسم الدائرة');
            $table->string('recipient_type')->nullable()->comment('نوع الكتاب داخلي او خارجي');
            $table->timestamps();

            $table->index('department_name');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
