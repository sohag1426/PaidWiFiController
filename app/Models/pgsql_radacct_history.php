<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class pgsql_radacct_history extends Model
{
    use HasFactory;

    /**
     * The model type
     *
     * @var string|null (node|central|node_pgsql)
     */
    protected $modelType = 'node_pgsql';

    /**
     * Set connection for Node Model
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        if (Auth::user()) {

            $operator = Auth::user();

            $this->connection = $operator->pgsql_connection;
        } else {
            $this->connection = 'pgsql';
        }

        parent::__construct($attributes);
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
