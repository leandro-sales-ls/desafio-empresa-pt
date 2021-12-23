<?php

namespace App\Models;

use Bootstrap\Database\Sql\IdModel;

/**
 * Model to access the Stage data
 *
 * @author Joao Pedro Beltrame
 */
class Account extends IdModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account';

    protected $fillables = [
        'id',
        'firstName',
        'lastName',
        'email',
        'age',
        'password'
    ];

    protected $timestamps = true;
}