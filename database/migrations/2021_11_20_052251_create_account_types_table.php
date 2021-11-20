<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $uuidEnabled            = config('custom-user.uuids.enabled');
        $uuidColumn             = config('custom-user.uuids.column');

        $accountTypeEnabled     = config('usercare.account_type.enabled');
        $accountTypesTable      = config('usercare.account_type.table.name');
        $accountTypesTablePK    = config('usercare.account_type.table.primary_key');

        if ($accountTypeEnabled) {
            Schema::create($accountTypesTable, function (Blueprint $table) 
            use ($accountTypesTablePK, $uuidEnabled, $uuidColumn) {
                $table->id($accountTypesTablePK);

                if ($uuidEnabled && $uuidColumn !== null) {
                    $table->uuid($uuidColumn);
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
        $accountTypesTable  = config('usercare.account_type.table.name');

        Schema::dropIfExists($accountTypesTable);
    }
}
