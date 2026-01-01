<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('activity_date');
            $table->string('activity_type');
            $table->timestamps();
            
            $table->unique(['user_id', 'activity_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_log');
    }
};