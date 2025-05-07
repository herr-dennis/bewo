<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWiederkehrendToTermineTable extends Migration
{
/**
* Run the migrations.
*/
public function up(): void
{
Schema::table('termine', function (Blueprint $table) {
$table->boolean('wiederkehrend')->default(false)->after('datum');
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::table('termine', function (Blueprint $table) {
$table->dropColumn('wiederkehrend');
});
}
}
