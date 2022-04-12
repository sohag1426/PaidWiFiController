<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_payment extends Model
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
     * Get the recharge card that owns the payment.
     */
    public function recharge_card()
    {
        return $this->belongsTo(recharge_card::class, 'recharge_card_id', 'id')->withDefault();
    }

    /**
     * Get the payment gateway that owns the payment.
     */
    public function payment_gateway()
    {
        return $this->belongsTo(payment_gateway::class, 'payment_gateway_id', 'id')->withDefault();
    }

    /**
     * Get the operator that owns the payment.
     */
    public function operator()
    {
        return $this->belongsTo(operator::class, 'operator_id', 'id')->withDefault();
    }

    /**
     * Get the package that owns the payment.
     */
    public function package()
    {
        return $this->belongsTo(package::class, 'package_id', 'id')->withDefault();
    }
}
