<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usersTable             = config('custom-user.user.table.name');
        $usersTablePK           = config('custom-user.user.table.primary_key');

        $uuidEnabled            = config('custom-user.uuids.enabled');
        $uuidColumn             = config('custom-user.uuids.column');

        $profileEnabled         = config('usercare.user.profile.enabled');
        $profilesTable          = config('usercare.user.profile.table.name');
        $profilesTablePK        = config('usercare.user.profile.table.primary_key');
        $profilesTableUserFK    = config('usercare.user.profile.table.user_foreign_key');

        if ($profileEnabled) {
            Schema::create($profilesTable, function (Blueprint $table) 
            use ($profilesTablePK, $uuidEnabled, $uuidColumn, $profilesTableUserFK, 
                $usersTablePK, $usersTable) {
                $table->id($profilesTablePK);

                if ($uuidEnabled && $uuidColumn !== null) {
                    $table->uuid($uuidColumn);
                }

                $table->string('location');
                $table->text('bio')->nullable();
                $table->text('description')->nullable();
                $table->unsignedBigInteger($profilesTableUserFK);

                $table->foreign($profilesTableUserFK)
                        ->references($usersTablePK)
                        ->on($usersTable)
                        ->onDelete('cascade');

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
        $profilesTable  = config('usercare.user.profile.table.name');

        Schema::dropIfExists($profilesTable);
    }
}
