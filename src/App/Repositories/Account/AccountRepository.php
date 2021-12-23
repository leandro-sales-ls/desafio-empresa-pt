<?php

namespace App\Repositories\Account;

use App\Models\Account;

class AccountRepository 
{

    public function getByID($id)
    {
        $account = new Account ();
        return $account->find($id);
    }

    public function select()
    {
        $account = new Account ();
        return $account->select();
    }

    public function insert($param)
    {
        $account = new Account ();
        return $account->insert($param);
    }

    public function update($id, $info)
    {
        $account = new Account ();
        return $account->update($id, $info);
    }

}