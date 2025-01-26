<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    public function up()
    {
        // Добавяме колоната role_id към таблицата users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles')->after('email'); // Добавяме след email
        });
    }

    public function down()
    {
        // Премахваме колоната role_id, ако миграцията се откатери
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });
    }
}
