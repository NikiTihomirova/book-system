<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToBooksTable extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('image')->nullable()->after('price'); // Добавяме колоната image
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
