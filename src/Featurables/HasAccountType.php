<?php

namespace Mawuekom\Usercare\Featurables;

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
        $account_type_model = config('usercare.account_type.model');
        $users_table_account_type_fk = config('usercare.user.table.user_foreign_key');
        $account_type_pk = config('usercare.account_type.table.primary_key');

        return $this ->belongsTo($account_type_model, $users_table_account_type_fk, $account_type_pk);
    }
}