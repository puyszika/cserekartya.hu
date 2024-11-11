<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPathColumnToImagesTable extends Migration
{
public function up()
{
Schema::table('images', function (Blueprint $table) {
$table->string('path', 500)->nullable();
});
}

public function down()
{
Schema::table('images', function (Blueprint $table) {
$table->dropColumn('path');
});
}
}
