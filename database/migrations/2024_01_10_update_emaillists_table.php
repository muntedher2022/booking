<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('emaillists', function (Blueprint $table) {
            $table->dropColumn('department');
            $table->string('type')->default('section'); // 'section' or 'department'
            $table->unsignedBigInteger('reference_id'); // Will store either section_id or department_id
        });
    }

    public function down()
    {
        Schema::table('emaillists', function (Blueprint $table) {
            $table->unsignedBigInteger('department');
            $table->dropColumn(['type', 'reference_id']);
        });
    }
};
