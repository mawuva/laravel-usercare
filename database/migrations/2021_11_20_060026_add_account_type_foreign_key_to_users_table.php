<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountTypeForeignKeyToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usersTable                 = config('custom-user.user.table.name');
        $usersTableAccountTypeFK    = config('usercare.user.table.account_type_foreign_key');

        $accountTypeEnabled         = config('usercare.account_type.enabled');
        $accountTypesTable          = config('usercare.account_type.table.name');
        $accountTypesTablePK        = config('usercare.account_type.table.primary_key');

        if ($accountTypeEnabled) {
            Schema::table($usersTable, function (Blueprint $table) 
            use ($usersTableAccountTypeFK, $accountTypesTable, $accountTypesTablePK) {
                $table->unsignedBigInteger($usersTableAccountTypeFK)->nullable() ->after('remember_token');
                $table->foreign($usersTableAccountTypeFK)
                        ->references($accountTypesTablePK)
                        ->on($accountTypesTable);
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
        $usersTable                 = config('custom-user.user.table.name');
        $usersTableAccountTypeFK    = config('usercare.user.table.account_type_foreign_key');

        Schema::table($usersTable, function (Blueprint $table) use ($usersTableAccountTypeFK) {
            $table ->dropColumn($usersTableAccountTypeFK);
        });
    }
}
