<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountTypeForeignKeyToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table                         = config('usercare.user.table.name');

        $account_types_enable          = config('usercare.account_type.enable');
        $account_types_table           = config('usercare.account_type.table.name');
        $account_types_table_pk        = config('usercare.account_type.table.primary_key');

        $users_table_account_type_fk   = config('usercare.user.table.account_type_foreign_key');

        if (account_type_is_enabled_and_exists()) {
            Schema::table($table, function (Blueprint $table) 
            use ($account_types_table, $users_table_account_type_fk, $account_types_table_pk) {
                $table->unsignedBigInteger($users_table_account_type_fk)->unsigned()->index() ->nullable() ->after('remember_token');
                $table->foreign($users_table_account_type_fk)->references($account_types_table_pk)->on($account_types_table);
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
        $table                         = config('usercare.user.table.name');
        $users_table_account_type_fk   = config('usercare.user.table.account_type_foreign_key');

        Schema::table($table, function (Blueprint $table) use ($users_table_account_type_fk) {
            $table ->dropColumn($users_table_account_type_fk);
        });
    }
}
