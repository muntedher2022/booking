<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_email_counts', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('تاريخ اليوم');
            $table->integer('count')->default(0)->comment('عدد الرسائل المرسلة');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_email_counts');
    }
};
