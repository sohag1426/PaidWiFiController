<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recharge_card extends Model
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
     * Get the Package that owns the recharge card.
     */
    public function package()
    {
        return $this->belongsTo(package::class)->withDefault();
    }

    /**
     * Get the distributor that owns the recharge card.
     */
    public function distributor()
    {
        return $this->belongsTo(card_distributor::class, 'card_distributor_id', 'id')->withDefault();
    }
}
