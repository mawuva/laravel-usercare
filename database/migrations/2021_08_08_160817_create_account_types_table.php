<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $account_types_enable      = config('usercare.account_type.enable');

        $table                     = config('usercare.account_type.table.name');
        $account_types_table_pk    = config('usercare.account_type.table.primary_key');

        $uuid_enable               = config('usercare.uuids.enable');
        $uuid_column               = config('usercare.uuids.column');

        if ($account_types_enable && !Schema::hasTable($table)) {
            Schema::create($table, function (Blueprint $table) 
            use ($account_types_table_pk, $uuid_enable, $uuid_column) {
                
                $table->id($account_types_table_pk) ->unsigned();

                if ($uuid_enable && $uuid_column !== null) {
                    $table->uuid($uuid_column);
                }

                $table->string('name');
                $table->string('slug')->unique();
                $table->string('description')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('usercare.account_type.table.name');

        Schema::dropIfExists($table);
    }
}
