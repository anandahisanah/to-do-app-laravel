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
        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->uuid('uuid');
            // item
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('todos', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->uuid();
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->unsignedBigInteger('created_user_id');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('assignee_id');
            $table->foreign('assignee_id')->references('id')->on('users');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            // item
            $table->string('title');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
        Schema::dropIfExists('statuses');
    }
};
