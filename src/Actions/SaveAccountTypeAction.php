<?php

namespace Mawuekom\Usercare\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Usercare\DataTransferObjects\AccountTypeDTO;
use Mawuekom\Usercare\Facades\Usercare;

class SaveAccountTypeAction
{
    /**
     * Execute action
     *
     * @param int|string|null $id
     * @param \Mawuekom\Usercare\DataTransferObjects\AccountTypeDTO $accountTypeDTO
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(AccountTypeDTO $accountTypeDTO, $id = null): Model
    {
        $accountType = data_helpers(config('usercare.account_type.model')) ->getModelInstance($id);
        
        $accountType ->name         = $accountTypeDTO ->name;
        $accountType ->slug         = $accountTypeDTO ->slug;
        $accountType ->description  = $accountTypeDTO ->description;

        $accountType ->save();

        return $accountType;
    }

}