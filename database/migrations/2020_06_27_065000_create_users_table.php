<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->nullable()->constrained();
            $table->foreignId('job_id')->nullable()->constrained();
            $table->foreignId('role_id')->default(1);
            $table->string('name');
            $table->longText('avatar')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('userId')->unique();
            $table->string('nation');
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('birthday')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('approved')->default('0');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('approved_at')->nullable();
            $table->softDeletes('deleted_at', 0);
            $table->string('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
