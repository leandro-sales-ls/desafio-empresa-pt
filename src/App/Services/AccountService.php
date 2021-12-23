<?php

namespace App\Services;

use App\Repositories\Account\AccountRepository;

class AccountService
{
    public function getByID($id)
    {
        $account = new AccountRepository();
        return $account->getByID($id);
    }

    public function get()
    {
        $account = new AccountRepository();
        return $account->select();
    }

    public function create(array $param)
    {
        $account = new AccountRepository();
        return $account->insert($param);
    }

    public function update($id, array $param)
    {
        $account = new AccountRepository();
        return $account->update($id, $param);
    }
}
