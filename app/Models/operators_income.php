<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class operators_income extends Model
{
    use HasFactory;

    /**
     * The model type
     *
     * @var string|null (node|central)
     */
    protected $modelType = 'central';

    /**
     * Set connection for Central Model if (host_type === 'node')
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        if (config('local.host_type', 'central') === 'node') {
            if ($this->modelType === 'central') {
                $this->connection = config('database.central', 'mysql');
            }
        }

        parent::__construct($attributes);
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the customer_payment that owns the operators_income.
     */
    public function payment()
    {
        return $this->belongsTo(customer_payment::class, 'payment_id', 'id')->withDefault();
    }

    /**
     * Get the operator that owns the operators_income.
     */
    public function source_operator()
    {
        return $this->belongsTo(operator::class, 'source_operator_id', 'id')->withDefault();
    }
}
