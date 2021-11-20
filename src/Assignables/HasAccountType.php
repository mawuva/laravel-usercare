<?php

namespace Mawuekom\Usercare\Assignables;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAccountType
{
    /**
     * User belongs to account type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountType(): BelongsTo
    {
        $accountTypeModel           = config('usercare.account_type.model');
        $usersTableAccountTypeFK    = config('usercare.user.table.account_type_foreign_key');
        $accountTypesTablePK        = config('usercare.account_type.table.primary_key');

        return $this ->belongsTo($accountTypeModel, $usersTableAccountTypeFK, $accountTypesTablePK);
    }
}