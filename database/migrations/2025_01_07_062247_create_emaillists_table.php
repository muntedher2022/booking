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

        Schema::create('emaillists', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment('رقم المستخدم');
            $table->string('department')->nullable()->comment('القسم');
            $table->string('email')->nullable()->comment('البريد الإلكتروني');
            $table->text('notes')->nullable()->comment('ملاحظات');
            $table->timestamps();
            $table->index('department');
            $table->index('email');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emaillists');
    }
};
