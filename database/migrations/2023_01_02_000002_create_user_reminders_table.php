<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('reminder_id')->constrained()->onDelete('cascade');
            $table->timestamp('viewed_at')->nullable();
            $table->boolean('marked_as_read')->default(false);
            $table->timestamps();
            
            $table->unique(['user_id', 'reminder_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_reminders');
    }
};