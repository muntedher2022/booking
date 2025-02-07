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
        Schema::create('incomingbooks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('رقم المستخدم');
            $table->string('book_number')->unique()->comment('رقم الكتاب');
            $table->date('book_date')->comment('تاريخ الكتاب');
            $table->text('subject')->comment('موضوع الكتاب');
            $table->text('content')->nullable()->comment('جزء من المتن');
            $table->text('keywords')->nullable()->comment('كلمات مفتاحية');
            $table->unsignedBigInteger('related_book_id')->nullable()->constrained('outgoing_books')->comment('رقم الكتاب المرتبط');
            $table->string('sender_type')->nullable()->comment('نوع الكتاب داخلي او خارجي');
            $table->text('sender_id')->comment('الجهة الوارد منها الكتاب');
            $table->string('attachment')->nullable()->comment('صورة الكتاب الوارد');
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('book_number');
            $table->index('related_book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomingbooks');
    }
};
